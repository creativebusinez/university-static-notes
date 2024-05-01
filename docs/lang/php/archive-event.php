<?php
    get_header();
    pageBanner(
        [
            'title' => 'All Events',
            'subtitle' => 'See what is going on in our world.'
        ]
    )
?>
    <!-- Section for content -->
    <div class="container container--narrow page-section">
        <?php
            while(have_posts()) {
                the_post();
                get_template_part('template-parts/content-event');
            } // end while loop
        // add pagination
        echo paginate_links();
        ?>
        <p>Past events <a href="<?php echo site_url('/past-events') ?>">archive</a></p>
    </div>

<?php get_footer(); ?>