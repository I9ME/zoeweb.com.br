<?php
/**
 * The main template file
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Skeleton
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<?php if ( is_home() || is_front_page() ) : ?>
		<h2>HOME</h2>
	<?php else : ?>
	<h2>INTERNAS</h2>
	<?php endif; ?>

		<main id="main" class="site-main" role="main">
		
		<h2>Conteúdo Principal</h2>	

		</main><!-- #main -->

</div><!-- .wrap -->

<?php get_footer();
