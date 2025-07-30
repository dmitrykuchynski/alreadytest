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
            'posts_per_page' => 4,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

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

        if (!empty($filters['min_price']) || !empty($filters['max_price'])) {
            $metaQuery = [];

            if (!empty($filters['min_price'])) {
                $metaQuery[] = [
                    'key'     => 'price',
                    'value'   => (int) $filters['min_price'],
                    'compare' => '>=',
                    'type'    => 'NUMERIC',
                ];
            }

            if (!empty($filters['max_price'])) {
                $metaQuery[] = [
                    'key'     => 'price',
                    'value'   => (int) $filters['max_price'],
                    'compare' => '<=',
                    'type'    => 'NUMERIC',
                ];
            }

            $args['meta_query'] = $metaQuery;
        }

        $query = new \WP_Query($args);

        ob_start();

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
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
}
