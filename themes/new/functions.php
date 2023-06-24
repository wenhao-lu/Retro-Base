<?php

    require get_theme_file_path('/inc/route.php');


    // link CSS and JavaScript
    function custom_files(){
        // link CSS
        // wp_enqueue_style('custom_styles',get_stylesheet_uri());
        wp_enqueue_style('font_google','//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font_awsome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('custom_main_styles',get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('custom_extra_styles',get_theme_file_uri('/build/index.css'));

        // link JavaScript
        // js_file, dependency(NULL), version, load before <document.body>
        wp_enqueue_script('custom_script',get_theme_file_uri('/build/index.js'),array('jquery'),'1.0', true);
    
        // get all the data, setup variable for root url
        // siteData.root_url = domain.com = site root url
        wp_localize_script('custom_script','siteData',array(
            'root_url'=> get_site_url(),
            'nonce'=> wp_create_nonce('wp_rest')
        )); 
    }  
    add_action('wp_enqueue_scripts', 'custom_files');


    // add some features to the CMS 
    function custom_features(){
        // add menu links on the CMS/themes/
        register_nav_menu('headerMenuLocation', 'Header Menu Location');
        register_nav_menu('footerLocationOne', 'Footer Location One');
        register_nav_menu('footerLocationTwo', 'Footer Location Two');

        // auto render every pages' header title
        add_theme_support('title-tag');

        // add thumbnails for the posts in CMS (for non-custom posts)
        add_theme_support('post-thumbnails');

        // add thumbnails for the posts in CMS (for non-custom posts)
        add_theme_support('post-formats',array('chat'));

        // add custom image size 
        // (name, width, height, crop)
        add_image_size('professorLandscape', 400, 260, true);
        add_image_size('professorPortrait', 480, 650, true);
        add_image_size('pageBanner', 1500, 350, true);
        add_image_size('pageSlide', 1500, 700, true);
        add_image_size('frontSquare', 300, 300, true);

    }
    add_action('after_setup_theme', 'custom_features');


    // minapulate the default URL query
    // custom query for events list page
    // sort events order
    function adjust_queries($query){
        // not in admin, and in URL query
        if(!is_admin() & is_post_type_archive('program') & $query-> is_main_query()){
            $query -> set('orderby', 'title');
            $query -> set('order', 'ASC');
            $query -> set('posts_per_page', -1);

        }


        if(!is_admin() & is_post_type_archive('event') & $query-> is_main_query()){
            $today = date('Ymd');
            $query -> set('meta_key', 'event_date');
            $query -> set('orderby', 'meta_value_num');
            $query -> set('order', 'ASC');
            $query -> set('meta_query', array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                ))
            );
        }
    }
    add_action('pre_get_posts', 'adjust_queries');



    // page banner function
    // $args = array (title, subtitle, photo...)    
    function pageBanner($args=[]){
        // logic

        if(!isset($args['title'])){
            $args['title'] = get_the_title();
        }

        if(!isset($args['subtitle'])){
            $args['subtitle'] = get_field('page_banner_subtitle');
        }

        if(!isset($args['photo'])){
            if(get_field('page_banner_background_image') && !is_archive() && !is_home() ){
                $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
            } else {
                $args['photo'] = get_theme_file_uri('/images/banner2.jpg');
            }
        }

        ?>

        <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(
          <?php 
              echo $args['photo']; 
          ?>
          )"></div>
        <div class="page-banner__content container">
          
          <div class="page-banner__intro">
            <p><?php echo $args['subtitle']; ?></p>
          </div>
        </div>
      </div>
      
        <?php
    }


    function modify_rest_api(){
        register_rest_field('post','authorName',array(
            'get_callback' => function(){return get_the_author();}
        ));
        
        register_rest_field('note', 'userNoteCount', array(
            'get_callback' => function() {return count_user_posts(get_current_user_id(), 'note');}
        ));
    }
    add_action('rest_api_init', 'modify_rest_api');

    // redirect user to the main page when logged in
    function redirect_user(){
        $currentUser = wp_get_current_user();
        if(count($currentUser->roles) == 1 && $currentUser->roles[0] == 'subscriber'){
            wp_redirect(site_url('/'));
            exit;
        }

    }
    add_action('admin_init', 'redirect_user');

    add_filter('show_admin_bar', '__return_false');
    // hide the top admin bar to subscriber users
    function hideAdminBar(){
        $currentUser = wp_get_current_user();
        if(count($currentUser->roles) == 1 && $currentUser->roles[0] == 'editor'){
            show_admin_bar(false);
        }
    }
    add_action('wp_loaded', 'hideAdminBar');

    // customize login screen
    // 
    function customHeaderUrl(){
        return esc_url(site_url('/'));
    }
    add_filter('login_headerurl', 'customHeaderUrl');

    function customLoginStyle(){
        wp_enqueue_style('font_google','//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font_awsome','//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('custom_main_styles',get_theme_file_uri('/build/style-index.css'));
        wp_enqueue_style('custom_extra_styles',get_theme_file_uri('/build/index.css'));
    }
    add_filter('login_enqueue_scripts', 'customLoginStyle');  


    function customLoginTitle(){
        return get_bloginfo('name');
    }
    add_filter('login_headertitle', 'customLoginTitle');  


    // make all new notes to be created privately
    
    function notePrivate($data, $postArray) {
        if ($data['post_type'] == 'note') {
            // limit the user created notes to 5  
            if(count_user_posts(get_current_user_id(), 'note') > 40 && !$postArray['ID']) {
                die("You have reached your note limit.");
            }

        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
        }

        if($data['post_type'] == 'note' && $data['post_status'] != 'trash') {
            $data['post_status'] = "private";
        }
  
        return $data;
    }
    // modify POST data before it is inserted into the database
    // 6 = run priority, 2 = 2 parameters
    add_filter('wp_insert_post_data', 'notePrivate', 6, 2);

    
      


// create-handhelds-table
global $wpdb;
$handhelds = $wpdb->prefix . 'handhelds';
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE $handhelds (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    brand VARCHAR(255),
    released VARCHAR(255),
    price VARCHAR(255),
    os VARCHAR(255),
    soc VARCHAR(255),
    ram VARCHAR(255),
    screen_size VARCHAR(255),
    screen_type VARCHAR(255),
    resolution VARCHAR(255),
    ppi VARCHAR(255),
    aspect_ratio VARCHAR(255),
    battery varchar(255),
    storage VARCHAR(255),
    dimensions VARCHAR(255),
    weight VARCHAR(255),
    material VARCHAR(255),
    review VARCHAR(255),
    vendor VARCHAR(255),
    image BLOB,
    performance INT(11),
    PRIMARY KEY (id)
) $charset_collate;";

require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta($sql);


add_action( 'admin_init', 'add_handheld_meta_boxes' );

function add_handheld_meta_boxes() {
    add_meta_box( 
        'handheld_meta_box',
        'Handheld Details', // Title for the meta box
        'render_handheld_meta_box', // Callback function to render the meta box UI
        'handheld', // Post type
        'normal', 
        'high'
    );
}

function render_handheld_meta_box() 
{
    ?>
    <table>
        <tr>
            <th><label for="handheld-id">ID</label></th>
            <td><input type="text" name="handheld-id" id="handheld-id" readonly value="<?php echo get_post_meta( get_the_ID() , 'id', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-name">Name</label></th>
            <td><input type="text" name="handheld-name" id="handheld-name" readonly value="<?php echo get_post_meta( get_the_ID() , 'name', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-brand">Brand</label></th>
            <td><input type="text" name="handheld-brand" id="handheld-brand" readonly value="<?php echo get_post_meta( get_the_ID() , 'brand', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-released">Released</label></th>
            <td><input type="text" name="handheld-released" id="handheld-released" readonly value="<?php echo get_post_meta( get_the_ID() , 'released', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-price">Price</label></th>
            <td><input type="text" name="handheld-price" id="handheld-price" readonly value="<?php echo get_post_meta( get_the_ID() , 'price', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-os">Operating System</label></th>
            <td><input type="text" name="handheld-os" id="handheld-os" readonly value="<?php echo get_post_meta( get_the_ID() , 'os', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-soc">System On A Chip</label></th>
            <td><input type="text" name="handheld-soc" id="handheld-soc" readonly value="<?php echo get_post_meta( get_the_ID() , 'soc', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-ram">RAM</label></th>
            <td><input type="text" name="handheld-ram" id="handheld-ram" readonly value="<?php echo get_post_meta( get_the_ID() , 'ram', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-screen_size">Screen Size</label></th>
            <td><input type="text" name="handheld-screen_size" id="handheld-screen_size" readonly value="<?php echo get_post_meta( get_the_ID() , 'screen_size', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-screen_type">Screen Type</label></th>
            <td><input type="text" name="handheld-screen_type" id="handheld-screen_type" readonly value="<?php echo get_post_meta( get_the_ID() , 'screen_type', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-resolution">Resolution</label></th>
            <td><input type="text" name="handheld-resolution" id="handheld-resolution" readonly value="<?php echo get_post_meta( get_the_ID() , 'resolution', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-ppi">Pixels Per Inch</label></th>
            <td><input type="text" name="handheld-ppi" id="handheld-ppi" readonly value="<?php echo get_post_meta( get_the_ID() , 'ppi', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-aspect_ratio">Aspect Ratio</label></th>
            <td><input type="text" name="handheld-aspect_ratio" id="handheld-aspect_ratio" readonly value="<?php echo get_post_meta( get_the_ID() , 'aspect_ratio', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-battery">Battery</label></th>
            <td><input type="text" name="handheld-battery" id="handheld-battery" readonly value="<?php echo get_post_meta( get_the_ID() , 'battery', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-storage">Storage</label></th>
            <td><input type="text" name="handheld-storage" id="handheld-storage" readonly value="<?php echo get_post_meta( get_the_ID() , 'storage', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-dimensions">Dimensions</label></th>
            <td><input type="text" name="handheld-dimensions" id="handheld-dimensions" readonly value="<?php echo get_post_meta( get_the_ID() , 'dimensions', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-weight">Weight</label></th>
            <td><input type="text" name="handheld-weight" id="handheld-weight" readonly value="<?php echo get_post_meta( get_the_ID() , 'weight', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-material">Material</label></th>
            <td><input type="text" name="handheld-material" id="handheld-material" readonly value="<?php echo get_post_meta( get_the_ID() , 'material', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-performance">Performance</label></th>
            <td><input type="text" name="handheld-performance" id="handheld-performance" readonly value="<?php echo get_post_meta( get_the_ID() , 'performance', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-review">Review</label></th>
            <td><input type="text" name="handheld-review" id="handheld-review" readonly value="<?php echo get_post_meta( get_the_ID() , 'review', true ); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-vendor">Vendor</label></th>
            <td><input type="text" name="handheld-vendor" id="handheld-vendor" readonly value="<?php echo get_post_meta( get_the_ID() , 'vendor', true ); ?>"></td>
        </tr>
        
        <!-- show the image
        <tr>
            <th><label for="handheld-image">Image</label></th>
            <td>
                <?php
                    $imageData = get_post_meta(get_the_ID(), 'image', true);
                    if ($imageData) {
                        $imageSrc = 'data:image/jpeg;base64,' . base64_encode($imageData);
                        echo '<img src="' . $imageSrc . '" alt="Handheld Image">';
                    }
                ?>
            </td>
        </tr>
        -->
    </table>
    <?php
}

add_action( 'wp', 'data_to_cpt');

function verify_existing_data_cpt() {

    $id_arrays_in_cpt = [];
    // Query all handhelds
    $args = array(
        'post_type'      => 'handheld',
        'posts_per_page' => -1,
    );

    $loop = new WP_Query($args);
    while ( $loop->have_posts() ) {
        $loop->the_post();
        $id_arrays_in_cpt[] = get_post_meta( get_the_ID() , 'id', true );
    }
    //var_dump($id_arrays_in_cpt);
    return $id_arrays_in_cpt;
}

function query_data_table( $handheld_available_in_cpt_array ) {
    // Query Database
    global $wpdb;
    $table_name = $wpdb->prefix . 'handhelds';

    
    if ( NULL === $handheld_available_in_cpt_array || empty( $handheld_available_in_cpt_array ) || 0 === $handheld_available_in_cpt_array || '0' === $handheld_available_in_cpt_array) {
        $sql = "SELECT * FROM $table_name";
    } else {
        $ids = implode( "','", $handheld_available_in_cpt_array);
        $sql = "SELECT * FROM $table_name WHERE id NOT IN ( '$ids' )";
    }

    $results = $wpdb->get_results( $sql );
    //var_dump($results);
    return $results;

}

function data_to_cpt() {

    // if the queried results from don't match
    $handheld_available_in_cpt_array = verify_existing_data_cpt();
    $database_results = query_data_table( $handheld_available_in_cpt_array );
    //var_dump($database_results);
    if ( NULL === $database_results || empty( $database_results ) || 0 === $database_results || '0' === $database_results) {
        return;
    }
 
    //Insert into CPT
    foreach( $database_results as $result ) {
        // Create post object
        $handheld_data = array(
            'post_title'  => wp_strip_all_tags( $result->name),
            'meta_input'  => array(
                'id'         => $result->id,
                'name'      => $result->name,
                'brand'      => $result->brand,
                'released'      => $result->released,
                'price'         => $result->price,
                'os'         => $result->os,
                'soc'         => $result->soc,
                'ram'         => $result->ram,
                'screen_size'         => $result->screen_size,
                'screen_type'         => $result->screen_type,
                'resolution'         => $result->resolution,
                'ppi'         => $result->ppi,
                'aspect_ratio'         => $result->aspect_ratio,
                'battery'         => $result->battery,
                'storage'         => $result->storage,
                'dimensions'         => $result->dimensions,
                'weight'         => $result->weight,
                'material'         => $result->material,
                'review'         => $result->review,
                'vendor'         => $result->vendor,
                'image'         => $result->image,
                'performance'         => $result->performance,
            ),
            'post_type'   => 'handheld',
            'post_status' => 'publish',
        );
        // Insert the post into the database
        wp_insert_post( $handheld_data );
    }
}
















/*
add_action('add_meta_boxes', 'add_handheld_meta_boxes');
function add_handheld_meta_boxes() {
    add_meta_box(
        'handheld_meta_box',
        'Handheld Details', // Title for the meta box
        'render_handheld_meta_box', // Callback function to render the meta box UI
        'handheld', // Post type
        'normal', // Context (e.g., normal, advanced, side)
        'default' // Priority (e.g., default, high, low)
    );
}

function render_handheld_meta_box($post) {
    // Retrieve the stored meta values
    $name = get_post_meta($post->ID, 'name', true);
    $brand = get_post_meta($post->ID, 'brand', true);
    $released = get_post_meta($post->ID, 'released', true);
    $price = get_post_meta($post->ID, 'price', true);
    $os = get_post_meta($post->ID, 'os', true);
    $soc = get_post_meta($post->ID, 'soc', true);
    $ram = get_post_meta($post->ID, 'ram', true);
    $screen_size = get_post_meta($post->ID, 'screen_size', true);
    $screen_type = get_post_meta($post->ID, 'screen_type', true);
    $resolution = get_post_meta($post->ID, 'resolution', true);
    $ppi = get_post_meta($post->ID, 'ppi', true);
    $aspect_ratio = get_post_meta($post->ID, 'aspect_ratio', true);
    $battery = get_post_meta($post->ID, 'battery', true);
    $storage = get_post_meta($post->ID, 'storage', true);
    $dimensions = get_post_meta($post->ID, 'dimensions', true);
    $weight = get_post_meta($post->ID, 'weight', true);
    $material = get_post_meta($post->ID, 'material', true);
    $review = get_post_meta($post->ID, 'review', true);
    $vendor = get_post_meta($post->ID, 'vendor', true);
    // Add more fields as per your table structure
    
    // Output the HTML for the meta box UI
    ?>
    <form method="post" action="">
        <tr>
            <th><label for="handheld-name">Name</label></th>
            <td><input type="text" name="handheld-name" id="handheld-name" value="<?php echo esc_attr($name); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-brand">Brand</label></th>
            <td><input type="text" name="handheld-brand" id="handheld-brand" value="<?php echo esc_attr($brand); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-released">Released</label></th>
            <td><input type="text" name="handheld-released" id="handheld-released" value="<?php echo esc_attr($released); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-price">Price</label></th>
            <td><input type="text" name="handheld-price" id="handheld-price" value="<?php echo esc_attr($price); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-os">Operating System</label></th>
            <td><input type="text" name="handheld-os" id="handheld-os" value="<?php echo esc_attr($os); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-soc">System On A Chip</label></th>
            <td><input type="text" name="handheld-soc" id="handheld-soc" value="<?php echo esc_attr($soc); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-ram">RAM</label></th>
            <td><input type="text" name="handheld-ram" id="handheld-ram" value="<?php echo esc_attr($ram); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-screen_size">Screen Size</label></th>
            <td><input type="text" name="handheld-screen_size" id="handheld-screen_size" value="<?php echo esc_attr($screen_size); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-screen_type">Screen Type</label></th>
            <td><input type="text" name="handheld-screen_type" id="handheld-screen_type" value="<?php echo esc_attr($screen_type); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-resolution">Resolution</label></th>
            <td><input type="text" name="handheld-resolution" id="handheld-resolution" value="<?php echo esc_attr($resolution); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-ppi">Pixels Per Inch</label></th>
            <td><input type="text" name="handheld-ppi" id="handheld-ppi" value="<?php echo esc_attr($ppi); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-aspect_ratio">Aspect Ratio</label></th>
            <td><input type="text" name="handheld-aspect_ratio" id="handheld-aspect_ratio" value="<?php echo esc_attr($aspect_ratio); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-battery">Battery</label></th>
            <td><input type="text" name="handheld-battery" id="handheld-battery" value="<?php echo esc_attr($battery); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-storage">Storage</label></th>
            <td><input type="text" name="handheld-storage" id="handheld-storage" value="<?php echo esc_attr($storage); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-dimensions">Dimensions</label></th>
            <td><input type="text" name="handheld-dimensions" id="handheld-dimensions" value="<?php echo esc_attr($dimensions); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-weight">Weight</label></th>
            <td><input type="text" name="handheld-weight" id="handheld-weight" value="<?php echo esc_attr($weight); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-material">Material</label></th>
            <td><input type="text" name="handheld-material" id="handheld-material" value="<?php echo esc_attr($material); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-review">Review</label></th>
            <td><input type="text" name="handheld-review" id="handheld-review" value="<?php echo esc_attr($review); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-vendor">Vendor</label></th>
            <td><input type="text" name="handheld-vendor" id="handheld-vendor" value="<?php echo esc_attr($vendor); ?>"></td>
        </tr>
        <tr>
            <th><label for="handheld-image">Image</label></th>
            <td><input type="file" name="handheld-image" id="handheld-image"></td>
        </tr>

        <button type="submit" name="handheld-submit" id="handheld-submit" class="handheld-submit btn btn-primary">Submit</button>
    </form>

    <?php
}


// CRUD functions for 'Handheld'
// Hook the save_handheld_meta_box_data() function to the save_post action
add_action('save_post', 'save_handheld_meta_box_data');

// Save the meta box data when the post is saved or updated
function save_handheld_meta_box_data($post_id) {
    // Check if the save action is triggered for the "handhelds" custom post type
    if ('handhelds' !== get_post_type($post_id)) {
        return; // Exit function if it's not the "handhelds" custom post type
    }

    if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
        // Handle image upload
        $image_data = wp_handle_upload($_FILES['image'], array('test_form' => false));
        if (!isset($image_data['error'])) {
            $image_url = $image_data['url'];
            $image_id = wp_insert_attachment(array(
                'post_mime_type' => $image_data['type'],
                'post_title' => sanitize_file_name($_FILES['image']['name']),
                'post_content' => '',
                'post_status' => 'inherit'
            ), $image_data['file'], $post_id);
            if (!is_wp_error($image_id)) {
                update_post_meta($post_id, 'image_id', $image_id);
                update_post_meta($post_id, 'image_url', $image_url);
            }
        }
    }


    // Save the input data to the 'handhelds' table
    global $wpdb;

    $table_name = $wpdb->prefix . 'handhelds';
    $data = array(
        'name' => $_POST['name'],
        'brand' => $_POST['brand'],
        'released' => $_POST['released'],
        'price' => $_POST['price'],
        'os' => $_POST['os'],
        'soc' => $_POST['soc'],
        'ram' => $_POST['ram'],
        'screen_size' => $_POST['screen_size'],
        'screen_type' => $_POST['screen_type'],
        'resolution' => $_POST['resolution'],
        'ppi' => $_POST['ppi'],
        'aspect_ratio' => $_POST['aspect_ratio'],
        'battery' => $_POST['battery'],
        'storage' => $_POST['storage'],
        'dimensions' => $_POST['dimensions'],
        'weight' => $_POST['weight'],
        'material' => $_POST['material'],
        'review' => $_POST['review'],
        'vendor' => $_POST['vendor'],
        'image_id' => $_POST['image_id'],
        'image_url' => $_POST['image_url'],
    );

    $wpdb->insert($table_name, $data);
}

*/

// ignore dev package files when exporting site for deploying
add_filter('ai1wm_exclude_content_from_export', 'ignoreFiles');

function ignoreFiles($ignore_filter){
    $ignore_filter[] = 'themes/new/node_modules';
    return $ignore_filter;

}



// fetch the slected handhelds' id from the database
// comparison function 
add_action('wp_ajax_retrieve_handheld_id', 'retrieve_handheld_id');
add_action('wp_ajax_nopriv_retrieve_handheld_id', 'retrieve_handheld_id');

function retrieve_handheld_id() {
  if (isset($_POST['handheldName'])) {
    $handheldName = sanitize_text_field($_POST['handheldName']);

    global $wpdb;
    $handheld_table = $wpdb->prefix . 'handhelds';
    $handheld_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM $handheld_table WHERE name = %s", $handheldName));

    if ($handheld_id) {
      echo $handheld_id;
    } else {
      echo '0';
    }
  }
  wp_die();
}



function restrict_wp_admin_access() {
    // Check if the current user is not an administrator
    if (!current_user_can('administrator') && strpos($_SERVER['REQUEST_URI'], '/wp-admin') !== false) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('init', 'restrict_wp_admin_access');





?>