<?php
namespace App\CF7;

use WPCF7_ContactForm;

class CF7CustomFields
{

    public function __construct()
    {
        add_filter('wpcf7_editor_panels', [$this, 'add_cf7_panel'], 1);
        add_action('save_post', [$this, 'save_wpcf7_custom_fields']);
        add_filter('wpcf7_form_class_attr', [$this, 'addCustomClass'], 10, 2);
    }


    public function addCustomClass($html_class): string
    {
        $wpcf7_form_id = WPCF7_ContactForm::get_current()->id;
        $customClass = get_field('sumato_custom_class', $wpcf7_form_id);
        $html_class .= " $customClass";
        return $html_class;
    }

    public function wpcf7_custom_fields ($post) {
        ?>
        <h2><?php echo esc_html( __( 'Custom fields') ); ?></h2>
        <fieldset>
            <p class="description">
                <label for="sumato-custom-class">Custom Class</label><br>
                <input type="text" class="large-text" id="sumato-custom-class" name="sumato-custom-class" value="<?php echo get_post_meta($post->id(), 'sumato_custom_class', true) ?>"/>
            </p>
        </fieldset>
        <?php
    }

    public function add_cf7_panel ($panels) {
        $panels['d365_integration'] = array(
            'title' => 'Custom Fields',
            'callback' => [$this, 'wpcf7_custom_fields'],
        );

        return $panels;
    }


    public function save_wpcf7_custom_fields($post_id) {

        $post_type = get_post_type($post_id);

        if ($post_type = "wpcf7_contact_form") {
            if (array_key_exists('sumato-custom-class', $_POST)) {
                update_post_meta($post_id, 'sumato_custom_class', $_POST['sumato-custom-class']
                );
            }
        }
    }
}
