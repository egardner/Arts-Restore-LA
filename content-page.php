<?php
/**
 * Content Page
 *
 * Loop content in page template (page.php)
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */
?>

<article id="page-<?php the_ID(); ?>" <?php post_class('panel'); ?>>
	
	<header>
		<h2><?php the_title(); ?></h2>
	</header>

	<?php if ( has_post_thumbnail()) : ?>
		<?php the_post_thumbnail('fullwidth'); ?>
	<?php endif; ?>


	<div class="article_content">	
		
		<?php the_content(); ?>
	</div>
</article>