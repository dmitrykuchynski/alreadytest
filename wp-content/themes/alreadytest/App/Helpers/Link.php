<?php

namespace App\Helpers;

class Link
{
	public static function get_acf_link(array $link, string $class = "", $icon = ""): string
	{
		if (!$link) return '';

		$attr = 'href="' . $link['url'] . '"';

		if ($link['target']) $attr .= ' target="_blank"';
		if ($class) $attr .= ' class="' . $class . '"';

		$output = '<a ' . $attr . '>';
		$output .= __($link['title'], TM_TEXTDOMAIN);
		$output .= $icon;
		$output .= '</a>';

		return $output;
	}
}
