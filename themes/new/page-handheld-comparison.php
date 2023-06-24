<?php
require_once(ABSPATH . 'wp-load.php');

get_header();

while(have_posts()) {
        
  the_post(); 
  
  pageBanner();
}

?>
 <div class="container container--narrow page-section">

<div class="metabox metabox--position-up metabox--with-home-link">
    <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('handheld'); ?>">
            <i class="fa fa-gamepad" aria-hidden="true"></i> All Handhelds
        </a>
            <span class="metabox__main">
                <?php the_title(); ?> 
            </span>
    </p>
</div>
</div>

<?php

// Retrieve the handheld IDs from the query parameters
$handheld1Id = $_GET['handheld1'];
$handheld2Id = $_GET['handheld2'];


// Retrieve the handheld data based on the IDs
$handheld1 = retrieve_handheld_by_id($handheld1Id);
$handheld2 = retrieve_handheld_by_id($handheld2Id);


if ($handheld1 && $handheld2) {
    // Display the handheld comparison view
    ?>

    <div class="comparison-container">
        <h1 class="blog-title compare-title">Handheld Compare</h1>
    </div>

  <?php foreach($handheld1 as $handheld1s) { ?>  
    <?php foreach($handheld2 as $handheld2s) { ?>              
  <div class="compare-table-wrap">

  <table class="handheld-compare-table">
  <tr>
    <th></th>
    <th>
    <div class="handheld-image">
      <img src="data:image/jpeg;base64,<?php echo base64_encode($handheld1s->image); ?>" 
        alt="Handheld Image" width=400>
    </div>
    </th>
    <th> 
    <div class="handheld-image">
      <img src="data:image/jpeg;base64,<?php echo base64_encode($handheld2s->image); ?>" 
        alt="Handheld Image" width=400>
    </div>
    </th>
  </tr>
  <tr>
    <th></th>
    <th class="table-col-name1"><?php echo $handheld1s->name; ?></th>
    <th class="table-col-name2"><?php echo $handheld2s->name; ?></th>
  </tr>
  <tr>
    <td></td>
    <td class="table-col" id="col-big"><?php echo $handheld1s->price; ?></td>
    <td class="table-col" id="col-big"><?php echo $handheld2s->price; ?></td>
  </tr>
  <tr>
    <td></td>
    <td class="table-col" id="col-big-sub">Starting Price</td>
    <td class="table-col" id="col-big-sub">Starting Price</td>
  </tr>
  <tr>
    <td class="table-row">Performance</td>
    <td class="table-col">      
      <?php for ($i = 0; $i < $handheld1s->performance; $i++) { ?>
      &#127775; <?php } ?></td>
      <td class="table-col">      
      <?php for ($i = 0; $i < $handheld2s->performance; $i++) { ?>
      &#127775; <?php } ?></td>
  </tr>
  <tr>
    <td class="table-row col-dark">Brand</td>
    <td class="table-col col-dark"><?php echo $handheld1s->brand; ?></td>
    <td class="table-col col-dark"><?php echo $handheld2s->brand; ?></td>
  </tr>
  <tr>
    <td class="table-row">Released</td>
    <td class="table-col"><?php echo $handheld1s->released; ?></td>
    <td class="table-col"><?php echo $handheld2s->released; ?></td>
  </tr>
  <tr>
    <td class="table-row col-dark">Operating System</td>
    <td class="table-col col-dark"><?php echo $handheld1s->os; ?></td>
    <td class="table-col col-dark"><?php echo $handheld2s->os; ?></td>
  </tr>
  <tr>
    <td class="table-row">System On A Chip</td>
    <td class="table-col"><?php echo $handheld1s->soc; ?></td>
    <td class="table-col"><?php echo $handheld2s->soc; ?></td>
  </tr>
  <tr>
    <td class="table-row col-dark">RAM</td>
    <td class="table-col col-dark"><?php echo $handheld1s->ram; ?></td>
    <td class="table-col col-dark"><?php echo $handheld2s->ram; ?></td>
  </tr>
  <tr>
    <td class="table-row">Screen Size</td>
    <td class="table-col"><?php echo $handheld1s->screen_size; ?></td>
    <td class="table-col"><?php echo $handheld2s->screen_size; ?></td>
  </tr>
  <tr>
    <td class="table-row col-dark">Screen Type</td>
    <td class="table-col col-dark"><?php echo $handheld1s->screen_type; ?></td>
    <td class="table-col col-dark"><?php echo $handheld2s->screen_type; ?></td>
  </tr>
  <tr>
    <td class="table-row">Resolution</td>
    <td class="table-col"><?php echo $handheld1s->resolution; ?></td>
    <td class="table-col"><?php echo $handheld2s->resolution; ?></td>
  </tr>
  <tr>
    <td class="table-row col-dark">Pixels Per Inch</td>
    <td class="table-col col-dark"><?php echo $handheld1s->ppi; ?></td>
    <td class="table-col col-dark"><?php echo $handheld2s->ppi; ?></td>
  </tr>
  <tr>
    <td class="table-row">Aspect Ratio</td>
    <td class="table-col"><?php echo $handheld1s->aspect_ratio; ?></td>
    <td class="table-col"><?php echo $handheld2s->aspect_ratio; ?></td>
  </tr>
  <tr>
    <td class="table-row col-dark">Battery</td>
    <td class="table-col col-dark"><?php echo $handheld1s->battery; ?></td>
    <td class="table-col col-dark"><?php echo $handheld2s->battery; ?></td>
  </tr>
  <tr>
    <td class="table-row">Storage</td>
    <td class="table-col"><?php echo $handheld1s->storage; ?></td>
    <td class="table-col"><?php echo $handheld2s->storage; ?></td>
  </tr>
  <tr>
    <td class="table-row col-dark">Dimensions</td>
    <td class="table-col col-dark"><?php echo $handheld1s->dimensions; ?></td>
    <td class="table-col col-dark"><?php echo $handheld2s->dimensions; ?></td>
  </tr>
  <tr>
    <td class="table-row">Weight</td>
    <td class="table-col"><?php echo $handheld1s->weight; ?></td>
    <td class="table-col"><?php echo $handheld2s->weight; ?></td>
  </tr>
  <tr>
    <td class="table-row col-dark">Material</td>
    <td class="table-col col-dark"><?php echo $handheld1s->material; ?></td>
    <td class="table-col col-dark"><?php echo $handheld2s->material; ?></td>
  </tr>
  <tr>
    <td class="table-row">Review</td>
    <td class="table-col">
      <a href="<?php echo $handheld1s->review ?>" target="_blank">
        <img src="<?php echo get_theme_file_uri('/images/youtube.png') ?>" alt="youtube" width=50>
      </a>    
    </td>
    <td class="table-col">
      <a href="<?php echo $handheld2s->review ?>" target="_blank">
        <img src="<?php echo get_theme_file_uri('/images/youtube.png') ?>" alt="youtube" width=50>
      </a>    
    </td>
  </tr>
  <tr>
    <td class="table-row col-dark">Vendor</td>
    <td class="table-col col-dark">
      <a href="<?php echo $handheld1s->vendor ?>" target="_blank">
        <img src="<?php echo get_theme_file_uri('/images/vendor.png') ?>" alt="vendor" width=50>
      </a>
    </td>
    <td class="table-col col-dark">
      <a href="<?php echo $handheld2s->vendor ?>" target="_blank">
        <img src="<?php echo get_theme_file_uri('/images/vendor.png') ?>" alt="vendor" width=50>
      </a>
    </td>
  </tr>
</table>
<?php } }?>



</div>

<!--
<?php foreach($handheld2 as $handheld2s) { ?>  

<table class="handheld-table-2">
  <tr>
    <th>
    <div class="handheld-image-1">
      <img src="data:image/jpeg;base64,<?php echo base64_encode($handheld2s->image); ?>" 
        alt="Handheld Image" width=400>
    </div>
    </th>
  </tr>  
  <tr>
    <th class="table-col-name2"><?php echo $handheld2s->name; ?></th>
  </tr>
  <tr>
    <td class="table-col-1">Price</td>
  </tr>
  <tr>
    <td class="table-col-1"><?php echo $handheld2s->price; ?></td>
  </tr>
  <tr>
    <td class="table-col">
      <?php for ($i = 0; $i < $handheld2s->performance; $i++) { ?>
      &#127775; <?php } ?>
    </td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->brand; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->released; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->os; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->soc; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->ram; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->screen_size; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->screen_type; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->resolution; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->ppi; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->aspect_ratio; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->battery; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->storage; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->dimensions; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->weight; ?></td>
  </tr>
  <tr>
    <td class="table-col"><?php echo $handheld2s->material; ?></td>
  </tr>
  <tr>
    <td class="table-col">
      <a href="<?php echo $handheld2s->review ?>" target="_blank">
        <img src="<?php echo get_theme_file_uri('/images/youtube.png') ?>" alt="youtube" width=50>
      </a>    
    </td>
  </tr>

  <tr>
    <td class="table-col">
      <a href="<?php echo $handheld2s->vendor ?>" target="_blank">
        <img src="<?php echo get_theme_file_uri('/images/vendor.png') ?>" alt="vendor" width=50>
      </a></td>
    </td>
  </tr>
</table>
<?php } ?>


      -->














    <?php
} else {
    // Display an error message if one or both handhelds are not found
    echo '<p>Error: Handheld(s) not found</p>';
}

// Function to retrieve handheld details by ID from the custom database
function retrieve_handheld_by_id($handheldId) {

  global $wpdb;
  $handheld_table = $wpdb->prefix . 'handhelds';
  $query = $wpdb->prepare(
      "SELECT * FROM $handheld_table WHERE id = %d", $handheldId );
  $results = $wpdb->get_results( $query );
  //var_dump( $results );
    return $results;
}

?>


<?php get_footer(); ?>

