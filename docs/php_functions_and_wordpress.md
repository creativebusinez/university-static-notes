# PHP Functions and WordPress

Creating a WordPress website involves leveraging a variety of PHP functions to enhance functionality, theme customization, and content management. Below is a list of commonly used PHP functions in WordPress development, grouped by functionality for better understanding:

## Theme [Setup](/docs/creating_a_new_theme.md) and Customization

- **`add_theme_support()`**: Enables features like post thumbnails, custom headers, and HTML5 support.
- **`add_image_size()`**: Defines new image sizes for post thumbnails.
- **`register_nav_menus()`**: Registers multiple navigation menu locations.
- **`register_sidebar()`**: Registers a sidebar for widgets.
- **`get_theme_file_uri()`**: Retrieves the URL of a theme file.[see usage](/docs/lang/php/index.php)[see usage](/docs/lang/php/functions.php)
- **`get_template_directory_uri()`**: Retrieves the URL of the theme directory.
- **`wp_enqueue_style()`**: Safely adds CSS stylesheets. [see usage](/docs/lang/php/functions.php)
- **`wp_enqueue_script()`**: Safely adds JavaScript files [see usage](/docs/lang/php/functions.php).

### Content Retrieval and Display

- **`have_posts()`**: Checks if there are posts to loop over.
- **`the_post()`**: Iterates the post index in The Loop.
- **`get_post_meta()`**: Retrieves a post's meta value for a specified key.
- **`wp_get_attachment_image()`**: Retrieves an image to represent an attachment.
- **`the_content()`**: Displays post content.
- **`get_the_excerpt()`**: Retrieves the post excerpt.
- **`the_permalink()`**: Displays the URL of the post or page.[see usage](/docs/lang/php/page.php)
- **`site_url()`**: Retrieves the URL of the site.
- **`get_the_ID()`**: Retrieves the ID of the current post.
- **`wp_get_post_parent_id()`**: Retrieves the ID of the parent post. [see usage](/docs/lang/php/page.php)
- **`wp_list_pages()`**: Displays a list of pages.

### User and Authentication

- **`is_user_logged_in()`**: Checks if the user is logged in.
- **`wp_login_url()`**: Retrieves the login URL.
- **`wp_logout_url()`**: Retrieves the logout URL.
- **`current_user_can()`**: Checks if the current user has a specific capability.

### Miscellaneous

- **`wp_redirect()`**: Redirects to another page.
- **`add_action()`**: Hooks a function to a specific action.
- **`add_filter()`**: Hooks a function to a specific filter.
- **`shortcode_atts()`**: Combines user shortcode attributes with known attributes and fills in defaults when needed.
- **`wp_localize_script()`**: Localizes a script with PHP variables, useful for passing PHP data into JavaScript.

### Database and Queries

- **`wp_insert_post()`**: Inserts a post into the database.
- **`wp_update_post()`**: Updates a post with new data.
- **`wp_delete_post()`**: Deletes a post from the database.
- **`get_posts()`**: Retrieves a list of posts based on given criteria.
- **`WP_Query`**: Allows developers to query WordPress database and retrieve posts as specified.

### Widgets and Menus

- **`register_widget()`**: Registers a widget.
- **`wp_nav_menu()`**: Displays a navigation menu.
- **`dynamic_sidebar()`**: Displays a sidebar if it contains widgets.

### Hooks and Filters

- **`add_action()`**: Adds a function to a specific action hook. [see usage](/docs/lang/php/functions.php)
- **`add_filter()`**: Adds a function to a specific filter hook.
- **`remove_action()`**: Removes a function from a specific action hook.
- **`remove_filter()`**: Removes a function from a specific filter hook.

These functions are crucial for WordPress theme and plugin development, allowing developers to customize and enhance WordPress sites effectively. Each function serves a specific purpose, from setting up the theme environment and customizing features to handling content, users, and database interactions. Understanding and utilizing these functions efficiently can significantly impact the functionality and performance of WordPress websites.
