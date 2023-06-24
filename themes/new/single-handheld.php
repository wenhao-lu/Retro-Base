<?php
    get_header();
    while(have_posts()) {
        the_post(); 
        
        pageBanner();
        
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

        <div class="handheld-details">
            <div class="blog-title">
                <?php the_title(); ?>
            </div>
        </div>

        <div class="generic-content">
            <?php 

global $wpdb;
$handheld_table = $wpdb->prefix . 'handhelds';
$handheldId = get_field('id');
$sql = "SELECT * FROM $handheld_table WHERE id = '$handheldId'";
$results = $wpdb->get_results( $sql );
//var_dump($results);

?>

<div class="table-container">
    <div class="handheld-hero">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($results[0]->image); ?>" 
            alt="Handheld Image" width=600>
    </div>
    <div id="videoContainer"></div>
    <div class="table-wrap">

    <table class="table-shrink handheld-table">
        <tr>
            <th class="shrink-th">Name</th>
            <td class="shrink-td"><?php echo $results[0]->name ?></td>
        </tr>
        <tr>
            <th class="shrink-th">Brand</th>
            <td class="shrink-td"><?php echo $results[0]->brand ?></td>
        </tr>
        <tr>
            <th class="shrink-th">Released</th>
            <td class="shrink-td"><?php echo $results[0]->released ?></td>
        </tr>
    </table>

    <div class="side-table-wrap">
    <table class="side-table">
        <tr class="header-row">
            <th class="header-cell">Review</th>
            <th class="header-cell">Vendor</th>
        </tr>
        <tr class="data-row">
            <td class="data-cell">
                <a href="<?php echo $results[0]->review ?>" target="_blank">
                    <img src="<?php echo get_theme_file_uri('/images/youtube.png') ?>" alt="youtube" width=50>
                </a>
            </td>

    <!--
        <iframe
        class="review-video"
        width="1078"
        height="610"
        src="<?php echo $results[0]->review ?>"
        frameborder="0"
        allow="autoplay; encrypted-media"
        allowfullscreen
        ></iframe>
    -->
            <td class="data-cell">
                <a href="<?php echo $results[0]->vendor ?>" target="_blank">
                    <img src="<?php echo get_theme_file_uri('/images/vendor.png') ?>" alt="vendor" width=50>
                </a>
            </td>
        </tr>
    </table>
    </div>
       
    <!--
    <table class="handheld-side-table">
        <tr>
            <th>Name</th>
            <td>Brand</td>
        </tr>
        <tr>
            <th>Brand</th>
            <td><?php echo $results[0]->brand ?></td>
        </tr>
        <tr>
            <th>Released</th>
            <td><?php echo $results[0]->released ?></td>
        </tr>
    </table>        
    -->
    </div>

    <table class="handheld-table">
        <tr>
            <th class="regular-th">Price</th>
            <td><?php echo $results[0]->price ?></td>
        </tr>
        <tr>
            <th class="regular-th">Performance</th>
            <td>
                <?php for ($i = 0; $i < $results[0]->performance; $i++) { ?>
                    &#127775;
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th class="regular-th">Operating System</th>
            <td><?php echo $results[0]->os ?></td>
        </tr>
        <tr>
            <th class="regular-th">System On A Chip</th>
            <td><?php echo $results[0]->soc ?></td>
        </tr>
        <tr>
            <th class="regular-th">RAM</th>
            <td><?php echo $results[0]->ram ?></td>
        </tr>
        <tr>
            <th class="regular-th">Screen Size</th>
            <td><?php echo $results[0]->screen_size ?></td>
        </tr>
        <tr>
            <th class="regular-th">Screen Type</th>
            <td><?php echo $results[0]->screen_type ?></td>
        </tr>
        <tr>
            <th class="regular-th">Resolution</th>
            <td><?php echo $results[0]->resolution ?></td>
        </tr>
        <tr>
            <th class="regular-th">Pixels Per Inch</th>
            <td><?php echo $results[0]->ppi ?></td>
        </tr>
        <tr>
            <th class="regular-th">Aspect Ratio</th>
            <td><?php echo $results[0]->aspect_ratio ?></td>
        </tr>
        <tr>
            <th class="regular-th">Battery</th>
            <td><?php echo $results[0]->battery ?></td>
        </tr>
        <tr>
            <th class="regular-th">Storage</th>
            <td><?php echo $results[0]->storage ?></td>
        </tr>
        <tr>
            <th class="regular-th">Dimensions</th>
            <td><?php echo $results[0]->dimensions ?></td>
        </tr>
        <tr>
            <th class="regular-th">Weight</th>
            <td><?php echo $results[0]->weight ?></td>
        </tr>
        <tr>
            <th class="regular-th">Material</th>
            <td><?php echo $results[0]->material ?></td>
        </tr>

    </table>
</div>





               
        </div>

        <?php

       
wp_reset_postdata();

// related blog
  $relatedBlog = get_field('related_blog');

  if($relatedBlog){

      echo '<hr class="section-break">';
      echo '<h2 class="headline headline--medium">'. 'Related Blogs: </h2>';
  
      echo '<ul class="min-list link-list">';
      foreach($relatedBlog as $blog){
          ?>  <li><a href="<?php echo get_the_permalink($blog) ?>"><?php echo get_the_title($blog); ?></a></li>
          <?php
      }
      echo '</ul>';
  
  
  }

wp_reset_postdata();

          ?>  


    </div>


    <?php }
    get_footer();
    ?>