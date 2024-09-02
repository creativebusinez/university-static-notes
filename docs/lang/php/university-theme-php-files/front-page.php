<?php get_header(); ?>
<!-- Include the header template for the page. -->

<div class="page-banner">
  <!-- Start of the page banner section. -->
  
  <div class="page-banner__bg-image" style="background-image: url(<?php echo esc_url(get_theme_file_uri('/images/library-hero.jpg')); ?>);">
  </div>
  <!-- Set the background image for the page banner. -->

  <div class="page-banner__content container t-center c-white">
    <!-- Container for the banner content, centered and with white text. -->
    
    <h1 class="headline headline--large">Welcome!</h1>
    <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
    <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
    <a href="<?php echo esc_url(get_post_type_archive_link('program')); ?>" class="btn btn--large btn--blue">Find Your Major</a>
    <!-- Link to the program archive page. -->
  </div>
</div>
<!-- End of the page banner section. -->

<div class="full-width-split group">
  <!-- Start of the full-width split section. -->

  <div class="full-width-split__one">
    <div class="full-width-split__inner">
      <!-- Container for the first split section. -->

      <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>

      <?php 
        $today = date('Ymd');
        // Custom query to fetch upcoming events.
        $homepageEvents = new WP_Query(array(
          'posts_per_page' => 2,
          'post_type' => 'event',
          'meta_key' => 'event_date',
          'orderby' => 'meta_value_num',
          'order' => 'ASC',
          'meta_query' => array(
            array(
              'key' => 'event_date',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric'
            )
          )
        ));

        while ($homepageEvents->have_posts()) {
          $homepageEvents->the_post();
          get_template_part('template-parts/content', 'event');
          // Load the template part for displaying event content.
        }
      ?>
      
      <p class="t-center no-margin">
        <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>" class="btn btn--blue">View All Events</a>
        <!-- Link to the events archive page. -->
      </p>

    </div>
  </div>

  <div class="full-width-split__two">
    <div class="full-width-split__inner">
      <!-- Container for the second split section. -->

      <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>

      <?php
        // Custom query to fetch recent blog posts.
        $homepagePosts = new WP_Query(array(
          'posts_per_page' => 2
        ));

        while ($homepagePosts->have_posts()) {
          $homepagePosts->the_post(); ?>
          <div class="event-summary">
            <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
              <span class="event-summary__month"><?php the_time('M'); ?></span>
              <span class="event-summary__day"><?php the_time('d'); ?></span>  
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <p><?php if (has_excerpt()) {
                  echo get_the_excerpt();
                } else {
                  echo wp_trim_words(get_the_content(), 18);
                } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
            </div>
          </div>
        <?php } wp_reset_postdata();
      ?> 

      <p class="t-center no-margin">
        <a href="<?php echo esc_url(site_url('/blog')); ?>" class="btn btn--yellow">View All Blog Posts</a>
        <!-- Link to the blog archive page. -->
      </p>

    </div>
  </div>
</div>
<!-- End of the full-width split section. -->

<div class="hero-slider">
  <!-- Start of the hero slider section. -->
  
  <div data-glide-el="track" class="glide__track">
    <!-- Slider track container. -->
    
    <div class="glide__slides">
      <!-- Start of the slide items container. -->

      <div class="hero-slider__slide" style="background-image: url(<?php echo esc_url(get_theme_file_uri('/images/bus.jpg')); ?>);">
        <!-- Slide 1 with background image. -->
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Transportation</h2>
            <p class="t-center">All students have free unlimited bus fare.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>

      <div class="hero-slider__slide" style="background-image: url(<?php echo esc_url(get_theme_file_uri('/images/apples.jpg')); ?>);">
        <!-- Slide 2 with background image. -->
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">An Apple a Day</h2>
            <p class="t-center">Our dentistry program recommends eating apples.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>

      <div class="hero-slider__slide" style="background-image: url(<?php echo esc_url(get_theme_file_uri('/images/bread.jpg')); ?>);">
        <!-- Slide 3 with background image. -->
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Food</h2>
            <p class="t-center">Fictional University offers lunch plans for those in need.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>

    </div>
    <!-- End of the slide items container. -->
    
    <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]">
      <!-- Navigation bullets for the slider. -->
    </div>
  </div>
</div>
<!-- End of the hero slider section. -->

<?php get_footer(); ?>
<!-- Include the footer template for the page. -->
