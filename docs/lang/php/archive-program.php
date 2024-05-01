<?php
    get_header();
    pageBanner(
        [
            'title' => 'All Programs',
            'subtitle' => 'See our list of programs'
        ]
    );
?>

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