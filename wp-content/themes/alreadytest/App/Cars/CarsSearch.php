<?php

namespace App\Cars;

class CarsSearch
{
    public function __construct()
    {
        add_action('wp_ajax_alreadymedia_update_cars_search_results', [$this, 'ajaxCarSearch']);
        add_action('wp_ajax_nopriv_alreadymedia_update_cars_search_results', [$this, 'ajaxCarSearch']);
    }

    public function carSearchResults(array $filters = []): string
    {
        $args = [
            'post_type'      => 'cars',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

        // build taxonomy query
        $taxQuery = [];
        foreach (get_object_taxonomies('cars', 'names') as $taxonomy) {
            if (!empty($filters[$taxonomy])) {
                $taxQuery[] = [
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => (array) $filters[$taxonomy],
                ];
            }
        }

        if (!empty($taxQuery)) {
            $args['tax_query'] = array_merge(['relation' => 'AND'], $taxQuery);
        }

        // pre-query for posts matching taxonomies
        $preQuery = new \WP_Query(array_merge($args, ['fields' => 'ids']));
        $postIds = $preQuery->posts;

        // collect prices per post
        $prices = [];
        $postPrices = [];
        foreach ($postIds as $postId) {
            $price = get_field('price', $postId);
            $cleanPrice = (int) str_replace([',', ' '], '', $price);

            if (is_numeric($cleanPrice)) {
                $prices[] = $cleanPrice;
                $postPrices[$postId] = $cleanPrice;
            }
        }

        $minAvailable = !empty($prices) ? min($prices) : 0;
        $maxAvailable = !empty($prices) ? max($prices) : PHP_INT_MAX;

        // sanitize user input
        $userMin = isset($filters['min_price']) ? (int) str_replace(',', '', $filters['min_price']) : $minAvailable;
        $userMax = isset($filters['max_price']) ? (int) str_replace(',', '', $filters['max_price']) : $maxAvailable;

        $minPriceFilter = max($minAvailable, $userMin);
        $maxPriceFilter = min($maxAvailable, $userMax);

        // filter by acf price
        $filteredPostIds = [];

        foreach ($postPrices as $postId => $price) {
            if ($minPriceFilter === $maxPriceFilter) {
                if ($price === $maxPriceFilter) {
                    $filteredPostIds[] = $postId;
                }
            } else {
                if ($price >= $minPriceFilter && $price <= $maxPriceFilter) {
                    $filteredPostIds[] = $postId;
                }
            }
        }

        if (empty($filteredPostIds)) {
            $filteredPostIds = [0];
        }

        // final query
        $resultQuery = new \WP_Query([
            'post_type'      => 'cars',
            'post__in'       => $filteredPostIds,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'posts_per_page' => 4,
        ]);

        // for frontend JS
        $currency_symbol = '$';
        $priceFilterData = [
            'min_price' => [
                'min'         => $minAvailable,
                'max'         => $maxAvailable,
                'placeholder' => esc_html__('Min ', 'alreadymedia') . self::formatPrice($minAvailable) . $currency_symbol,
            ],
            'max_price' => [
                'min'         => $minAvailable,
                'max'         => $maxAvailable,
                'placeholder' => esc_html__('Max ', 'alreadymedia') . self::formatPrice($maxAvailable) . $currency_symbol . ' +',
            ],
        ];

        if (defined('DOING_AJAX') && DOING_AJAX && isset($_POST['get_price_range'])) {
            wp_send_json_success($priceFilterData);
        }

        // output cards
        ob_start();

        if ($resultQuery->have_posts()) {
            while ($resultQuery->have_posts()) {
                $resultQuery->the_post();
                include get_template_directory() . '/templates/partials/cars-search-result-cards.php';
            }
            wp_reset_postdata();
        } else {
            echo '<p>No cars found.</p>';
        }

        return ob_get_clean();
    }

    public function ajaxCarSearch()
    {
        check_ajax_referer('alreadymedia_nonce', 'nonce');

        $filters = $_POST['filters'] ?? [];

        $html = $this->carSearchResults($filters);

        wp_send_json_success([
            'html' => $html,
        ]);
    }

    public static function formatPrice($price)
    {
        if ((int)$price != $price) {
            return number_format($price, 2);
        } else {
            return number_format($price);
        }
    }
}
