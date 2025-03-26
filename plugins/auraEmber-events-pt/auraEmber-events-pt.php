<?php
/*
* Plugin Name: Aura Ember Events Post Type
*/

add_action( 'init', 'auraEmber_event_pt' );

function auraEmber_event_pt() {

   $labels = array(

      'name'                     => __( 'Events', '' ),
      'singular_name'            => __( 'Event', '' ),
      'add_new'                  => __( 'Add New', 'auraEmber' ),
      'add_new_item'             => __( 'Add New Event', 'auraEmber' ),
      'edit_item'                => __( 'Edit Event', 'auraEmber' ),
      'new_item'                 => __( 'New Event', 'auraEmber' ),
      'view_item'                => __( 'View Event', 'auraEmber' ),
      'view_items'               => __( 'View Events', 'auraEmber' ),
      'search_items'             => __( 'Search Events', 'auraEmber' ),
      'not_found'                => __( 'No Events found.', 'auraEmber' ),
      'not_found_in_trash'       => __( 'No Events found in Trash.', 'auraEmber' ),
      'parent_item_colon'        => __( 'Parent Events:', 'auraEmber' ),
      'all_items'                => __( 'All Events', 'auraEmber' ),
      'archives'                 => __( 'Event Archives', 'auraEmber' ),
      'attributes'               => __( 'Event Attributes', 'auraEmber' ),
      'insert_into_item'         => __( 'Insert into Event', 'auraEmber' ),
      'uploaded_to_this_item'    => __( 'Uploaded to this Event', 'auraEmber' ),
      'featured_image'           => __( 'Featured Image', 'auraEmber' ),
      'set_featured_image'       => __( 'Set featured image', 'auraEmber' ),
      'remove_featured_image'    => __( 'Remove featured image', 'auraEmber' ),
      'use_featured_image'       => __( 'Use as featured image', 'auraEmber' ),
      'menu_name'                => __( 'Events', 'auraEmber' ),
      'filter_items_list'        => __( 'Filter Event list', 'auraEmber' ),
      'filter_by_date'           => __( 'Filter by date', 'auraEmber' ),
      'items_list_navigation'    => __( 'Events list navigation', 'auraEmber' ),
      'items_list'               => __( 'Events list', 'auraEmber' ),
      'item_published'           => __( 'Event published.', 'auraEmber' ),
      'item_published_privately' => __( 'Event published privately.', 'auraEmber' ),
      'item_reverted_to_draft'   => __( 'Event reverted to draft.', 'auraEmber' ),
      'item_scheduled'           => __( 'Event scheduled.', 'auraEmber' ),
      'item_updated'             => __( 'Event updated.', 'auraEmber' ),
      'item_link'                => __( 'Event Link', 'auraEmber' ),
      'item_link_description'    => __( 'A link to an event.', 'auraEmber' ),

   );

   $args = array(

      'labels'                => $labels,
      'description'           => __( 'Organize and manage company events', 'auraEmber' ), 
      'public'                => true, 
      'hierarchical'          => false,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'show_in_nav_menus'     => false,
      'show_in_rest'          => true,
      'menu_icon'             => 'dashicons-calendar',
      'capability_type'       => 'post',
      'supports'              => array( 'title', 'editor', 'revisions' ),
      'has_archive'           => true,
      'rewrite'               => array( 'slug' => 'event' ),
      

   );

   register_post_type( 'auraEmber_event_pt', $args );

}
