<?php
use \App\Base\Menu;
use App\Controller\Header;

include_once get_template_directory() . '/templates/svg/theme-switcher-icon.php';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php wp_title();?></title>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header id="header">
    <div class="header-container">
        <!-- Logo -->
        <div class="site-logo">
            <a href="<?= esc_url(home_url('/')); ?>">
                <?= Header::getLogo(); ?>
            </a>
        </div>

        <!-- Mobile Burger -->
        <div class="menu-btn">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
    </div>
</header>
