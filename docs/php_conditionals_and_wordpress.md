# PHP Conditionals and WordPress

In WordPress development, conditional tags often work alongside various prefixes in if statements to create dynamic and flexible themes or plugins. These conditional tags allow developers to execute code based on specific conditions or contexts within a WordPress site. Here are some commonly used prefixes in combination with if statements in WordPress:

## `is_` Prefix with If Statements

- **`is_home()`**: Checks if the main blog page is being displayed.

  ```php
  if ( is_home() ) {
      // Code specific to the blog home page
  }
  ```

- **`is_front_page()`**: Determines if the front page of the site is being displayed.

  ```php
  if ( is_front_page() ) {
      // Code for the site's front page
  }
  ```

- **`is_single()`**: Checks if a single post of any post type (except attachment and page post types) is being displayed.

  ```php
  if ( is_single() ) {
      // Code for any single post
  }
  ```

- **`is_page()`**: Determines if a page is being displayed. [see usage in line 29](/docs/lang/php/header.php)

  ```php
  if ( is_page() ) {
      // Code for any page
  }
  ```

- **`is_archive()`**: Checks if any archive page is being displayed.

  ```php
  if ( is_archive() ) {
      // Code for any archive page
  }
  ```

- **`is_category()`**: Determines if a category archive page is being displayed.

  ```php
  if ( is_category() ) {
      // Code for category archive pages
  }
  ```

- **`is_tag()`**: Checks if a tag archive page is being displayed.

  ```php
  if ( is_tag() ) {
      // Code for tag archive pages
  }
  ```

- **`is_author()`**: Determines if an author archive page is being displayed.

  ```php
  if ( is_author() ) {
      // Code for author archive pages
  }
  ```

- **`is_search()`**: Checks if search results are being displayed.

  ```php
  if ( is_search() ) {
      // Code for search results page
  }
  ```

- **`is_404()`**: Determines if the 404 error page is being displayed.

  ```php
  if ( is_404() ) {
      // Code for 404 error page
  }
  ```

- **`is_admin()`**: Checks if the dashboard or the administration panel is being displayed. Note that this is not a conditional tag but a function used to determine if the code is running in the WordPress admin area.

  ```php
  if ( is_admin() ) {
      // Code that should only run in the admin area
  }
  ```

## `has_` Prefix with If Statements

- **`has_post_thumbnail()`**: Checks if the current post has a post thumbnail (featured image).

  ```php
  if ( has_post_thumbnail() ) {
      // Code to display the post thumbnail
  }
  ```

- **`has_nav_menu()`**: Determines if a theme has a menu assigned to the specified location.

  ```php
  if ( has_nav_menu( 'primary' ) ) {
      // Code to display the primary menu
  }
  ```

- **`has_excerpt()`**: Checks if the post has an excerpt.

  ```php
  if ( has_excerpt() ) {
      // Code to display the excerpt
  }
  ```

- **`has_term()`**: Checks if the current post has any of given terms.

  ```php
  if ( has_term( 'term-slug', 'taxonomy' ) ) {
      // Code for posts with a specific term
  }
  ```

- **`has_shortcode()`**: Determines if the current post/page content contains a specific shortcode.

  ```php
  if ( has_shortcode( get_the_content(), 'my_shortcode' ) ) {
      // Code to do something if a specific shortcode is present in the post/page content
  }
  ```

## `in_` Prefix with If Statements (Less Common)

- **`in_category()`**: Checks if the current post is in a specified category.

  ```php
  if ( in_category( 'news' ) ) {
      // Code specific to posts in the "news" category
  }
  ```

- **`in_array()`**: Though not specific to WordPress, `in_array()` is often used to check if a certain value exists in an array, which can be useful in various WordPress contexts.

  ```php
  $supported_post_types = array( 'post', 'page', 'custom_post_type' );
  if ( in_array( get_post_type(), $supported_post_types ) ) {
      // Code for specific post types
  }
  ```

These conditional tags, when combined with if statements, are powerful tools for creating dynamic and context-sensitive behaviors in WordPress themes and plugins. They allow developers to tailor the content, layout, and functionality to different parts of a WordPress site efficiently.

### Combining Multiple Conditions

You can also combine multiple conditional tags to create more complex logic for very specific scenarios.

- **Combining `is_` and `has_` conditions**:

  ```php
  if ( is_singular('post') && has_post_thumbnail() ) {
      // Code for single posts that have a post thumbnail
  }
  ```

- **Using `&&` (AND) and `||` (OR) logical operators**:

  ```php
  if ( is_singular('post') || is_singular('page') ) {
      // Code for both single posts and pages
  }

  if ( is_home() && !is_paged() ) {
      // Code specific to the first page of the blog posts index
  }
  ```

These additional conditional tags and the examples of combining them demonstrate the flexibility WordPress offers for tailoring content and functionality. By understanding and utilizing these conditions effectively, developers can significantly enhance the user experience and site's dynamic capabilities.

#### List of Conditional Tags

Here's a list of commonly used conditional tags in WordPress for creating dynamic content and logic:

1. `is_home()`
2. `is_front_page()`
3. `is_single()`
4. `is_page()`
5. `is_archive()`
6. `is_category()`
7. `is_tag()`
8. `is_tax()`
9. `is_author()`
10. `is_date()`
11. `is_year()`
12. `is_month()`
13. `is_day()`
14. `is_time()`
15. `is_search()`
16. `is_404()`
17. `is_paged()`
18. `is_admin()`
19. `is_attachment()`
20. `is_singular()`
21. `is_feed()`
22. `is_post_type_archive()`
23. `has_post_thumbnail()`
24. `has_excerpt()`
25. `has_nav_menu()`
26. `in_category()`
27. `has_term()`
28. `has_shortcode()`
