<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <!-- The HTML language attribute is dynamically set according to the site's language. -->

  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <!-- The character encoding is set to the site's default, typically UTF-8. -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ensures proper scaling of the site on mobile devices. -->
    
    <?php wp_head(); ?>
    <!-- WordPress hook for loading additional elements in the head, such as scripts and styles. -->
  </head>

  <body <?php body_class(); ?>>
    <!-- Dynamically adds classes to the body tag, depending on the page being viewed. -->

    <header class="site-header">
      <!-- Start of the site header. -->

      <div class="container">
        <!-- Container for header content. -->

        <h1 class="school-logo-text float-left">
          <a href="<?php echo esc_url(site_url()); ?>">
            <strong>Fictional</strong> University
          </a>
        </h1>
        <!-- Site logo with a link to the homepage. -->

        <a href="<?php echo esc_url(site_url('/search')); ?>" class="js-search-trigger site-header__search-trigger">
          <i class="fa fa-search" aria-hidden="true"></i>
        </a>
        <!-- Search icon link to the search page with JavaScript trigger class. -->

        <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
        <!-- Mobile menu trigger icon. -->

        <div class="site-header__menu group">
          <!-- Navigation menu container. -->

          <nav class="main-navigation">
            <!-- Main site navigation. -->

            <ul>
              <!-- Navigation menu list. -->

              <li <?php if (is_page('about-us') || wp_get_post_parent_id(0) == 16) echo 'class="current-menu-item"'; ?>>
                <a href="<?php echo esc_url(site_url('/about-us')); ?>">About Us</a>
              </li>
              <!-- Highlight "About Us" menu item if on the 'about-us' page or a child page. -->

              <li <?php if (get_post_type() == 'program') echo 'class="current-menu-item"'; ?>>
                <a href="<?php echo esc_url(get_post_type_archive_link('program')); ?>">Programs</a>
              </li>
              <!-- Highlight "Programs" menu item if viewing a program post type. -->

              <li <?php if (get_post_type() == 'event' || is_page('past-events')) echo 'class="current-menu-item"'; ?>>
                <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>">Events</a>
              </li>
              <!-- Highlight "Events" menu item if viewing an event post type or the past events page. -->

              <li <?php if (get_post_type() == 'campus') echo 'class="current-menu-item"'; ?>>
                <a href="<?php echo esc_url(get_post_type_archive_link('campus')); ?>">Campuses</a>
              </li>
              <!-- Highlight "Campuses" menu item if viewing a campus post type. -->

              <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"'; ?>>
                <a href="<?php echo esc_url(site_url('/blog')); ?>">Blog</a>
              </li>
              <!-- Highlight "Blog" menu item if viewing a blog post. -->

            </ul>
            <!-- End of navigation menu list. -->
          </nav>
          <!-- End of main site navigation. -->

          <div class="site-header__util">
            <!-- Utility navigation section, typically for user actions like login/logout. -->

            <?php if (is_user_logged_in()) { ?>
              <!-- If the user is logged in, show "My Notes" and "Log Out" options. -->

              <a href="<?php echo esc_url(site_url('/my-notes')); ?>" class="btn btn--small btn--orange float-left push-right">My Notes</a>
              <a href="<?php echo esc_url(wp_logout_url()); ?>" class="btn btn--small btn--dark-orange float-left btn--with-photo">
                <span class="site-header__avatar">
                  <?php echo get_avatar(get_current_user_id(), 60); ?>
                </span>
                <!-- Display the user's avatar. -->
                <span class="btn__text">Log Out</span>
              </a>

            <?php } else { ?>
              <!-- If the user is not logged in, show "Login" and "Sign Up" options. -->

              <a href="<?php echo esc_url(wp_login_url()); ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
              <a href="<?php echo esc_url(wp_registration_url()); ?>" class="btn btn--small btn--dark-orange float-left">Sign Up</a>

            <?php } ?>
            
            <a href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger">
              <i class="fa fa-search" aria-hidden="true"></i>
            </a>
            <!-- Another search icon for triggering search functionality. -->

          </div>
          <!-- End of utility navigation section. -->

        </div>
        <!-- End of navigation menu container. -->

      </div>
      <!-- End of header container. -->

    </header>
    <!-- End of site header. -->
