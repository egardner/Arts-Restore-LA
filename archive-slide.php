<?php
/**
 * Index
 *
 * Standard loop for the front-page
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */

get_header(); ?>

    <!-- Main Content -->
    <div class="large-12 columns" role="main">
    	<div class="main panel" id="main_content">
    		<header>
    			<h2> <?php echo get_post_type( $post ) ?>s
    			</h2>
    		</header>

		<?php if ( have_posts() ) : ?>
			<div class="small-12 columns panel grid_container">
				<ul class="small-block-grid-2 large-block-grid-4 vendorgrid">
					<?php while ( have_posts() ) : the_post(); ?>
					<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
							<?php 
							echo "<li style='background-image:url("; echo $url;	echo ");'>";
								echo "<a href='";
								echo the_permalink();
								echo "' >";
								echo "<h3 class='subheader'>";
								echo the_title();
								echo "</h3>";
								echo "</a>";

							echo "</li>";
					endwhile; ?>
				</ul>
			</div>



		<?php else : ?>
			<header>
				<h2><?php _e('No posts.', 'foundation' ); ?></h2>
			</header>
			<div class="row">
				<div class="large-12 columns index_content">
					<p class="lead"><?php _e('Sorry about this, I couldn\'t seem to find what you were looking for.', 'foundation' ); ?></p>
				</div>
			</div>
			
		<?php endif; ?>


		</div>

    </div>
</div>
    <!-- End Main Content -->
<?php get_footer(); ?>