<?php
use \App\Controller\Footer;
use \App\Base\Menu;

?>
<footer class="footer">
    <div class="container-full">
        <div class="footer__wrapper">
            <div class="footer__bottom">
                <div class="footer__bottom-grid">
                    <div class="footer__info">
                        <div class="footer__logo"><?= Footer::getLogo() ?></div>
                        <address class="footer__info-address"><?= Footer::getCompanyAddress() ?></address>
                        <address class="footer__info-email"><?= Footer::getCompanyEmail() ?></address>
                    </div>
                    <div class="footer__menu">
                        <h4 class="footer__menu-title"><?= __( 'Меню', TM_TEXTDOMAIN ) ?></h4>
                        <?php Menu::get_footer_menu() ?>
                    </div>
                    <div class="footer__contacts">
                        <?= Footer::getFooterContacts() ?>
                        <address class="footer__contacts-email"><?= Footer::getCompanyEmail() ?></address>
                        <?= Footer::getFooterSocialLinks() ?>
                        <h4 class="footer__contacts-address-label"><?=  __( 'Адрес', TM_TEXTDOMAIN ) ?></h4>
                        <address class="footer__contact-address"><?= Footer::getCompanyAddress() ?></address>
                    </div>
                </div>
                <div class="footer__copyright"><?= Footer::getCopyright() ?></div>
            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
