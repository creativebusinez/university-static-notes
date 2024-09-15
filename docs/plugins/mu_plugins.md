# Must Use Plugins Folder

This `mu_plugins` folder contains the plugins that are used in the theme. It must be created in your site's C:\Local Sites\YourSite\app\public\wp-content folder.

The "Must Use" plugins folder in WordPress, commonly referred to as the `mu-plugins` directory, is a special location within the WordPress file structure designed for storing plugins that you want to be automatically activated and cannot be disabled through the WordPress admin dashboard. This feature provides a powerful way to ensure essential functionality is always active and available across the site, regardless of changes to themes or other plugins.

## Key Characteristics of MU-Plugins

1. **Auto-Activation**: Plugins placed in the `mu-plugins` directory are automatically activated by WordPress. There's no need to manually activate them through the admin interface.

2. **Hidden from the Plugins Menu**: MU-plugins do not appear in the WordPress admin's Plugins menu. Therefore, they cannot be deactivated from the WordPress dashboard.

3. **Ideal for Critical Functionality**: This feature is particularly useful for functionality that must remain active, such as customizations critical to a site's operation, security enhancements, or network-wide features on a multisite installation.

### How to Use MU-Plugins

1. **Location**: The `mu-plugins` folder is located in `wp-content/mu-plugins`. If it doesn’t exist, you can manually create it.

2. **Installation**: Simply drop your plugin files (or directories) into the `mu-plugins` folder. Note that unlike regular plugins, MU-plugins loaded directly from this directory must be single PHP files. If your MU-plugin is structured as a directory with an initializer file, you will need to manually include it from a single PHP file placed directly in the `mu-plugins` directory.

3. **Loading Subdirectories**: If your MU-plugin includes multiple files organized in a subdirectory, you need to create a PHP loader file in the `mu-plugins` root that includes or requires the necessary files from the subdirectory.

### Example of a Loader File

```php
<?php
// my-mu-plugin-loader.php in wp-content/mu-plugins

require WPMU_PLUGIN_DIR.'/my-mu-plugin/my-mu-plugin.php';
```

This loader file ensures that `my-mu-plugin.php` (which resides in a subdirectory) is executed.

### Considerations

- **Updates**: MU-plugins do not automatically receive updates like standard WordPress plugins from the WordPress repository. Updates must be managed manually.

- **Use Sparingly**: Given their auto-activation and invisibility in the admin dashboard, use MU-plugins only for essential functionality to minimize the risk of conflicts and ensure easy site management.

- **Compatibility**: Because MU-plugins are loaded before regular plugins, ensure any dependencies your MU-plugins might have on other plugins are carefully managed.

The `mu-plugins` directory offers a robust solution for ensuring critical functionality remains uninterrupted on a WordPress site, making it a valuable tool for developers and site administrators who need to enforce certain features or customizations.

## /app/public/wp-content/mu-plugins/university-post-types.php

This file is used to add [custom post types](/docs/md/custom_post_types.md) to the site. See also [ACF custom fields](/docs/md/custom_fields.md) plugin.

```php /* Location: app/public/wp-content/mu-plugins/university-post-types.php */
<?php

function university_post_types() {
  // Campus Post Type
  register_post_type('campus', array(// Define post type
    'capability_type' => 'campus',// Enable custom fields
    'map_meta_cap' => true,// Enable meta capabilities
    'show_in_rest' => true,// REST API support
    'supports' => array('title', 'editor', 'excerpt'),// Custom fields
    'rewrite' => array('slug' => 'campuses'),// Custom rewrite rules
    'has_archive' => true,// Archive page
    'public' => true,// Publicly queryable
    'labels' => array(// Custom labels
      'name' => 'Campuses',// Name as it appears in the admin
      'add_new_item' => 'Add New Campus',// Add new item
      'edit_item' => 'Edit Campus',// Edit item
      'all_items' => 'All Campuses',// All items
      'singular_name' => 'Campus'// Singular name
    ),
    'menu_icon' => 'dashicons-location-alt' // Menu icon
  ));

  // Event Post Type/Section 7
  register_post_type('event', array(
    'capability_type' => 'event',
    'map_meta_cap' => true,
    'show_in_rest' => true,
    'supports' => array('title', 'editor', 'excerpt'),
    'rewrite' => array('slug' => 'events'),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => 'Events',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'all_items' => 'All Events',
      'singular_name' => 'Event'
    ),
    'menu_icon' => 'dashicons-calendar'
  ));

  // Program Post Type/Section 8
  register_post_type('program', array(
    'show_in_rest' => true,
    'supports' => array('title'),
    'rewrite' => array('slug' => 'programs'),
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => 'Programs',
      'add_new_item' => 'Add New Program',
      'edit_item' => 'Edit Program',
      'all_items' => 'All Programs',
      'singular_name' => 'Program'
    ),
    'menu_icon' => 'dashicons-awards'
  ));

  // Professor Post Type/Section 9
  register_post_type('professor', array(
    'show_in_rest' => true,
    'supports' => array('title', 'editor', 'thumbnail'),
    'public' => true,
    'labels' => array(
      'name' => 'Professors',
      'add_new_item' => 'Add New Professor',
      'edit_item' => 'Edit Professor',
      'all_items' => 'All Professors',
      'singular_name' => 'Professor'
    ),
    'menu_icon' => 'dashicons-welcome-learn-more'
  ));

  // Note Post Type
  register_post_type('note', array(
    'capability_type' => 'note',
    'map_meta_cap' => true,
    'show_in_rest' => true,
    'supports' => array('title', 'editor'),
    'public' => false,
    'show_ui' => true,
    'labels' => array(
      'name' => 'Notes',
      'add_new_item' => 'Add New Note',
      'edit_item' => 'Edit Note',
      'all_items' => 'All Notes',
      'singular_name' => 'Note'
    ),
    'menu_icon' => 'dashicons-welcome-write-blog'
  ));

  // Like Post Type
  register_post_type('like', array(
    'supports' => array('title'),
    'public' => false,
    'show_ui' => true,
    'labels' => array(
      'name' => 'Likes',
      'add_new_item' => 'Add New Like',
      'edit_item' => 'Edit Like',
      'all_items' => 'All Likes',
      'singular_name' => 'Like'
    ),
    'menu_icon' => 'dashicons-heart'
  ));
}

add_action('init', 'university_post_types');// Initialize

```
