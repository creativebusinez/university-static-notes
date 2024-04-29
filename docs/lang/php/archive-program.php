<?php get_header(); ?>

    <!-- Creating a section for page banner -->
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <!-- Displaying the title of the page -->
            <h1 class="page-banner__title">All Programs</h1>
            <div class="page-banner__intro">
                <p>Find our list of all our programs</p>
            </div>
        </div>
    </div>

    <!-- Section for content -->
    <div class="container container--narrow page-section">
        <ul class="min-list link-list">
        <?php
            while(have_posts()) {
                the_post(); ?>
                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php
                } // end while loop
        // add pagination
        echo paginate_links();
        ?>
        </ul>
    </div>

<?php get_footer(); ?>