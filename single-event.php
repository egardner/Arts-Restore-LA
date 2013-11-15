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
		<!-- <?php $sort_date = get_post_meta($post->ID, 'sort_date', true); echo $sort_date; ?> -->

    </div>
    <!-- End Main Content -->
    <!-- Event-specific Sidebar -->
    <div class="large-4 columns" role="aside" id="event_sidebar">
    	<div class="panel">
    		<h3>Event Info</h3>
	    	<?php 	
	    	// Event Location. If we have one, print the dl element
	    	if (get_post_meta($post->ID, 'event_location_1', true)) {
	    		$address1 = get_post_meta($post->ID, 'event_location_1', true);
	    		$address2 = get_post_meta($post->ID, 'event_location_2', true);
	    		$address3 = get_post_meta($post->ID, 'event_location_3', true);
	    		echo "<dl class='event_data' id='event_location'>";
	    			echo $address1;
	    			echo "<br />";
	    			echo $address2;
	    			echo "<br />";
	    			echo $address3;
	    		echo "</dl>";
	    	}
		    // Event Date. If we have one, print the dl element
	    	if (get_post_meta($post->ID, 'event_date', true)) {
	    		$date = get_post_meta($post->ID, 'event_date', true);
 			    $time = get_post_meta($post->ID, 'event_time', true);
	    		$ampm = get_post_meta($post->ID, 'event_ampm', true);
	    		echo "<dl class='event_data' id='event_date'>";
	    			echo '<i class="foundicon-calendar"></i>   ';
	    			echo date("M j, Y", strtotime($date));
	    			echo " | ";
	    			echo $time;
	    			echo " ";
	    			echo $ampm;

	    		echo "</dl>";
	    	}   
	 	    // Event contact info. If we have them print dl and icon
	 	    if (get_post_meta($post->ID, 'event_contact', true)) {
	    		$contact = get_post_meta($post->ID, 'event_contact', true);
	    		echo "<dl class='event_data' id='event_contact'>";
			    	echo '<i class="foundicon-mail"></i>   ';

	    			echo $contact;
	    		echo "</dl>";
	    	}
	    	// Event URL
	    	if (get_post_meta($post->ID, 'event_url', true)) {
	    		$event_url = get_post_meta($post->ID, 'event_url', true);
	    		echo "<dl class='event_data' id='event_url'>";
	    			echo '<i class="foundicon-globe"></i>   ';
	    			echo '<a href="';
	    			esc_attr_e($event_url);
	    			echo '" >';
	    			echo "Event Website";
	    			echo '</a>';
	    		echo "</dl>";
	    	}
	    	?>
		</div>
		<?php 
			// related event #1 plus opening of related events div
			if (get_post_meta($post->ID, 'event_rel_vendor', true)) {
				echo '<div class="panel"><h3>Related Vendor</h3>';
				$related_vendor = get_post_meta($post->ID, 'event_rel_vendor', true);
				$related_post_title = get_post_field ('post_title', $related_vendor);
				$permalink = get_permalink ($related_vendor);
				echo "<dl class='event_data related_vendor'>";
				echo "<a href='";
				esc_attr_e($permalink);
				echo "'>";
				echo($related_post_title);
				echo "</a>";
				echo "</dl>";
				echo '</div>';
			} 


		?>


    </div>

<?php get_footer(); ?>