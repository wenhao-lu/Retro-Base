<?php

// add custom section to the CMS menu

function custom_post_types(){
    // Handheld Post Type
    register_post_type('handheld', array(
        'rewrite' => array('slug' => 'handhelds'),
        'show_in_rest' => true,
        // reqiure permissions
        'map_meta_cap' => true,
        'capability_type' => 'post',
        'supports' => array('title','editor','custom-fields'),
        'has_archive' => true,
        'public' => true,
        'show_ui' => true,
        'publicly_queryable' => true,
        'labels' => array(
            'name' => 'Handhelds',
            'add_new_item' => 'Add New Handheld',
            'edit_item' => 'Edit Handheld',
            'all_items' => 'All Handhelds',
            'singular_name' => 'Handheld'
        ),
        'menu_icon' => 'dashicons-games'
    ));


// Note Post Type
register_post_type('note', array(
    //'rewrite' => array('slug' => 'notes'),
    'show_in_rest' => true,
    // reqiure permissions
    'map_meta_cap' => true,
    // add roles of 'note' section to Members plugin
    'capability_type' => 'note',
    'supports' => array('title','editor'),
    //'has_archive' => true,
    'public' => false,
    'show_ui' => true,
    'labels' => array(
        'name' => 'Notes',
        'add_new_item' => 'Add New Note',
        'edit_item' => 'Edit Note',
        'all_items' => 'All Notes',
        'singular_name' => 'Note'
    ),
    'menu_icon' => 'dashicons-welcome-write-blog'
));




    }


    add_action('init', 'custom_post_types');

?>