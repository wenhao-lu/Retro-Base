<?php 
/*
Plugin Name: Handheld Data Management
Description: Plugin for managing custom Handheld data   
Version: 1.0
Author: Kevin - Wenhao Lu
Author URI: portfolio.wlkevin.com
*/


// Register a custom menu page

function handheld_data_management_menu() {
  add_menu_page(
    'Handheld Data Management',
    'Handheld Data',
    'manage_options',
    'handheld-data-management',
    'handheld_data_management_page'
  );
}
add_action('admin_menu', 'handheld_data_management_menu');


// Callback function for the menu page
function handheld_data_management_page() {
    // Check if a submenu page is requested
    if (isset($_GET['subpage'])) {
        $subpage = $_GET['subpage'];
        
        // Display the appropriate submenu content based on the requested subpage
        if ($subpage === 'add_new') {
            // Display the input table for creating new data
            include 'add-new-handheld.php';
        }
    } else {
        // Display the "All Handhelds" page with the list of data from the database
        include 'all-handhelds.php';
    }

}

//Register a custom menu page
function register_handheld_data_menu_page() {
    
    // Add the "Add New" submenu
    add_submenu_page(
        'handheld-data-management',
        'Add New',
        'Add New',
        'manage_options',
        'handheld-data-management&subpage=add_new',
        'handheld_data_management_page'
    );
}
add_action('admin_menu', 'register_handheld_data_menu_page');

// add a submenu page 'Handheld Details' for CRUD operations
add_action('admin_menu', 'register_handheld_details_submenu');
function register_handheld_details_submenu() {
  add_submenu_page(
    'handheld-data-management', // Parent menu slug
    'Handheld Details', // Page title
    'Handheld Details', // Menu title
    'manage_options', // Capability required
    'handheld-details', // Menu slug
    'render_handheld_details_page' // Callback function
  );
}

function render_handheld_details_page() {
    require_once 'handheld-details.php';
}


// the CREATE function
// Callback function to handle the add_handheld action
function add_handheld_callback() {
    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize the input fields
        $handheld_id = absint($_POST['handheld-id']);
        $handheld_name = sanitize_text_field($_POST['handheld-name']);
        $handheld_brand = sanitize_text_field($_POST['handheld-brand']);
        $handheld_released = sanitize_text_field($_POST['handheld-released']);
        $handheld_price = sanitize_text_field($_POST['handheld-price']);
        $handheld_os = sanitize_text_field($_POST['handheld-os']);
        $handheld_soc = sanitize_text_field($_POST['handheld-soc']);
        $handheld_ram = sanitize_text_field($_POST['handheld-ram']);
        $handheld_screen_size = sanitize_text_field($_POST['handheld-screen_size']);
        $handheld_screen_type = sanitize_text_field($_POST['handheld-screen_type']);
        $handheld_resolution = sanitize_text_field($_POST['handheld-resolution']);
        $handheld_ppi = sanitize_text_field($_POST['handheld-ppi']);
        $handheld_aspect_ratio = sanitize_text_field($_POST['handheld-aspect_ratio']);
        $handheld_battery = sanitize_text_field($_POST['handheld-battery']);
        $handheld_storage = sanitize_text_field($_POST['handheld-storage']);
        $handheld_dimensions = sanitize_text_field($_POST['handheld-dimensions']);
        $handheld_weight = sanitize_text_field($_POST['handheld-weight']);
        $handheld_material = sanitize_text_field($_POST['handheld-material']);
        $handheld_review = sanitize_text_field($_POST['handheld-review']);
        $handheld_vendor = sanitize_text_field($_POST['handheld-vendor']);
        $handheld_performance = sanitize_text_field($_POST['handheld-performance']);
        $handheld_image = sanitize_text_field($_POST['handheld-image']);


// Upload and save the image
$image_url = '';
if ($_FILES['handheld-image']['size'] > 0) {
    $uploaded_image = $_FILES['handheld-image'];
    $upload_overrides = array('test_form' => false);
    $uploaded_file = wp_handle_upload($uploaded_image, $upload_overrides);

    if ($uploaded_file && !isset($uploaded_file['error'])) {
        $image_data = file_get_contents($uploaded_file['file']);
    } else {
        // Display error message
        echo 'Failed to upload the image.';
        return;
    }
}

        // Insert the handheld data into the custom database table
        global $wpdb;
        $table_name = $wpdb->prefix . 'handhelds';
        $inserted = $wpdb->insert(
            $table_name,
            array(
                'id' => $handheld_id,
                'name' => $handheld_name,
                'brand' => $handheld_brand,
                'released' => $handheld_released,
                'price' => $handheld_price,
                'os' => $handheld_os,
                'soc' => $handheld_soc,
                'ram' => $handheld_ram,
                'screen_size' => $handheld_screen_size,
                'screen_type' => $handheld_screen_type,
                'resolution' => $handheld_resolution,
                'ppi' => $handheld_ppi,
                'aspect_ratio' => $handheld_aspect_ratio,
                'battery' => $handheld_battery,
                'storage' => $handheld_storage,
                'dimensions' => $handheld_dimensions,
                'weight' => $handheld_weight,
                'material' => $handheld_material,
                'review' => $handheld_review,
                'vendor' => $handheld_vendor,
                'performance' => $handheld_performance,
                'image' => $image_data,
            )
        );

        if ($inserted) {
            // Display success message and redirect back to the handheld-data-management page
            $redirect_url = admin_url('admin.php?page=handheld-data-management');
            wp_redirect(add_query_arg(array('success' => 'true'), $redirect_url));
            exit;
        } else {
            // Display error message
            echo 'Failed to add handheld.';
        }
    }
}
add_action('admin_post_add_handheld', 'add_handheld_callback');
add_action('admin_post_nopriv_add_handheld', 'add_handheld_callback');


// the UPDATE function
// Callback function to handle the edit_handheld action
function edit_handheld_callback() {
    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate and sanitize the input fields
        $handheld_id = absint($_POST['handheld_id']);
        $handheld_name = sanitize_text_field($_POST['handheld_name']);
        $handheld_brand = sanitize_text_field($_POST['handheld_brand']);
        $handheld_released = sanitize_text_field($_POST['handheld_released']);
        $handheld_price = sanitize_text_field($_POST['handheld_price']);
        $handheld_os = sanitize_text_field($_POST['handheld_os']);
        $handheld_soc = sanitize_text_field($_POST['handheld_soc']);
        $handheld_ram = sanitize_text_field($_POST['handheld_ram']);
        $handheld_screen_size = sanitize_text_field($_POST['handheld_screen_size']);
        $handheld_screen_type = sanitize_text_field($_POST['handheld_screen_type']);
        $handheld_resolution = sanitize_text_field($_POST['handheld_resolution']);
        $handheld_ppi = sanitize_text_field($_POST['handheld_ppi']);
        $handheld_aspect_ratio = sanitize_text_field($_POST['handheld_aspect_ratio']);
        $handheld_battery = sanitize_text_field($_POST['handheld_battery']);
        $handheld_storage = sanitize_text_field($_POST['handheld_storage']);
        $handheld_dimensions = sanitize_text_field($_POST['handheld_dimensions']);
        $handheld_weight = sanitize_text_field($_POST['handheld_weight']);
        $handheld_material = sanitize_text_field($_POST['handheld_material']);
        $handheld_review = sanitize_text_field($_POST['handheld_review']);
        $handheld_vendor = sanitize_text_field($_POST['handheld_vendor']);
        $handheld_performance = sanitize_text_field($_POST['handheld_performance']);
        $handheld_image = $_FILES['handheld_image'];

        // Upload and save the image
        $image_data = '';
        if ($handheld_image['size'] > 0) {
            $upload_overrides = array('test_form' => false);
            $uploaded_file = wp_handle_upload($handheld_image, $upload_overrides);

            if ($uploaded_file && !isset($uploaded_file['error'])) {
                $image_data = file_get_contents($uploaded_file['file']);
            } else {
                // Display error message
                echo 'Failed to upload the image.';
                return;
            }
        }

 // Update the handheld data in the custom database table
 global $wpdb;
 $table_name = $wpdb->prefix . 'handhelds';
 $updated = $wpdb->update(
     $table_name,
     array(
        'name' => $handheld_name,
        'brand' => $handheld_brand,
        'released' => $handheld_released,
        'price' => $handheld_price,
        'os' => $handheld_os,
        'soc' => $handheld_soc,
        'ram' => $handheld_ram,
        'screen_size' => $handheld_screen_size,
        'screen_type' => $handheld_screen_type,
        'resolution' => $handheld_resolution,
        'ppi' => $handheld_ppi,
        'aspect_ratio' => $handheld_aspect_ratio,
        'battery' => $handheld_battery,
        'storage' => $handheld_storage,
        'dimensions' => $handheld_dimensions,
        'weight' => $handheld_weight,
        'material' => $handheld_material,
        'review' => $handheld_review,
        'vendor' => $handheld_vendor,
        'performance' => $handheld_performance,
         'image' => $image_data,
     ),
     array('id' => $handheld_id)
 );

 if ($updated) {
    // Display success message and redirect back to the handheld-details page
    $redirect_url = admin_url('admin.php?page=handheld-details&handheld_id=' . $handheld_id);
    wp_redirect(add_query_arg(array('success' => 'true'), $redirect_url));
    exit;
} else {
    // Display error message
    echo 'Failed to update handheld.';
}
}
}
add_action('admin_post_edit_handheld', 'edit_handheld_callback');
add_action('admin_post_nopriv_edit_handheld', 'edit_handheld_callback');



 









?>
