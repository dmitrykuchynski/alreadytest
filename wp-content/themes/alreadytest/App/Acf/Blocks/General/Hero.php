<?php

namespace App\Acf\Blocks\General;

use App\Acf\Blocks\Helpers\Block;
use App\Acf\Blocks\RegisterBlock;
use App\Background\Background;
use App\Helpers\Link;

final class Hero implements \App\Acf\Blocks\Helpers\BlockItem
{

  public static function setBlockParams(): void
  {
    RegisterBlock::addBlock(new Block('hero',
        'Hero',
        'Hero block',
        'templates/gutenberg/hero.php',
        '/assets/css/hero.min.css',
        '/assets/js/hero.min.js',
        [
          'align' => false,
          'mode' => true,
          'jsx' => true,
          "anchor" => true,
        ],
        [
          'title' => "Hero block",
          'description' => ""
        ],
        get_custom_logo(),
        'custom',
      )
    );
  }

  public static function get_fields(): array
  {
    return [
      'title' => get_field('title'),
      'description' => get_field('description'),
      'link' => get_field('link'),
    ];
  }
}
