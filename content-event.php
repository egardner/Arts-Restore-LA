<?php 
/**
 * Single post page for Vendors custom post type
 * @package WordPress
 * @subpackage Arts Restore LA
 * @since Arts Restore LA 1.0
 */
?>


<article id="post-<?php the_ID(); ?>" <?php post_class('panel'); ?>>
	<header>
			<h2><?php the_title(); ?></h2>
	</header>
	<?php if ( has_post_thumbnail()) : ?>
		<?php the_post_thumbnail('fullwidth'); ?>
	<?php endif; ?>


	<div class="article_content">	
		
		<?php the_content(); ?>

		<footer>

			<p><?php wp_link_pages(); ?></p>

			<?php the_tags('<span class="radius secondary label">','</span><span class="radius secondary label">','</span>'); ?>

			<?php get_template_part('author-box'); ?>
			<?php comments_template(); ?>

		</footer>
	</div>
</article>