<?php

namespace App\Cars;

class Cars {
    public function __construct()
    {
        add_action('init', [__CLASS__, 'register_cars_type']);
        add_action('init', [__CLASS__, 'register_taxonomies']);
    }

    public static function register_cars_type()
    {
        register_post_type('cars', [
            'labels' => [
                'name' => __('Cars', TM_TEXTDOMAIN),
                'singular_name' => __('Car', TM_TEXTDOMAIN),
                'add_new' => __('Add New', TM_TEXTDOMAIN),
                'add_new_item' => __('Add New Car', TM_TEXTDOMAIN),
                'edit_item' => __('Edit Car', TM_TEXTDOMAIN),
                'new_item' => __('New Car', TM_TEXTDOMAIN),
                'view_item' => __('View Car', TM_TEXTDOMAIN),
                'search_items' => __('Search Cars', TM_TEXTDOMAIN),
                'not_found' => __('No cars found', TM_TEXTDOMAIN),
                'not_found_in_trash' => __('No cars found in trash', TM_TEXTDOMAIN),
                'menu_name' => __('Cars', TM_TEXTDOMAIN),
            ],
            'public' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => ['slug' => 'cars'],
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => null,
            'show_in_rest' => true,
            'supports' => ['title', 'thumbnail', 'excerpt'],
            'menu_icon' => 'dashicons-car',
        ]);
    }

    public static function register_taxonomies()
    {
        $taxonomies = [
            'car_brand' => __('Brand', TM_TEXTDOMAIN),
            'car_type' => __('Type', TM_TEXTDOMAIN),
            'car_color' => __('Color', TM_TEXTDOMAIN),
            'car_year' => __('Year', TM_TEXTDOMAIN),
        ];

        foreach ($taxonomies as $slug => $name) {
            register_taxonomy($slug, 'cars', [
                'labels' => [
                    'name' => $name,
                    'singular_name' => $name,
                    'search_items' => __('Search', TM_TEXTDOMAIN) . ' ' . $name,
                    'all_items' => __('All', TM_TEXTDOMAIN) . ' ' . $name,
                    'edit_item' => __('Edit', TM_TEXTDOMAIN) . ' ' . $name,
                    'update_item' => __('Update', TM_TEXTDOMAIN) . ' ' . $name,
                    'add_new_item' => __('Add New', TM_TEXTDOMAIN) . ' ' . $name,
                    'new_item_name' => __('New', TM_TEXTDOMAIN) . ' ' . $name,
                    'menu_name' => $name,
                ],
                'public' => true,
                'hierarchical' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_rest' => true,
                'rewrite' => ['slug' => $slug],
            ]);
        }
    }
}
