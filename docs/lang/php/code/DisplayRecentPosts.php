<?php
                // Create a new WP_Query object. WP_Query is a class that allows querying WordPress database for posts.
                $homepagePosts = new WP_Query(array(
                    // Specify the number of posts per page. Here it's set to 2.
                    'posts_per_page' => 2
                ));

                // Start the while loop that will run if there are any posts matching the query conditions.
                while ($homepagePosts->have_posts()) {
                    // Set up post data. Prepares global post variable with the next post from the query.
                    $homepagePosts->the_post(); ?>
                    <!-- Printing out the post title within list item tags. `the_title()` function displays the title of the post. -->
                    <div class="event-summary">
                        <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink() ?>">
                        <span class="event-summary__month"><?php the_time('M') ?></span>
                        <span class="event-summary__day"><?php the_time('d') ?></span>
                        </a>
                    <div class="event-summary__content">
                        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink() ?>""><?php the_title() ?></a></h5>
                        <p><?php echo wp_trim_words(get_the_content(), 18) ?> <a href="<?php the_permalink() ?>" class="nu gray">Read more</a></p>
                    </div>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            ?>

<!-- This snippet is useful when you want to display a brief preview of your latest content on a home or landing page. -->