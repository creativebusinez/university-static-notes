<?php

// Redirect to the homepage if the user is not logged in.
if (!is_user_logged_in()) {
  wp_redirect(esc_url(site_url('/')));
  exit;
}

get_header();
// Include the header template for the page.

while (have_posts()) {
  the_post();
  pageBanner();
  // Display the page banner.
  ?>
  
  <div class="container container--narrow page-section">
    <!-- Start of the container for the page content. -->

    <div class="create-note">
      <!-- Section for creating a new note. -->

      <h2 class="headline headline--medium">Create New Note</h2>
      <input class="new-note-title" placeholder="Title">
      <!-- Input field for the new note title. -->

      <textarea class="new-note-body" placeholder="Your note here..."></textarea>
      <!-- Text area for the new note content. -->

      <span class="submit-note">Create Note</span>
      <!-- Button for submitting the new note. -->

      <span class="note-limit-message">Note limit reached: delete an existing note to make room for a new one.</span>
      <!-- Message displayed when the note limit is reached. -->
    </div>

    <ul class="min-list link-list" id="my-notes">
      <!-- Start of the list of existing notes. -->

      <?php 
      // Query to fetch all notes created by the current user.
      $userNotes = new WP_Query(array(
        'post_type' => 'note',
        'posts_per_page' => -1,
        'author' => get_current_user_id()
      ));

      while ($userNotes->have_posts()) {
        $userNotes->the_post(); ?>
        
        <li data-id="<?php the_ID(); ?>">
          <!-- Each note is displayed in a list item with its ID as a data attribute. -->

          <input readonly class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())); ?>">
          <!-- Input field for the note title, stripped of "Private: " and set to read-only. -->

          <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
          <!-- Button for editing the note. -->

          <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
          <!-- Button for deleting the note. -->

          <textarea readonly class="note-body-field"><?php echo esc_textarea(get_the_content()); ?></textarea>
          <!-- Text area for the note content, set to read-only. -->

          <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
          <!-- Button for saving the updated note. -->
        </li>

      <?php }
      // End of the notes loop.
      ?>
    </ul>
    <!-- End of the list of existing notes. -->

  </div>
  <!-- End of the container for the page content. -->

<?php }

get_footer();
// Include the footer template for the page.

?>
