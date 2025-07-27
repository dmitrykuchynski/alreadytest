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
<header class="header">
    <div class="container-full 3xl:container">
        <div class="header__menu-wrapper">
            <!--Theme switch-->
            <div class="theme-switch">
                <input type="checkbox" id="theme-toggle" name="theme-switch" class="theme-switch__input" />
                <label for="theme-toggle" class="theme-switch__label">
                        <span><?= get_theme_switcher_icon();?></span>
                </label>
            </div>
            <div class="header__menu-desktop">
                <div class="header__logo"><?= Header::getLogo() ?></div>
                <div class="header__menu--left"><?php Menu::get_header_menu(); ?></div>
                <div class="header__menu--right">
	                <?= Menu::get_header_btn('header__btn btn btn--primary btn--md'); ?>
                </div>
            </div>
        </div>
    </div>
</header>


