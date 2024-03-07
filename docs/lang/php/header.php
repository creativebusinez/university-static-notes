<!DOCTYPE html>
<html <?php language_attributes(); // Output language attributes for the html tag ?>>
<head>
  <meta charset="<?php bloginfo('charset'); // Output the character encoding ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <?php wp_head(); // Hook to include extra functionalities in the head section ?>
</head>
<body <?php body_class(); // Outputs classes for the body tag ?>>
  <header class="site-header">
    <div class="container">
      <h1 class="school-logo-text float-left">
        <a href="<?php echo site_url('/fictional-university.local'); // Link to fictional university site ?>"><strong>Fictional</strong> University</a>
      </h1>
      <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
      <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
      <div class="site-header__menu group">

        <nav class="main-navigation">
          <!-- Dynamic Menu for Custom Themes -->
          <!--
          <?php
            wp_nav_menu(array(
              'theme_location' => 'headerMenuLocation', // This menu is located in the header
            ));
          ?> 
          -->
          <!-- Simple Static Menu -->
          <ul>
            <li <?php if (is_page('about-us') or wp_get_post_parent_id(0) == 14) echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/about-us'); ?>">About Us</a></li>
            <!-- More menu items -->
            <li><a href="#">Programs</a></li>
            <li><a href="#">Events</a></li>
            <li><a href="#">Campuses</a></li>
            <li><a href="#">Blog</a></li>
          </ul>
        </nav>

        <div class="site-header__util">
          <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a> <!-- Button for login -->
          <a href="#" class="btn btn--small btn--dark-orange float-left">Sign Up</a> <!-- Button for sign up -->
          <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span> <!-- Search icon -->
        </div>
      </div>
    </div>
  </header>
