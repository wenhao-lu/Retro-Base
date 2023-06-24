<?php
    get_header();
    while(have_posts()) {
        the_post(); 

        pageBanner(
          /*
          array(
          //'title' => 'Hello title',
          //'subtitle' => 'Hi, this is the subtitle',
          //'photo' => 'https://www.timeoutdubai.com/cloud/timeoutdubai/2021/09/11/hfpqyV7B-IMG-Dubai-UAE.jpg'
          )*/
        ); ?>
        



    <div class="container container--narrow page-section">
    <?php

        // the_title();          output the title
        // the_ID();             output the id
        // echo get_the_ID();    get id for you to use
        // echo wp_get_post_parant_id(get_the_ID());
        $theParent = wp_get_post_parent_id(get_the_ID());

        if ($theParent){  ?>

      <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
          <a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>">
            <i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php  the_title(); ?></span>
        </p>
      </div>

    <?php }
    ?>



    <?php
    
    $terstArray = get_pages(array(
        'child_of' => get_the_ID()
    ));
    
    // if have parent page, then show children links, or
    // if no parent/children relationships, don't show side nav links   
    if($theParent || $terstArray){ ?>     

      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
        <ul class="min-list">
            <?php 
            if ($theParent){
                $findChildrenOf = $theParent;
            } else {
                $findChildrenOf = get_the_ID();
            }
            
            wp_list_pages(array(
                'title_li' => NULL,
                'child_of' => $findChildrenOf,
                'cort_column' => 'menu_order'
            )); ?>

        </ul>
      </div>
    <?php }
    ?>

      <div class="generic-content">
        <?php  the_content(); ?>
      </div>
    </div>


    <?php }
    get_footer();
    ?>