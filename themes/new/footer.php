<footer class="site-footer">
      <div class="site-footer__inner container">
        <div class="group">
          <div class="site-footer__col-one">
            <h1>
              <a class="footer-name" href="<?php echo site_url() ?>"><strong>Retro</strong> Base</a>
            </h1>
          </div>

          <div class="site-footer__col-two-three-group">
            <div class="site-footer__col-two">
              <h3 class="headline headline--small">Explore</h3>
              <nav class="nav-list">
            <!--
            <?php 
                wp_nav_menu(array(
                'theme_location' => 'footerLocationOne'
                ));
            ?>
            -->
             
                <ul>
                  <li><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
                  <li><a href="<?php echo site_url('/blog') ?>">Blog</a></li>
                  <li><a href="<?php echo site_url('/handhelds') ?>">Handhelds</a></li>
                </ul>
              
              </nav>
            </div>

            <div class="site-footer__col-three">
              <h3 class="headline headline--small">Links</h3>
              <nav class="nav-list">
          
                <ul>
                  <li><a href="https://retrogamecorps.com/">Retro Game Corps</a></li>
                  <li><a href="https://retrododo.com/">Retro DoDo</a></li>
                  <li><a href="https://www.reddit.com/r/SBCGaming/">SBCGaming</a></li>
                </ul>
                
              </nav>
            </div>
          </div>

          <div class="site-footer__col-four">
            <h3 class="headline headline--small">Connect With Us</h3>
            <nav>
              <ul class="min-list social-icons-list group">
                <li>
                  <a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="https://github.com/wenhao-lu" class="social-color-youtube"><i class="fa fa-github" aria-hidden="true"></i></a>
                </li>
                <li>
                  <a href="https://www.linkedin.com/in/wenhao-kevin-l-6290b2145/" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </footer>


    <?php wp_footer();  ?>
</body>
</html>