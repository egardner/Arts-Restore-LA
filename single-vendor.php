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
    <!-- Vendor-specific Sidebar -->
    <div class="large-4 columns" role="aside" id="vendor_sidebar">
    	<div class="panel">
    		<h3>Vendor Info</h3>
	    	<?php 	
	    	// Vendor Address. If we have one, print the dl element
	    	if (get_post_meta($post->ID, 'vendor_address_1', true)) {
	    		$address1 = get_post_meta($post->ID, 'vendor_address_1', true);
	    		$address2 = get_post_meta($post->ID, 'vendor_address_2', true);
	    		echo "<dl class='vendor_data' id='vendor_address'>";
	    			echo $address1;
	    			echo "<br />";
	    			echo $address2;
	    		echo "</dl>";
	    	}
	 	    // Vendor Hours. If we have them print dl and icon
	 	    if (get_post_meta($post->ID, 'vendor_hours', true)) {
	    		$hours = get_post_meta($post->ID, 'vendor_hours', true);
	    		echo "<dl class='vendor_data' id='vendor_hours'>";
			    	echo '<i class="fi-clock"></i>   ';

	    			echo $hours;
	    		echo "</dl>";
	    	}
	    	// Vendor Phone. If a value exists, print dl and icon
	    	if (get_post_meta($post->ID, 'vendor_phone', true)) {
	    		$phone = get_post_meta($post->ID, 'vendor_phone', true);
	    		echo "<dl class='vendor_data' id='vendor_phone'>";
	    			echo '<i class="fi-telephone"></i>   ';
	    			echo $phone;
	    		echo "</dl>";
	    	}
	    	// Vendor Email. Check and print if email value exists
	    	if (get_post_meta($post->ID, 'vendor_email', true)) {
	    		$email = get_post_meta($post->ID, 'vendor_email', true);
	    		echo "<dl class='vendor_data' id='vendor_email'>";
	    			echo '<i class="fi-mail"></i>   ';
	    			echo $email;
	    		echo "</dl>";
	    	}
	    	// Vendor URL
	    	if (get_post_meta($post->ID, 'vendor_url', true)) {
	    		$vendor_url = get_post_meta($post->ID, 'vendor_url', true);
	    		echo "<dl class='vendor_data' id='vendor_url'>";
	    			echo '<i class="fi-web"></i>   ';
	    			echo '<a href="';
	    			esc_attr_e($vendor_url);
	    			echo '" target="_blank" >';
	    			echo "Vendor Website";
	    			echo '</a>';
	    		echo "</dl>";
	    	}
	    	?>
		</div>
		<?php 
			// related event #1 plus opening of related events div
			if (get_post_meta($post->ID, 'vendor_rel_event_1', true)) {
				echo '<div class="panel"><h3>Related Events</h3>';
				$event_ID = get_post_meta($post->ID, 'vendor_rel_event_1', true);
				$related_post_title = get_post_field ('post_title', $event_ID);
				$permalink = get_permalink ($event_ID);
				echo "<dl class='vendor_data vendor_event'>";
				echo "<a href='";
				esc_attr_e($permalink);
				echo "'>";
				echo($related_post_title);
				echo "</a>";
				echo "</dl>";
			}
			// related event #2
			if (get_post_meta($post->ID, 'vendor_rel_event_2', true)) {
				$event_ID = get_post_meta($post->ID, 'vendor_rel_event_2', true);
				$related_post_title = get_post_field ('post_title', $event_ID);
				$permalink = get_permalink ($event_ID);
				echo "<dl class='vendor_data vendor_event'>";
				echo "<a href='";
				esc_attr_e($permalink);
				echo "'>";
				echo($related_post_title);
				echo "</a>";
				echo "</dl>";
			}
			// related event #3
			if (get_post_meta($post->ID, 'vendor_rel_event_3', true)) {
				$event_ID = get_post_meta($post->ID, 'vendor_rel_event_3', true);
				$related_post_title = get_post_field ('post_title', $event_ID);
				$permalink = get_permalink ($event_ID);
				echo "<dl class='vendor_data vendor_event'>";
				echo "<a href='";
				esc_attr_e($permalink);
				echo "'>";
				echo($related_post_title);
				echo "</a>";
				echo "</dl>";


			// close div if we opened one
				echo '</div>';
			} 


		?>


    </div>
</div>

<?php get_footer(); ?>