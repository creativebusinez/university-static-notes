<?php
                // Create a new WP_Query object. WP_Query is a class that allows querying WordPress database for posts.
                $homepagePosts = new WP_Query(array(
                    // Specify the number of posts per page. Here it's set to 2.
                    'posts_per_page' => 2
                ));

                // Start the while loop that will run if there are any posts matching the query conditions.
                while ($homepagePosts->have_posts()) {
                    // Set up post data. Prepares global post variable with the next post from the query.
                    $homepagePosts->the_post(); 
                    ?>
                    <!-- Printing out the post title within list item tags. `the_title()` function displays the title of the post. -->
                    <li><?php the_title(); ?></li>
                    <?php
                }
            ?>

<!-- This snippet is useful when you want to display a brief preview of your latest content on a home or landing page. -->