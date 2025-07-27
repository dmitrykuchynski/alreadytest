<?php
/**
 * Generate labels for Custom Post Types & Taxonomies
 */

namespace App\Helpers;

use App\Helpers\Init;

abstract class LabelGenerator implements Init
{
    /**
     * Method that generate labels
     *
     * @param string $type
     * @param string $singular_name
     * @param string $plural_name
     * @return array|void
     */
    public static function generate($type, $singular_name, $plural_name)
    {

        if (empty($type) || empty($singular_name) || empty($plural_name))
            return;

        if ($type == 'post') {
            return self::postLabels($singular_name, $plural_name);
        } elseif ($type == 'taxonomy') {
            return self::taxonomyLabels($singular_name, $plural_name);
        }
    }

    /**
     * That method generate Labels for Custom Post Types
     *
     * @param string $singular_name
     * @param string $plural_name
     * @return array
     */
    public static function postLabels($singular_name, $plural_name)
    {
        return array(
            'name' => esc_html__($plural_name),
            'singular_name' => esc_html__($singular_name),
            'add_new' => esc_html__('Add New', TM_TEXTDOMAIN),
            'add_new_item' => sprintf(esc_html__('Add New %s', TM_TEXTDOMAIN), $singular_name),
            'edit_item' => sprintf(esc_html__('Edit %s', TM_TEXTDOMAIN), $singular_name),
            'new_item' => sprintf(esc_html__('New %s', TM_TEXTDOMAIN), $singular_name),
            'all_items' => sprintf(esc_html__('All %s', TM_TEXTDOMAIN), $plural_name),
            'view_item' => sprintf(esc_html__('View %s', TM_TEXTDOMAIN), $singular_name),
            'search_items' => sprintf(esc_html__('Search %s', TM_TEXTDOMAIN), $plural_name),
            'not_found' => sprintf(esc_html__('No %s found', TM_TEXTDOMAIN), strtolower($plural_name)),
            'not_found_in_trash' => sprintf(esc_html__('No %s found in Trash', TM_TEXTDOMAIN), strtolower($plural_name)),
            'parent_item_colon' => '',
            'menu_name' => esc_html__($plural_name),
        );
    }

    /**
     * That method generate Labels for Custom Taxonomies
     *
     * @param string $singular_name
     * @param string $plural_name
     * @return array
     */
    public static function taxonomyLabels($singular_name, $plural_name)
    {
        return array(
            'name' => esc_html__($plural_name),
            'singular_name' => esc_html__($singular_name),
            'search_items' => sprintf(esc_html__('Search %s', TM_TEXTDOMAIN), $plural_name),
            'all_items' => sprintf(esc_html__('All %s', TM_TEXTDOMAIN), $plural_name),
            'view_item ' => sprintf(esc_html__('View %s ', TM_TEXTDOMAIN), $singular_name),
            'parent_item' => sprintf(esc_html__('Parent %s', TM_TEXTDOMAIN), $singular_name),
            'parent_item_colon' => sprintf(esc_html__('Parent %s :', TM_TEXTDOMAIN), $singular_name),
            'edit_item' => sprintf(esc_html__('Edit %s', TM_TEXTDOMAIN), $singular_name),
            'update_item' => sprintf(esc_html__('Update %s', TM_TEXTDOMAIN), strtolower($singular_name)),
            'add_new_item' => sprintf(esc_html__('Add new %s', TM_TEXTDOMAIN), strtolower($singular_name)),
            'new_item_name' => sprintf(esc_html__('New %s name', TM_TEXTDOMAIN), strtolower($singular_name)),
            'menu_name' => esc_html__($plural_name),
        );
    }

    public static function init()
    {

    }
}
