<?php
/**
 * Sidebar
 *
 * Content for our sidebar, provides prompt for logged in users to create widgets
 *
 * @package WordPress
 * @subpackage Foundation, for WordPress
 * @since Foundation, for WordPress 4.0
 */
?>

<!-- Sidebar -->
<aside class="large-4 columns sidebar">
	<div class="panel">
		<h3>Links</h3>
			<dl><a href="http://www.hammer.ucla.edu" target="_blank">Hammer Museum</a></dl>
			<dl><a href="https://twitter.com/hammer_museum" target="_blank">Arts Restore LA Twitter Feed</a></dl>
	</div>
	<div class="panel">
		<h3>Upcoming Events</h3>
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


</aside>
<!-- End Sidebar -->