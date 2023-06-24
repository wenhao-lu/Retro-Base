<?php
    get_header(); 
    
    pageBanner(array(

    ));
    
    ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo site_url('/'); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i> Home
                </a>
                    <span class="metabox__main">
                        Blog List
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
                <p><a class="btn btn--blue" href="<?php the_permalink(); ?>" >Continue reading &raquo;</a></p>
            </div>

            <hr class="section-break">    

        <?php    }

            echo paginate_links();  
        ?>

    </div>


<?php
    get_footer();
?> 