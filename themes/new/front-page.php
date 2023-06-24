

    <!-- 
    // from site title
    <h1><?php bloginfo('name') ?></h1>
    // from Tagline
    <p><?php bloginfo('description') ?></p>
    -->


    <?php get_header(); ?>


    <div class="page-banner">
      <div class="page-banner__bg-image" 
        style="background-image: 
            url(
                <?php 
                    echo get_theme_file_uri('/images/6348966_3264451.jpg')
                ?>
            ) 
            ;">
    </div>
      <div class="page-banner__content container t-center c-white">
        <h1 class="headline headline--large">Welcome!</h1>
        <h2 class="headline headline--medium">The world of retro handhelds.</h2>
        <h3 class="headline headline--small">Relive your nostalgic gaming memories.</h3>
        <a href="<?php echo get_post_type_archive_link('handheld'); ?>" class="btn btn--large btn--blue">Find Your Device</a>
      </div>
    </div>


    <!-- Blog news section -->          
      <div class="front-news-wrap">
        <div class="front-news">

          <?php 
            $homepagePosts = new WP_Query(array(
                'posts_per_page' => 4
                //'catagory_name' => 'news',
                //'post_type' => 'page'
            ));

            while($homepagePosts -> have_posts()){
                $homepagePosts -> the_post(); ?>

                <div class="news-summary">

                  <div class="news-summary-content">
                    <?php the_post_thumbnail();?>
                      <div class="front-content-wrap">
                      <h5 class="news-summary__title headline headline--tiny">
                        <a href="<?php the_permalink(); ?>">
                          <?php the_title(); ?>
                        </a>
                      </h5>
                      <p class="front-content"><?php echo wp_trim_words(get_the_content(), 18); ?></p>
                      <p class="front-date"><span><?php the_time('M'); ?></span><span><?php the_time('d'); ?></span></p>
                      </div>
                  </div> 
                </div>
              <?php   } 

            // reset query
            wp_reset_postdata(); 
          ?>
          
        </div>
        <p class="btn-blue-wrap t-center"><a href="<?php echo site_url('/blog'); ?>" 
            class="btn btn--blue">View All Blog Posts</a>
          </p>
      </div>
    </div>

    <!-- hero slider section -->     
    <div class="hero-slider">
      <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
          <div class="hero-slider__slide" style="background-image: url(
                <?php 
                    echo get_theme_file_uri('/images/slider-1-1.jpg')
                ?>
            )">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">ROG ALLY </h2>
                <p class="t-center">New incredible powerhouse in your pocket</p>
                <p class="t-center no-margin"><a href="<?php echo site_url('/handhelds/rog-ally');?>" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(
                <?php 
                    echo get_theme_file_uri('/images/slider-2.jpg')
                ?>
            )">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">RGB20S</h2>
                <p class="t-center">Powkiddy's little cuties on the go</p>
                <p class="t-center no-margin"><a href="<?php echo site_url('/handhelds/rgb20s');?>" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>      
          </div>
          <div class="hero-slider__slide" style="background-image: url(
                <?php 
                    echo get_theme_file_uri('/images/slider-3.png')
                ?>
            )">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center">Retroid Pocket 3+</h2>
                <p class="t-center">Affordable devices, the ultimate bang for your buck</p>
                <p class="t-center no-margin"><a href="<?php echo site_url('/handhelds/retroid-pocket-3');?>" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
        </div>
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
      </div>
    </div>





    <?php get_footer();  ?>

