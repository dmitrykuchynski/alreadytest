<?php
$offers = get_field('offer');
if ($offers):
    ?>
    <section class="offer-section">
        <?php foreach ($offers as $index => $offer): ?>
            <?php
            $bookie_title = $offer['bookie_title'];
            $bookie_image = $offer['bookie_image'];
            $rating = $offer['rating'];
            $stars = round($rating);
            $welcome_bonus_text = $offer['welcome_bonus_text'];
            $offer_title = $offer['offer_title'];
            $offer_description = $offer['offer_description'];
            $more_info = $offer['more_info'];
            $cta_button = $offer['cta_button'];
            $cta_button_color = $offer['cta_button_color'];
            $read_review = $offer['read_review'];
            $key_features = $offer['key_features'];
            $payment_methods = $offer['payment_methods'];
            $pros = $offer['pros'];
            $cons = $offer['cons'];
            $is_best_bonus = $offer['best_bonus'];
            $bonus_badge = $offer['bonus_badge'];
            ?>

            <div class="offer-card">
                <?php if ($is_best_bonus && !empty($bonus_badge['url'])): ?>
                    <div class="offer-card__badge">
                        <img src="<?= esc_url($bonus_badge['url']) ?>" alt="<?= esc_attr($bonus_badge['alt'] ?: 'Best bonus') ?>">
                    </div>
                <?php endif; ?>
                <div class="offer-card__header">
                    <div class="offer-card__header--title">
                        <div class="offer-card__rank">
                            <span class="offer-card__position"><?= $index + 1 ?></span>
                            <?php if ($is_best_bonus): ?>
                                <i class="fa-solid fa-fire-flame-curved offer-card__icon"></i>
                            <?php endif; ?>
                        </div>
                        <h2 class="offer-card__brand"><?= esc_html($bookie_title) ?></h2>
                    </div>
                    <div class="offer-card__rating">
                        <span class="offer-card__score"><?= number_format($rating, 1) ?></span>
                        <span class="offer-card__stars">
                            <?php
                            $filledStars = floor($stars);
                            $hasHalfStar = ($stars - $filledStars) >= 0.5;
                            $totalStars = 5;

                            for ($i = 1; $i <= $totalStars; $i++):
                                if ($i <= $filledStars):
                                    echo '<i class="fas fa-star" style="color: #FF922E;"></i>';
                                elseif ($i == $filledStars + 1 && $hasHalfStar):
                                    echo '<i class="fas fa-star-half-alt" style="color: #FF922E;"></i>';
                                else:
                                    echo '<i class="far fa-star" style="color: #ccc;"></i>';
                                endif;
                            endfor;
                            ?>
                        </span>
                    </div>
                </div>

                <div class="offer-card__main">
                    <?php if ($bookie_image): ?>
                        <div class="offer-card__logo">
                            <img src="<?= esc_url($bookie_image['url']) ?>" alt="<?= esc_attr($bookie_image['alt']) ?>">
                        </div>
                    <?php endif; ?>

                    <div class="offer-card__bonus">
                        <?php if ($welcome_bonus_text): ?>
                            <p class="offer-card__gift">
                                <i class="fas fa-gift"></i> <span><?= esc_html($welcome_bonus_text) ?></span>
                            </p>
                        <?php endif; ?>
                        <h3 class="offer-card__title"><?= esc_html($offer_title) ?></h3>
                        <p class="offer-card__description"><?= esc_html($offer_description) ?></p>
                    </div>

                    <?php if ($key_features): ?>
                        <ul class="offer-card__features">
                            <?php foreach ($key_features as $feature): ?>
                                <li><i class="fas fa-rocket"></i> <?= esc_html($feature['feature']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php if ($payment_methods): ?>
                        <div class="offer-card__payments">
                            <div class="offer-card__payments-icons">
                                <?php foreach ($payment_methods as $payment): ?>
                                    <?php if ($payment['payment_method_icon']): ?>
                                         <div class="offer-card__payment-icon">
                                            <img src="<?= esc_url($payment['payment_method_icon']['url']) ?>" alt="<?= esc_attr($payment['payment_method_name']) ?>">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="offer-card__more">
                                <button class="offer-card__more-btn">
                                    More info <i class="fa-solid fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="offer-card__actions">
                        <?php if ($cta_button): ?>
                            <a href="<?= esc_url($cta_button['url']) ?>" target="<?= esc_attr($cta_button['target']) ?>" class="offer-card__btn btn" style="background-color: <?= esc_attr($cta_button_color) ?>">
                                <?= esc_html($cta_button['title']) ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($read_review): ?>
                            <a href="<?= esc_url($read_review['url']) ?>" target="<?= esc_attr($read_review['target']) ?>" class="offer-card__link btn">
                                <?= esc_html($read_review['title']) ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="offer-card__details">
                    <?php if ($more_info): ?>
                        <p class="offer-card__text"><?= esc_html($more_info) ?></p>
                    <?php endif; ?>
                    <div class="offer-card__pros-cons">
                        <?php if ($pros): ?>
                            <ul class="offer-card__list offer-card__list--pros">
                                <?php foreach ($pros as $item): ?>
                                    <li><i class="fas fa-thumbs-up"></i> <?= esc_html($item['pros_item']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if ($cons): ?>
                            <ul class="offer-card__list offer-card__list--cons">
                                <?php foreach ($cons as $item): ?>
                                    <li><i class="fas fa-thumbs-down"></i> <?= esc_html($item['cons_item']) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
