<?php
/**
 * Hero block
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param int|string $post_id The post ID this block is saved to.
 */

use \App\Acf\Blocks\General\Hero;
use App\Helpers\Link;

$id = $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}
$className = '';
if ( ! empty( $block['className'] ) ) {
	$className .= $block['className'];
}
$fields = Hero::get_fields();
$hero_overlay_styles = empty($fields['bg-image']) ? '' : sprintf('style="%s"', $fields['bg-image']);

?>
<section id="<?php echo esc_attr( $id ); ?>" class="hero <?php echo esc_attr( $className ); ?>" <?php echo $hero_overlay_styles ?>>
    <div class="container-full 2xl:container">
        <div class="hero__wrapper">
			<?php if ( ! empty( $fields['title'] ) ): ?>
                <h1 class="hero__title title--xxl"><?php echo $fields['title']; ?></h1>
			<?php endif; ?>
			<?php if ( ! empty( $fields['description'] ) ): ?>
                <div class="hero__content text--xl"><?php echo $fields['description']; ?></div>
			<?php endif; ?>
			<?php if ( ! empty( $fields['link'] ) ): ?>
                <div class="hero__link"><?php echo Link::get_acf_link($fields['link'], 'btn btn--sm btn--primary '); ?></div>
			<?php endif; ?>
        </div>
    </div>
</section>

