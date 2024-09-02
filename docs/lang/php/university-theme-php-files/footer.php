<footer class="site-footer">
  <!-- Start of the footer section of the site. -->

  <div class="site-footer__inner container container--narrow">
    <!-- Container for the inner content of the footer, with narrow width. -->

    <div class="group">
      <!-- Start of the group for footer columns. -->

      <div class="site-footer__col-one">
        <!-- First column: site logo and contact information. -->
        <h1 class="school-logo-text school-logo-text--alt-color">
          <a href="<?php echo esc_url(site_url()); ?>">
            <strong>Fictional</strong> University
          </a>
        </h1>
        <p><a class="site-footer__link" href="#">555.555.5555</a></p>
        <!-- Display the phone number as a clickable link. -->
      </div>

      <div class="site-footer__col-two-three-group">
        <!-- Group for the second and third columns. -->

        <div class="site-footer__col-two">
          <!-- Second column: "Explore" navigation. -->
          <h3 class="headline headline--small">Explore</h3>
          <nav class="nav-list">
            <ul>
              <li><a href="<?php echo esc_url(site_url('/about-us')); ?>">About Us</a></li>
              <li><a href="#">Programs</a></li>
              <li><a href="#">Events</a></li>
              <li><a href="#">Campuses</a></li>
            </ul>
          </nav>
        </div>

        <div class="site-footer__col-three">
          <!-- Third column: "Learn" navigation. -->
          <h3 class="headline headline--small">Learn</h3>
          <nav class="nav-list">
            <ul>
              <li><a href="#">Legal</a></li>
              <li><a href="<?php echo esc_url(site_url('/privacy-policy')); ?>">Privacy</a></li>
              <li><a href="#">Careers</a></li>
            </ul>
          </nav>
        </div>
      </div>

      <div class="site-footer__col-four">
        <!-- Fourth column: Social media links. -->
        <h3 class="headline headline--small">Connect With Us</h3>
        <nav>
          <ul class="min-list social-icons-list group">
            <li><a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <!-- Social media icons with respective links and styles. -->
          </ul>
        </nav>
      </div>
    </div>
    <!-- End of the group for footer columns. -->

  </div>
  <!-- End of the inner footer container. -->
</footer>
<!-- End of the footer section. -->

<?php wp_footer(); ?>
<!-- WordPress function to include necessary footer scripts. -->
</body>
</html>
