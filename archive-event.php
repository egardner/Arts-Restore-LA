<?php
/**
 * Archive-Event.php
 *
 * Archive page for Event custom post type
 *
 * @package WordPress
 * @subpackage Arts Restore LA
 * @since Arts Restore LA 1.0
 */

get_header(); ?>

    <!-- Main Content -->
    <div class="large-12 columns" role="main">
    	<div class="main panel" id="main_content">
    		<header>
    			<h2> <?php 
    				if ( isset( $wp_query -> query_vars['is_past'] ) ) {
	    				echo "Past Events";
    				} else {
	    				echo "Upcoming Events";
    				}	    			
    			?></h2>
    		</header>
    		<div class="index_content" id="event_toggle">
    			<div class="row">
    				<div class="small-12 columns">
    				<?php 
 	    					$url = get_bloginfo('url');
	    					if ( isset( $wp_query -> query_vars['is_past'] ) ) 
	    						{	
	    						echo '<a href="';
	    						echo sprintf("%s/events/", $url);
	    						echo'">';
	    						echo"<h4>View Upcoming Events</h4></a>"; 
	    						}
		    				else 
		    					{
	    						echo '<a href="';
	    						echo sprintf("%s/events/past/", $url);
	    						echo'">';
	    						echo"<h4>View Past Events</h4></a>"; 
		    					}	
			    	?>	    			
	    			</div>
    			</div>
    		</div>

		<?php if ( have_posts() ) : ?>
				<?php while (have_posts() ) : the_post(); ?>
					<div class="index_content">
						<div class="row event_listing">
							<div class="large-2 small-12 columns">
								<h5 class="subheader event_date">
									<?php
										$date = get_post_meta($post->ID, 'event_date', true);
										$time = get_post_meta($post->ID, 'event_time', true);
										$ampm = get_post_meta($post->ID, 'event_ampm', true); 
										echo "<span class='hide-for-small'>";
										echo date("D M j", strtotime($date));
										echo "<br />";
										echo $time;
										echo " ";
										echo $ampm;
										echo "</span>";
										echo "<span class='show-for-small'>";
										echo date("D M j", strtotime($date));
										echo " | ";
										echo $time;
										echo " ";
										echo $ampm;
										echo "</span>";
									?>
								</h5>
							</div>
							<div class="large-6 small-12 columns">
								<h5 class="event_title"><a href="<?php esc_attr(the_permalink())?>"><?php the_title() ?></a></h5>
								<dl class="arla_excerpt"><?php $excerpt = get_the_excerpt();	echo($excerpt); ?></dl>
							</div>
							<div class="large-4 small-12 columns">
								<?php
									$location1 = get_post_meta($post->ID, 'event_location_1', true);
									$location2 = get_post_meta($post->ID, 'event_location_2', true);
									echo "<p class='event_location'>";
									echo $location1;
									echo "<br />";
									echo $location2;
									echo "</p>";
								?>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
				<!-- end of the loop -->
				<?php wp_reset_postdata(); ?>

		<?php else:  ?>
		<h6 class="subheader"><?php _e( 'No upcoming events.' ); ?></h6>
		<?php endif; ?>
		<!-- pagination -->
		<div class="index_content" id="pagination">
			<div class="row">
				<div class="nav-next columns small-6"><?php previous_posts_link( 'Previous Page' ); ?></div>
				<div class="nav-previous columns small-6"><?php next_posts_link( 'Next Page' ); ?></div>
			</div>
		</div>
		<!-- end pagination -->


		</div>

    </div>
    <!-- End Main Content -->

<?php get_footer(); ?>