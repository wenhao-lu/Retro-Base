<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo('charset') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<script type="module" src="<?php get_theme_file_uri('/src/index.js') ?>"></script>-->
    <?php wp_head();  ?>
</head>

<body <?php body_class() ?>>

<header class="site-header">
      <div class="container">
        <h1 class="logo-text float-left">
          <a href="<?php echo site_url() ?>">
          <span class="site-header__name"><strong>Retro</strong></span>
          <span class="site-header__name">Base</span></a>
        </h1>
        <a href="<?php echo esc_url(site_url('/search')); ?>" class="js-search-trigger site-header__search-trigger">
          <i class="fa fa-search" aria-hidden="true"></i></a>
        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <div class="site-header__menu group">
          <nav class="main-navigation">
            <!--
            <?php 
                // dynamic nav menu
                wp_nav_menu(array(
                'theme_location' => 'headerMenuLocation'
                ));
            ?>
            -->

            
            <ul>
              <li 
                <?php 
                    // if the page is 'about-us', give the link a style
                    // or the children page of 'about-us', give the link a style
                    // wp_get_post_parent_id(0) => current page's parent id
                    if (is_page('about-us') || wp_get_post_parent_id(0) == 22) 
                    echo 'class="current-menu-item"' 
                ?>>
                <a href="<?php echo site_url('/about-us'); ?>">About</a></li>

              <li 
                <?php 
                    if (get_post_type() == 'post') 
                    echo 'class="current-menu-item"' 
                ?>>
                <a href="<?php echo site_url('/blog'); ?>">Blog</a>
              </li>  

              <li 
                <?php 
                    if (get_post_type() == 'handheld') 
                    echo 'class="current-menu-item"' 
                ?>>
              <a href="<?php echo get_post_type_archive_link('handheld'); ?>">Handhelds</a></li>

            </ul>
            

          </nav>
          <div class="site-header__util">
            <!-- when the user logged in
                 show the log out button and user avatar
                 and the 'notes' section -->
            <?php if(is_user_logged_in()){ ?>
        
              <a href="<?php echo esc_url(site_url('/my-notes')); ?>
                " class="btn btn--small btn--orange float-left push-right">Notes</a>
              <a href="<?php echo wp_logout_url(); ?>
              " class="btn btn--small btn--dark-orange float-left btn--with-photo">
              <span class="site-header__avatar"><?php echo get_avatar(get_current_user_id(), 60); ?></span>
              <span class="btn__text">Log Out</span></a>

            <?php
            } else { ?>
            <!-- when the user is not logged in
                 show the login and signup buttons -->
              <a href="<?php echo wp_login_url(); ?>
                " class="btn btn--small btn--orange float-left push-right">Login</a>
              <a href="<?php echo wp_registration_url(); ?>
                " class="btn btn--small btn--dark-orange float-left">Sign Up</a>

            <?php 
            } ?>

            


            <a href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </header>

