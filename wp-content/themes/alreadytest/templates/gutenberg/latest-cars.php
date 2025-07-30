<?php
/**
 * Latest cars block
 *
 */

use App\Cars\CarsSearch;
?>

<div class="container">
    <div id="alreadymedia-car-search" class="alreadymedia-car-search">
        <form class="alreadymedia-car-search__form">
        <div class="alreadymedia-car-search__form-wrap">
            <div class="alreadymedia-car-search__field-groups">
                <?php
                $taxonomies = get_object_taxonomies('cars', 'names');

                foreach ($taxonomies as $taxonomy) {
                    $terms = get_terms([
                        'taxonomy' => $taxonomy,
                        'hide_empty' => false,
                    ]);

                    if (empty($terms) || is_wp_error($terms)) continue;

                    $label = ucfirst(str_replace('car_', '', $taxonomy));
                    ?>
                    <div class="alreadymedia-car-search__field-group">
                        <div class="alreadymedia-car-search__field">
                            <label>
                            <span class="alreadymedia-car-search__field-label-span">
                                <?php echo esc_html($label); ?>
                            </span>
                                <select name="<?php echo esc_attr($taxonomy); ?>" multiple
                                        id="<?php echo esc_attr($taxonomy); ?>"
                                        data-filter-name="<?php echo esc_attr($taxonomy); ?>"
                                        data-search="true"
                                        data-placeholder="<?php esc_attr_e('Select', 'alreadymedia'); ?>">
                                    <?php foreach ($terms as $term): ?>
                                        <option value="<?php echo esc_attr($term->slug); ?>">
                                            <?php echo esc_html($term->name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </label>
                        </div>
                    </div>
                <?php } ?>

                <div class="alreadymedia-car-search__field-group">
                    <label>
                    <span class="alreadymedia-car-search__field-label-span">
                        <?php esc_html_e('Price Range', 'alreadymedia'); ?>
                    </span>
                    </label>
                    <div class="alreadymedia-car-search__field-group-row">
                        <div class="alreadymedia-car-search__field">
                            <input type="text" data-filter-type="price" name="min_price"
                                   data-filter-name="min_price">
                        </div>
                        <span class="alreadymedia-car-search__field-group-separator">
                        <?php esc_html_e('to', 'alreadymedia'); ?>
                    </span>
                        <div class="alreadymedia-car-search__field">
                            <input type="text" data-filter-type="price" name="max_price"
                                   data-filter-name="max_price">
                        </div>
                    </div>
                </div>
            </div>

            <div class="alreadymedia-car-search__buttons-group">
                <button class="alreadymedia-car-search__reset" type="reset">
                    <?php esc_html_e('Clear filters', 'alreadymedia'); ?>
                </button>
                <button class="alreadymedia-car-search__apply" type="submit">
                    <?php esc_html_e('Apply filters', 'alreadymedia'); ?>
                </button>
            </div>
        </div>
    </form>
    </div>
    <div class="alreadymedia-list-of-cars">
        <div class="alreadymedia-list-of-cars__wrap">
            <div class="alreadymedia-list-of-cars__cards">
                <?php
                    $search = new CarsSearch();
                    $cars = $search->carSearchResults();
                    echo $cars;
                ?>
            </div>
            <div class="alreadymedia-list-of-cars__loader">
                <div class="alreadymedia-list-of-cars__loader-spinner">
                    <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="44" height="44" fill="white" fill-opacity="0.01"/>
                        <path
                                d="M4.67942 11.9999C6.65723 8.57427 9.60646 5.81202 13.1542 4.06249C16.7018 2.31296 20.6887 1.65473 24.6105 2.17105C28.5322 2.68736 32.2128 4.35502 35.1868 6.96315C38.1608 9.57127 40.2947 13.0027 41.3184 16.8236C42.3422 20.6444 42.21 24.683 40.9385 28.4287C39.667 32.1744 37.3134 35.459 34.1752 37.867C31.0369 40.275 27.2551 41.6984 23.308 41.9571C19.3608 42.2158 15.4256 41.2983 11.9999 39.3205"
                                stroke="#0D6EFD" stroke-width="4"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>