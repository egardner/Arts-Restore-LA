<?php
/**
 * Additional theme functions beyond core Foundation package
 * @package WordPress
 * @subpackage Arts Restore LA
 * @since Arts Restore LA 1.0
 */

/* -------------------- Enqueue jquery datepicker for date entry -------------------- */

if(is_admin()) {
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
}


add_action('admin_head','add_custom_scripts');
function add_custom_scripts() {
    global $event_meta_fields, $post;
     
    $output = '<script type="text/javascript">
                jQuery(function() {';
                 
    foreach ($event_meta_fields as $field) { // loop through the fields looking for certain types
        if($field['type'] == 'date')
            $output .= 'jQuery(".datepicker").datepicker();';
    }
     
    $output .= '});
        </script>';
         
    echo $output;
}

/* -------------------- Enable multiple post featured images -------------------- */


if (class_exists('MultiPostThumbnails')) 
	{	 
		new MultiPostThumbnails(
				array(
					'label' => 'Second Image',
					'id' => 'secondary-image',
					'post_type' => 'vendor'
					) 
				);
	}

if (class_exists('MultiPostThumbnails')) 
	{	 
		new MultiPostThumbnails(
				array(
					'label' => 'Third Image',
					'id' => 'tertiary-image',
					'post_type' => 'vendor'
					) 
				);
	}


/* -------------------- Add new image size of xlarge -------------------- */


add_image_size( 'xlarge', 800, 800, true ); // 1000 pixels wide by 1000 pixels tall, hard crop mode

/* -------------------- Easily get image captions for orbit slider -------------------- */


function the_post_thumbnail_caption() {
  global $post;

  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo '<span>'.$thumbnail_image[0]->post_excerpt.'</span>';
  }
}


/* -------------------- Increase number of posts to 20 max for vendor archive page -------------------- */

add_filter('pre_get_posts', 'vendor_archive_postnumber');

function vendor_archive_postnumber($query){
    if ($query->is_post_type_archive('vendor') && !is_admin()) {
        // category named 'vendor' show 20 posts
        $query->set('posts_per_page', 20);
    }
    return $query;

}

function vendor_modify_query_order( $query ) {
    if ( $query->is_post_type_archive('vendor')) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'vendor_modify_query_order' );


/* -------------------- Code for events archive page -------------------- */
// sort posts in ascending order of date and show 20 per page

function event_modify_query_order( $query ) {
    if ( $query->is_post_type_archive('event')) {
    	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    	
    	$query->set('paged', $paged);
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'meta_key', 'event_date' );
        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'event_modify_query_order' );





/* -------------------- Custom Post Type registration for Slides -------------------- */

add_action( 'init', 'arla_create_slides' );

function arla_create_slides() {
	register_post_type( 'slide', 
		array(
			'labels' => array(
				'name' => __( 'Slides' ),
				'singular_name' => __( 'Slide' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Slide' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Slide' ),
				'new_item' => __( 'New Slide' ),
				'view' => __( 'View Slide' ),
				'view_item' => __( 'View Slide' ),
				'search_items' => __( 'Search Slides' ),
				'not_found' => __( 'No slides found' ),
				'not_found_in_trash' => __( 'No slides found in Trash' ),
				'parent' => __( 'Parent Slide' ),
				),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 6,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'rewrite' => array( 'slug' => 'slides', 'with_front' => false ),

		)
	);
}





/* -------------------- Custom Post Type registration for Events & Vendors -------------------- */

add_action( 'init', 'arla_create_event' );

function arla_create_event() {
	register_post_type( 'event', 
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Event' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Event' ),
				'new_item' => __( 'New Event' ),
				'view' => __( 'View Event' ),
				'view_item' => __( 'View Event' ),
				'search_items' => __( 'Search Events' ),
				'not_found' => __( 'No events found' ),
				'not_found_in_trash' => __( 'No events found in Trash' ),
				'parent' => __( 'Parent Event' ),
				),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 6,
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'rewrite' => array( 'slug' => 'events', 'with_front' => false ),
			'register_meta_box_cb' => 'add_event_metaboxes', // call our function to build custom metaboxes, below

		)
	);
}


add_action( 'init', 'arla_create_vendor' );

function arla_create_vendor() {
	register_post_type( 'vendor', 
		array(
			'labels' => array(
				'name' => __( 'Vendors' ),
				'singular_name' => __( 'Vendor' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Vendor' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Vendor' ),
				'new_item' => __( 'New Vendor' ),
				'view' => __( 'View Vendor' ),
				'view_item' => __( 'View Vendor' ),
				'search_items' => __( 'Search Vendors' ),
				'not_found' => __( 'No vendors found' ),
				'not_found_in_trash' => __( 'No vendors found in Trash' ),
				'parent' => __( 'Parent Vendor' ),
				),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 4,
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'rewrite' => array( 'slug' => 'vendors', 'with_front' => false ),
			'register_meta_box_cb' => 'add_vendor_metaboxes', // call our function to build custom metaboxes, below

		)
	);
}


/* -------------------- Create a set of reusable metaboxes for Vendor post types -------------------- */
// Add the Meta Box
function add_vendor_meta_boxes() {
    add_meta_box(
        'vendor_meta_box', // $id
        'Vendor Information', // $title 
        'show_vendor_meta_box', // $callback
        'vendor', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_vendor_meta_boxes');

// Field Array
$prefix = 'vendor_';
$vendor_meta_fields = array(
    array(
        'label'=> 'Street Address',
        'desc'  => '1010 Westwood Boulevard',
        'id'    => $prefix.'address_1',
        'type'  => 'text'
    ),
    array(
        'label'=> 'City, State, Zip',
        'desc'  => 'Los Angeles, CA 90024',
        'id'    => $prefix.'address_2',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Vendor Hours',
        'desc'  => '10am–6pm Daily',
        'id'    => $prefix.'hours',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Vendor Phone',
        'desc'  => '323-555-5555',
        'id'    => $prefix.'phone',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Vendor Email',
        'desc'  => 'someone@example.com',
        'id'    => $prefix.'email',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Vendor Website',
        'desc'  => 'http://www.example.com',
        'id'    => $prefix.'url',
        'type'  => 'text'
    ),

    array(
	    'label' => 'Related Event 1',
	    'desc' => 'Optional. Select a related event from the dropdown.',
	    'id'    =>  $prefix.'rel_event_1',
	    'type' => 'post_list',
	    'post_type' => array('event')
	),

    array(
	    'label' => 'Related Event 2',
	    'desc' => 'Optional. Select a related event from the dropdown.',
	    'id'    =>  $prefix.'rel_event_2',
	    'type' => 'post_list',
	    'post_type' => array('event')
	),

    array(
	    'label' => 'Related Event 3',
	    'desc' => 'Optional. Select a related event from the dropdown.',
	    'id'    =>  $prefix.'rel_event_3',
	    'type' => 'post_list',
	    'post_type' => array('event')
	),

);

/*
function remove_vendor_taxonomy_boxes() {
    remove_meta_box('categorydiv', 'vendor', 'side');
}
add_action( 'admin_menu' , 'remove_taxonomy_boxes' );
*/

// The Callback
function show_vendor_meta_box() {
global $vendor_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="vendor_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
     
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($vendor_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // case items will go here
                    // text
					case 'text':
					    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
					        <br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
					    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
					        <br /><span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
					    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
					        <label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// radio
					case 'radio':
					    foreach ( $field['options'] as $option ) {
					        echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
					                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
					    }
					break;
					// checkbox_group
					case 'checkbox_group':
					    foreach ($field['options'] as $option) {
					        echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
					                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
					    }
					    echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// tax_select
					case 'tax_select':
					    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
					            <option value="">Select One</option>'; // Select One
					    $terms = get_terms($field['id'], 'get=all');
					    $selected = wp_get_object_terms($post->ID, $field['id']);
					    foreach ($terms as $term) {
					        if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug)) 
					            echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>'; 
					        else
					            echo '<option value="'.$term->slug.'">'.$term->name.'</option>'; 
					    }
					    $taxonomy = get_taxonomy($field['id']);
					    echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Manage '.$taxonomy->label.'</a></span>';
					break;
					// select
					case 'select':
					    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
					    foreach ($field['options'] as $option) {
					        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
					    }
					    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// post_list
					case 'post_list':
					$items = get_posts( array (
					    'post_type' => $field['post_type'],
					    'posts_per_page' => -1
					));
					    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
					            <option value="">Select One</option>'; // Select One
					        foreach($items as $item) {
					            echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
					        } // end foreach
					    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// date
					case 'date':
						echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;

                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_vendor_meta($post_id) {
    global $vendor_meta_fields;
     
    // verify nonce
    if (!wp_verify_nonce($_POST['vendor_meta_box_nonce'], basename(__FILE__))) 
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
     
    // loop through fields and save the data
    foreach ($vendor_meta_fields as $field) {
    	if($field['type'] == 'tax_select') continue;
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
    // save taxonomies
	$post = get_post($post_id);
	$category = $_POST['category'];
	wp_set_object_terms( $post_id, $category, 'category' );
}
add_action('save_post', 'save_vendor_meta');



/* -------------------- Create a set of custom metaboxes for Event posts -------------------- */


function add_event_meta_boxes() {
    add_meta_box(
        'event_meta_box', // $id
        'Event Information', // $title 
        'show_event_meta_box', // $callback
        'event', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_event_meta_boxes');

// Field Array
$prefix = 'event_';
$event_meta_fields = array(
	array(
	    'label' => 'Date',
	    'desc'  => 'Event Date',
	    'id'    => $prefix.'date',
	    'type'  => 'date'
	),
    array(
        'label'=> 'Event Time',
        'desc'  => 'ex. 7:00',
        'id'    => $prefix.'time',
        'type'  => 'text'
    ),
    array(
        'label'=> 'AM/PM',
        'desc'  => 'Choose AM or PM.',
        'id'    => $prefix.'ampm',
        'type'  => 'select',
        'options' => array (
            'one' => array (
                'label' => 'AM',
                'value' => 'AM'
            ),
            'two' => array (
                'label' => 'PM',
                'value' => 'PM'
            )
        )
    ),
    array(
        'label'=> 'Event Location',
        'desc'  => 'Hammer Museum',
        'id'    => $prefix.'location_1',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Street Address',
        'desc'  => '10899 Wilshire Boulevard',
        'id'    => $prefix.'location_2',
        'type'  => 'text'
    ),
    array(
        'label'=> 'City, State, Zip',
        'desc'  => 'Los Angeles CA, 90024',
        'id'    => $prefix.'location_3',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Contact Info',
        'desc'  => 'rsvp@example.com',
        'id'    => $prefix.'contact',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Website',
        'desc'  => 'http://www.example.com',
        'id'    => $prefix.'url',
        'type'  => 'text'
    ),
    array(
	    'label' => 'Related Vendor',
	    'desc' => 'Optional. Select a related vendor from the dropdown.',
	    'id'    =>  $prefix.'rel_vendor',
	    'type' => 'post_list',
	    'post_type' => array('vendor')
	),

);

/*
function remove_event_taxonomy_boxes() {
    remove_meta_box('categorydiv', 'event', 'side');
}
add_action( 'admin_menu' , 'remove_taxonomy_boxes' );
*/

// The Callback
function show_event_meta_box() {
global $event_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="event_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
     
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($event_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {
                    // case items will go here
                    // text
					case 'text':
					    echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
					        <br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
					    echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
					        <br /><span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox
					case 'checkbox':
					    echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
					        <label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// radio
					case 'radio':
					    foreach ( $field['options'] as $option ) {
					        echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
					                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
					    }
					break;
					// checkbox_group
					case 'checkbox_group':
					    foreach ($field['options'] as $option) {
					        echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
					                <label for="'.$option['value'].'">'.$option['label'].'</label><br />';
					    }
					    echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// tax_select
					case 'tax_select':
					    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
					            <option value="">Select One</option>'; // Select One
					    $terms = get_terms($field['id'], 'get=all');
					    $selected = wp_get_object_terms($post->ID, $field['id']);
					    foreach ($terms as $term) {
					        if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug)) 
					            echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>'; 
					        else
					            echo '<option value="'.$term->slug.'">'.$term->name.'</option>'; 
					    }
					    $taxonomy = get_taxonomy($field['id']);
					    echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Manage '.$taxonomy->label.'</a></span>';
					break;
					// select
					case 'select':
					    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
					    foreach ($field['options'] as $option) {
					        echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
					    }
					    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// post_list
					case 'post_list':
					$items = get_posts( array (
					    'post_type' => $field['post_type'],
					    'posts_per_page' => -1
					));
					    echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
					            <option value="">Select One</option>'; // Select One
					        foreach($items as $item) {
					            echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
					        } // end foreach
					    echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// date
					case 'date':
						echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;

                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_event_meta($post_id) {
    global $event_meta_fields;
     
    // verify nonce
    if (!wp_verify_nonce($_POST['event_meta_box_nonce'], basename(__FILE__))) 
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
     
    // loop through fields and save the data
    foreach ($event_meta_fields as $field) {
    	if($field['type'] == 'tax_select') continue;
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
    // save taxonomies
	$post = get_post($post_id);
	$category = $_POST['category'];
	wp_set_object_terms( $post_id, $category, 'category' );
}
add_action('save_post', 'save_event_meta');
	

//



// CREATE UNIX TIME STAMP FROM DATE PICKER
function event_sort_date ( $post_id ) {
    if ( get_post_type( $post_id ) == 'event' ) {
	$event_date = get_post_meta($post_id, 'event_date', true);
	$sortable_date = date('Y-m-d', strtotime($event_date));
	update_post_meta($post_id, 'sort_date', $sortable_date);

	}
}
add_action( 'save_post', 'event_sort_date', 100, 2);



/* -------------------- Support for Upcoming vs Past events -------------------- */

function event_post_order( $query ){
    // if this is not an admin screen,
    // and is the event post type archive
    // and is the main query
    if( ! is_admin()
        && $query->is_post_type_archive( 'event' )
        && $query->is_main_query() ){

        // if this is a past events view
        // set compare to before today,
        // otherwise set to today or later
        $compare = isset( $query->query_vars['is_past'] ) ? '<' : '>=';

        // add the meta query and use the $compare var
        $today = 	date('Y-m-d', mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));  //set to yesterday for same-day event handling. For today use: date( 'Y-m-d' );
        $meta_query = array( array( 
            'key' => 'sort_date',
            'value' => $today,
            'compare' => $compare,
            'type' => 'DATE'
        ) );
        $query->set( 'meta_query', $meta_query );
    }
}
add_action( 'pre_get_posts', 'event_post_order' );


function event_archive_rewrites(){
    add_rewrite_tag( '%is_past%','([^&]+)' );
    add_rewrite_rule(
        'events/past/page/([0-9]+)/?$',
        'index.php?post_type=event&paged=$matches[1]&is_past=true',
        'top'
    );
    add_rewrite_rule(
        'events/past/?$',
        'index.php?post_type=event&is_past=true',
        'top'
    );
}
add_action( 'init', 'event_archive_rewrites' );




?>