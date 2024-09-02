<div class="post-item">
  <!-- Container for a single post item. -->

  <h2 class="headline headline--medium headline--post-title">
    <a href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
      <!-- Display the title of the post as a link to the post's permalink. -->
    </a>
  </h2>

  <div class="metabox">
    <!-- Metabox containing post metadata such as author, date, and categories. -->

    <p>
      Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?>
      <!-- Display the author, date, and categories of the post. -->
    </p>
  </div>

  <div class="generic-content">
    <!-- Container for the post's excerpt and link. -->

    <?php the_excerpt(); ?>
    <!-- Display the excerpt of the post. -->

    <p>
      <a class="btn btn--blue" href="<?php the_permalink(); ?>">
        Continue reading &raquo;
        <!-- Button linking to the full post with the label "Continue reading". -->
      </a>
    </p>
  </div>

</div>
