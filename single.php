<?php
/**
 * Single
 *
 * Loop container for single post content
 * This template has been customized to support custom post types in the loop
 * in order to add new templates, create files named content-$posttype.php
 *
 * @package WordPress
 * @subpackage Arts Restore LA
 * @since Arts Restore LA 1.0
 */

get_header(); ?>

    <!-- Main Content -->
    <div class="large-8 columns" role="main" id="main_content">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_type() ); ?>
			<?php endwhile; ?>
			
		<?php endif; ?>

    </div>
    <!-- End Main Content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>