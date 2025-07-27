<?php
/**
 * Abstract helper class to register Post Types
 */

namespace App\Helpers;

abstract class RegisterPostType implements Init
{
    /**
     * @var string
     *
     * Set post type params
     */
    protected $post_type = null;
    protected $post_type_slug = null;
    protected $post_type_plural_name = null;
    protected $post_type_singular_name = null;

    /**
     * Register post type method
     *
     * @param array $args
     *
     * @link https://developer.wordpress.org/reference/functions/register_post_type/
     */
    protected function register($args)
    {

        if (empty($this->post_type) || empty($this->post_type_slug) || empty($this->post_type_singular_name) || empty($this->post_type_plural_name))
            return;

        $labels = LabelGenerator::generate('post', $this->post_type_singular_name, $this->post_type_plural_name);

        $args['labels'] = $labels;

        if (empty($args['rewrite'])) {
            $args['rewrite'] = array('slug' => strtolower($this->post_type_slug));
        }
        return register_post_type($this->post_type, $args);
    }

    /**
     * @param $columns
     * @return mixed
     *
     * Choose the columns you want in
     * the admin table for this post
     */
    protected function set_columns($columns)
    {
        // Set/unset post type table columns here

        return $columns;
    }

    /**
     * @param $column
     * @param $post_id
     *
     * Edit the contents of each column in
     * the admin table for this post
     */
    protected function edit_columns($column, $post_id)
    {
        // Post type table column content code here
    }

    public static function init()
    {

    }
}
