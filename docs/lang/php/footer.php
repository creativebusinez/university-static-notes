<footer class="site-footer">
  <div class="site-footer__inner container container--narrow">
    <div class="group">
      <div class="site-footer__col-one">
        <!-- School Logo -->
        <h1 class="school-logo-text school-logo-text--alt-color">
          <a href="<?php echo site_url(); ?>"><strong>Fictional</strong> University</a>
        </h1>
        <!-- Phone number -->
        <p><a class="site-footer__link" href="#">555.555.5555</a></p>
      </div>

      <div class="site-footer__col-two-three-group">
        <div class="site-footer__col-two">

          <!-- Explore Links -->
          <h3 class="headline headline--small">Explore</h3>
          <nav class="nav-list">
            <!-- Dynamic Menu for Custom Themes -->
            <!-- <?php
              wp_nav_menu(array(
                'theme_location' => 'footerLocationOne', // name of the registered location
              ));
            ?> -->
            <!-- Simple Static Hardcoded Menu -->
            <ul>
              <li><a href="<?php echo site_url('/about-us'); ?>">About Us</a></li>
              <li><a href="#">Programs</a></li>
              <li><a href="#">Events</a></li>
              <li><a href="#">Campuses</a></li>
            </ul>
          </nav>
        </div>

        <div class="site-footer__col-three">
          <!-- Learn Links -->
          <h3 class="headline headline--small">Learn</h3>
          <nav class="nav-list">

            <!-- Dynamic Menu for Custom Themes -->
            <!-- <?php
              wp_nav_menu(array(
                'theme_location' => 'footerLocationTwo' // name of the registered location
              ));
            ?> -->
            <!-- Simple Static Hardcoded Menu -->
            <ul>
              <li><a href="#">Legal</a></li>
              <li><a href="<?php echo site_url('/privacy-policy'); ?>">Privacy</a></li>
              <li><a href="#">Careers</a></li>
            </ul>
          </nav>
        </div>
      </div>

      <div class="site-footer__col-four">
        <!-- Social Media Links -->
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
              <a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a>
            </li>
            <li>
              <a href="#" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
            </li>
            <li>
              <a href="#" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</footer>

<!-- WordPress Footer Function -->
<?php wp_footer(); ?> 

</body>
</html>

</body>
</html>
