<?php 

/* -------------------- Original orbit slider code from front-page php -------------------- */
// saving this in case new version breaks

/*
<!-- BEGIN ARLA SLIDER -->
<ul data-orbit="" data-options="bullets:false;" id="arla_slider">
	<li><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/1_ARLA_denim.jpg" title="" alt="" />
		<div class="orbit-caption">
			<div class="row">
				<div class="large-12 columns">
					<p class="arla_callout">Sixteen Vendors.<br />Three Weeks.<br />One Vision.</p>
				</div>
			</div>
		</div>
	</li>
	<li><img src="img/1_ARLA_denim.jpg" />
		<div class="orbit-caption">...</div>
	</li>
		<li><img src="img/1_ARLA_denim.jpg" />
			<div class="orbit-caption">...</div>
		</li>
</ul>

*/



/* -------------------- Add Events feed to home page -------------------- */
// alternate solution to custom query on front-page.php

add_filter( 'pre_get_posts', 'my_get_posts' );

function my_get_posts( $query ) {

if ( ( is_home() && $query->is_main_query() ) || is_feed() )
    $query->set( 'post_type', array( 'event' ) );

  return $query;
}



/* -------------------- Create a set of reusable metaboxes for custom post types -------------------- */
// Add the Meta Box
function add_custom_meta_box() {
    add_meta_box(
        'custom_meta_box', // $id
        'Custom Meta Box', // $title 
        'show_custom_meta_box', // $callback
        'post', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_custom_meta_box');

// Field Array
$prefix = 'custom_';
$custom_meta_fields = array(
    array(
        'label'=> 'Text Input',
        'desc'  => 'A description for the field.',
        'id'    => $prefix.'text',
        'type'  => 'text'
    ),
    array(
        'label'=> 'Textarea',
        'desc'  => 'A description for the field.',
        'id'    => $prefix.'textarea',
        'type'  => 'textarea'
    ),
    array(
        'label'=> 'Checkbox Input',
        'desc'  => 'A description for the field.',
        'id'    => $prefix.'checkbox',
        'type'  => 'checkbox'
    ),
    array(
    	'label' => 'Radio Group',
    	'desc'  => 'A description for the field.',
    	'id'    => $prefix.'radio',
    	'type'  => 'radio',
    	'options' => array (
	        'one' => array (
	            'label' => 'Option One',
	            'value' => 'one'
	        ),
	        'two' => array (
	            'label' => 'Option Two',
	            'value' => 'two'
	        ),
	        'three' => array (
	            'label' => 'Option Three',
	            'value' => 'three'
	        )
    	)
	),
	array(
	    'label' => 'Checkbox Group',
	    'desc'  => 'A description for the field.',
	    'id'    => $prefix.'checkbox_group',
	    'type'  => 'checkbox_group',
	    'options' => array (
	        'one' => array (
	            'label' => 'Option One',
	            'value' => 'one'
	        ),
	        'two' => array (
	            'label' => 'Option Two',
	            'value' => 'two'
	        ),
	        'three' => array (
	            'label' => 'Option Three',
	            'value' => 'three'
	        )
	    )
	),
	array(
	    'label' => 'Category',
	    'id'    => 'category',
	    'type'  => 'tax_select'
	),


    array(
        'label'=> 'Select Box',
        'desc'  => 'A description for the field.',
        'id'    => $prefix.'select',
        'type'  => 'select',
        'options' => array (
            'one' => array (
                'label' => 'Option One',
                'value' => 'one'
            ),
            'two' => array (
                'label' => 'Option Two',
                'value' => 'two'
            ),
            'three' => array (
                'label' => 'Option Three',
                'value' => 'three'
            )
        )
    ),

    array(
	    'label' => 'Post List',
	    'desc' => 'A description for the field.',
	    'id'    =>  $prefix.'post_id',
	    'type' => 'post_list',
	    'post_type' => array('post','page')
	),

	array(
	    'label' => 'Date',
	    'desc'  => 'A description for the field.',
	    'id'    => $prefix.'date',
	    'type'  => 'date'
	)


);

function remove_taxonomy_boxes() {
    remove_meta_box('categorydiv', 'post', 'side');
}
add_action( 'admin_menu' , 'remove_taxonomy_boxes' );

// The Callback
function show_custom_meta_box() {
global $custom_meta_fields, $post;
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
     
    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($custom_meta_fields as $field) {
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
function save_custom_meta($post_id) {
    global $custom_meta_fields;
     
    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
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
    foreach ($custom_meta_fields as $field) {
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
add_action('save_post', 'save_custom_meta');

?>