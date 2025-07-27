<?php

namespace App\Base;

final class Deregister
{

  public function __construct()
  {
    add_action('wp_enqueue_scripts', [self::class, 'deregisterStyles'], 99);
    add_action('wp_enqueue_scripts', [self::class, 'deregisterScripts'], 99);
    add_action('wp_enqueue_scripts', [self::class, 'deregisterJquery'], 99);
    self::disableEmoji();
  }

  public static function deregisterStyles()
  {
    if (is_admin()) {
      return;
    }

    wp_dequeue_style('global-styles');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('dashicons');
    wp_dequeue_style('wp-block-library');
  }

  public static function deregisterScripts()
  {
    if (is_admin()) {
      return;
    }

    wp_dequeue_script('wp-emoji');

  }

  public static function deregisterJquery()
  {
    if (is_admin()) {
      return;
    }
    wp_deregister_script('jquery');
    wp_register_script('jquery', '', [], false, true);

    add_filter('wp_default_scripts', function ($scripts) {
      if (empty($scripts->registered['jquery']) || is_admin()) {
        return;
      }
      $deps = &$scripts->registered['jquery']->deps;
      $deps = array_diff($deps, ['jquery-migrate']);
    });
  }

  public static function disableEmoji()
  {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
  }
}
