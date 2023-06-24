<?php
    get_header(); 
    
    pageBanner(array(
      'title' => get_the_archive_title(),
      'subtitle' => get_the_archive_description()
    ));

    ?>
    

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>">
                    <i class="fa fa-rss" aria-hidden="true"></i> Blogs
                </a>
                    <span class="metabox__main">
                        Blog Category
                    </span>
            </p>
        </div>

        <?php
            while(have_posts()){
                the_post(); ?>
            <div class="post-item">
                <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h2>
            </div>

            <div class="metabox">
                <p>Posted by <?php the_author_posts_link(); ?> on  <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></p>
            </div>

            <div class="generic-content">
                <?php the_excerpt(); ?>
                <p><a class="btn btn--blue" href="<?php the_permalink(); ?>" >Read More &raquo;</a></p>
            </div>


        <?php    }

            echo paginate_links();  
        ?>

    </div>


<?php
    get_footer();
?> 