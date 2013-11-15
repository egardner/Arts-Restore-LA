<?php
/**
 * Static Front Page
 *
 * Standard loop for the front-page
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */

get_header(); ?>
</div>
<!-- BEGIN ARLA SLIDER -->
<ul data-orbit="" data-options="bullets:false;" id="arla_home_orbit">
	<?php $args = array(	'post_type'	=> 'slide',
				'post_status'	=> 'publish',
				'order'		=> 'ASC',
				'orderby'	=> 'date', ); ?>
	<?php $my_query = new WP_Query($args); ?>
	<?php while ($my_query->have_posts()) : $my_query->the_post(); ?>

		<li><?php the_post_thumbnail(); ?>
			<div class="orbit-caption">
						<?php the_content(); ?>
			</div>
		</li>
	<?php endwhile ?>
</ul>

<div class="row" id="arla_columns">
	<div class="large-4 columns">
		<div class="arla_home_columns panel"><h3>The Project</h3>
			<p>Arts ReSTORE LA: Westwood is a month-long initiative that aims to <nobr>re-energize</nobr> Westwood Village with the creative force of local Angeleno artisans and craftspeople.</p>
			<h6>Hours: Thursday-Saturday 11AM-8PM | Sundays 11AM-5PM</h6>
		</div>
	</div>
	<div class="large-4 columns">
		<div class="arla_home_columns panel"><h3>Locations</h3>
			<a href="<?php bloginfo('url'); ?>/map">
				<div id="map-canvas"></div>
			</a>
		</div>
	</div>
	<div class="large-4 columns">
		<div class="arla_home_columns panel"><h3>Upcoming Events</h3>
		<!-- Output list of events  -->
		<ul id="arla_eventlist">
		<?php 
		$today = date('Y-m-d', mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));
		$args = array(
	    			'post_type'		=> 'event',
				'post_status'		=> 'publish',
				'order'			=> 'ASC',
				'orderby'			=> 'meta_value',
				'posts_per_page'	=> 4,
				'meta_key' 		=> 'sort_date',
				'meta_query'		=> array(
					array(
						'key'	=> 'sort_date',
						'value'	=> $today,
						'compare'	=> '>=',
						'type'	=> 'DATE'
						)
					)
				); 	

		$the_query = new WP_Query( $args ); ?>

		<?php if ( $the_query->have_posts() ) : ?>

		<!-- pagination here -->

		<!-- the loop -->
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<li><?php
				echo "<li>";
				echo "<a href='"; the_permalink(); 
				echo "'>";
				the_title(); 
				echo"</a>";
				echo"<h6 class='subheader'>";
				$eventdate = get_post_meta($post->ID, 'event_date', true);	
				$nicedate = date('D M j', strtotime($eventdate));	
				echo $nicedate;
				echo " | "; 
				$eventtime = get_post_meta($post->ID, 'event_time', true); 
				echo $eventtime;
				$eventampm = get_post_meta($post->ID, 'event_ampm', true); 
				echo $eventampm;
				echo"</h6>"; ?>
			</li>
		<?php endwhile; ?>
		<!-- end of the loop -->

		<!-- pagination here -->

		<?php wp_reset_postdata(); ?>

		<?php else:  ?>
			<li><h6 class="subheader"><?php _e( 'No upcoming events.' ); ?></h6></li>
		<?php endif; ?>
				
			</ul>

		</div>

	</div>
</div>



<!-- End Main Content -->

<?php get_footer(); ?>