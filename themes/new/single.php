  <?php
    get_header();
    

    while(have_posts()) {
        
        the_post(); 
        
        pageBanner();
        
        ?>


    <div class="container container--narrow page-section">

        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Blog Home
                </a> 
                    <span class="metabox__main">
                        Posted by <?php the_author_posts_link(); ?> 
                        on  <?php the_time('n.j.y'); ?> 
                        in <?php echo get_the_category_list(', '); ?>
                    </span>
            </p>
        </div>


        <div class="generic-content">
            <div class="blog-title">
                <?php the_title(); ?>
            </div>
            <?php 
                the_content(); 
            ?>
        </div>

        <?php
        wp_reset_postdata();

        // related handhelds
          $relatedHandhelds = get_field('related_handhelds');
        
          if($relatedHandhelds){
        
              echo '<hr class="section-break">';
              echo '<h2 class="headline headline--medium">'. 'Related Handheld: </h2>';
          
              echo '<ul class="min-list link-list">';
              foreach($relatedHandhelds as $handheld){
                  ?>  <li><a href="<?php echo get_the_permalink($handheld) ?>"><?php echo get_the_title($handheld); ?></a></li>
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