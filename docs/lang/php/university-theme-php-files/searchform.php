<form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); ?>">
  <!-- Search form that sends a GET request to the site’s home URL. -->

  <label class="headline headline--medium" for="s">Perform a New Search:</label>
  <!-- Label for the search input field with a medium-sized headline style. -->

  <div class="search-form-row">
    <!-- Container for the search input and submit button. -->

    <input placeholder="What are you looking for?" class="s" id="s" type="search" name="s">
    <!-- Input field for the search query with a placeholder text. -->

    <input class="search-submit" type="submit" value="Search">
    <!-- Submit button for the search form with the label "Search". -->
  </div>
  <!-- End of the container for the search input and submit button. -->
</form>
<!-- End of the search form. -->
