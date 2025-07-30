<?php
$price     = get_field('price', get_the_ID());
$image     = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
$carBrand  = get_the_terms(get_the_ID(), 'car_brand');
$carModel  = get_the_title();
$carType   = get_the_terms(get_the_ID(), 'car_type');
$carYear   = get_the_terms(get_the_ID(), 'car_year');
$carColor  = get_the_terms(get_the_ID(), 'car_color');
$permalink = get_permalink();
?>

<div class="alreadymedia-car-card">
    <div class="alreadymedia-car-card__wrap">
        <a class="alreadymedia-car-card__link" href="<?php echo esc_url($permalink); ?>"></a>

        <div class="alreadymedia-car-card__image">
            <div class="alreadymedia-car-card__image-wrap">
                <?php if ($image): ?>
                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($carModel); ?>">
                <?php endif; ?>
            </div>
        </div>

        <div class="alreadymedia-car-card__price">
            <?php echo $price ? number_format($price, 0, '.', ' ') . ' $' : 'Price on request'; ?>
        </div>

        <div class="alreadymedia-car-card__content">
            <div class="alreadymedia-car-card__content-top">
                <div class="alreadymedia-car-card__title">
                    <?php echo esc_html($carModel); ?>
                </div>

                <div class="alreadymedia-car-card__brand">
                    <?php
                    if (!empty($carBrand) && !is_wp_error($carBrand)) {
                        echo esc_html($carBrand[0]->name);
                    }
                    ?>
                </div>

                <div class="alreadymedia-car-card__type">
                    <?php
                    if (!empty($carType) && !is_wp_error($carType)) {
                        echo esc_html($carType[0]->name);
                    }
                    ?>
                </div>

                <div class="alreadymedia-car-card__color">
                    <?php
                    if (!empty($carColor) && !is_wp_error($carColor)) {
                        echo esc_html($carColor[0]->name);
                    }
                    ?>
                </div>

                <div class="alreadymedia-car-card__year">
                    <?php
                    if (!empty($carYear) && !is_wp_error($carYear)) {
                        echo esc_html($carYear[0]->name);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
