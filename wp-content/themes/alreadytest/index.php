<?php
/**
 * Base page template
 *
 * @package WordPress
 * @since 1.0.0
 *
 * @link    https://developer.wordpress.org/themes/template-files-section/page-template-files/
 */

get_header();
?>
<main id="main" class="site-main" role="main">
	<?php the_content(); ?>
</main>
<?php get_footer(); ?>
