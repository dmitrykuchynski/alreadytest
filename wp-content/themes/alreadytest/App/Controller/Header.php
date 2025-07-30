<?php

namespace App\Controller;

use App\Acf\Acf;
use App\SVG\SVG;

final class Header {

	public static function getLogo( $type = 'image', $args='full' ): string
  {
    if (!Acf::isAcfPluginActivated()) {
      return '';
    }

    $header = get_field('header', 'option');
    $logo_id = $header['header_logo'] ?? null;

    switch ($type) {
      case 'image':
        return SVG::get_image($logo_id, $args);
      case 'src':
        return wp_get_attachment_image_src($logo_id);

      default:
        throw new \Exception('Unexpected value');
    }
  }
}
