<?php
/**
 * Page
 *
 * Loop container for page content
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */

get_header(); ?>

    <!-- Main Content -->
    <div class="large-8 columns"id="main_content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; ?>
			
		<?php endif; ?>

    </div>
    <!-- End Main Content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>