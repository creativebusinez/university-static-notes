# WordPress Custom Post Types Explained

WordPress Custom Post Types (CPTs) are a powerful feature that allows you to extend the default content types in WordPress beyond posts and pages. By creating CPTs, you can structure and manage different types of content in a more organized and meaningful way. This enables you to tailor WordPress to fit the specific needs of your website, whether it's a portfolio site, an e-commerce store, a real estate listing platform, or any other specialized site.

---

## Table of Contents

- [WordPress Custom Post Types Explained](#wordpress-custom-post-types-explained)
  - [Table of Contents](#table-of-contents)
  - [What Are Custom Post Types?](#what-are-custom-post-types)
  - [Why Use Custom Post Types?](#why-use-custom-post-types)
  - [Creating Custom Post Types](#creating-custom-post-types)
    - [Using Code in `functions.php`](#using-code-in-functionsphp)
    - [Using Plugins](#using-plugins)
    - [Using an MU-Plugin in `/wp-content/mu-plugins/`](#using-an-mu-plugin-in-wp-contentmu-plugins)
      - [**Why Use MU-Plugins for Custom Post Types?**](#why-use-mu-plugins-for-custom-post-types)
      - [**Steps to Create an MU-Plugin for Custom Post Types**](#steps-to-create-an-mu-plugin-for-custom-post-types)
        - [**Step 1: Create the `mu-plugins` Directory**](#step-1-create-the-mu-plugins-directory)
        - [**Step 2: Create the MU-Plugin File**](#step-2-create-the-mu-plugin-file)
        - [**Step 3: Add the Plugin Header**](#step-3-add-the-plugin-header)
        - [**Step 4: Add the Custom Post Type Code**](#step-4-add-the-custom-post-type-code)
        - [**Step 5: Save and Verify**](#step-5-save-and-verify)
      - [**Advantages of Using MU-Plugins**](#advantages-of-using-mu-plugins)
      - [**Important Considerations**](#important-considerations)
  - [Custom Post Type Parameters](#custom-post-type-parameters)
  - [Custom Taxonomies](#custom-taxonomies)
    - [Registering a Custom Taxonomy](#registering-a-custom-taxonomy)
  - [Displaying Custom Post Types on the Front End](#displaying-custom-post-types-on-the-front-end)
    - [Template Hierarchy for Custom Post Types](#template-hierarchy-for-custom-post-types)
    - [Custom Queries](#custom-queries)
  - [Best Practices](#best-practices)
  - [Conclusion](#conclusion)
  - [Further Resources](#further-resources)

---

## What Are Custom Post Types?

In WordPress, a **post type** is a way of classifying different types of content. By default, WordPress includes several post types:

- **Posts**: Regular blog entries.
- **Pages**: Static pages like "About Us" or "Contact."
- **Attachments**: Media files uploaded to the site.
- **Revisions**: Previous versions of content.
- **Navigation Menus**: Menu items.

**Custom Post Types** are additional content types that you define to organize and present content that doesn't fit into the standard post or page structures.

**Examples of Custom Post Types:**

- **Portfolio Items**: For showcasing work or projects.
- **Products**: For e-commerce sites.
- **Events**: For event management.
- **Testimonials**: For client feedback.
- **Recipes**: For food blogs.

---

## Why Use Custom Post Types?

Custom Post Types allow you to:

- **Organize Content Effectively**: Segregate different content types for better management.
- **Enhance User Experience**: Provide a tailored interface in the WordPress admin area.
- **Apply Custom Templates**: Use specific templates for different content types.
- **Improve SEO**: Structure content in a way that's more understandable to search engines.
- **Add Custom Functionality**: Attach custom fields and metadata relevant to the content type.

---

## Creating Custom Post Types

You can create Custom Post Types either by adding code to your theme's `functions.php` file, by using a plugin, or by creating an **MU-Plugin** (Must-Use Plugin) in the `/wp-content/mu-plugins/` directory.

### Using Code in `functions.php`

To register a new Custom Post Type, you use the `register_post_type()` function.

**Example: Registering a "Portfolio" Custom Post Type**

```php
<?php
function create_portfolio_cpt() {

    $labels = array(
        'name' => __( 'Portfolios', 'textdomain' ),
        'singular_name' => __( 'Portfolio', 'textdomain' ),
        'menu_name' => __( 'Portfolios', 'textdomain' ),
        'name_admin_bar' => __( 'Portfolio', 'textdomain' ),
        'add_new' => __( 'Add New', 'textdomain' ),
        'add_new_item' => __( 'Add New Portfolio', 'textdomain' ),
        'new_item' => __( 'New Portfolio', 'textdomain' ),
        'edit_item' => __( 'Edit Portfolio', 'textdomain' ),
        'view_item' => __( 'View Portfolio', 'textdomain' ),
        'all_items' => __( 'All Portfolios', 'textdomain' ),
        'search_items' => __( 'Search Portfolios', 'textdomain' ),
        'parent_item_colon' => __( 'Parent Portfolio:', 'textdomain' ),
        'not_found' => __( 'No portfolios found.', 'textdomain' ),
        'not_found_in_trash' => __( 'No portfolios found in Trash.', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'A custom post type for portfolios.', 'textdomain' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_rest'       => true, // Enables Gutenberg editor
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'portfolio' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'portfolio', $args );
}

add_action( 'init', 'create_portfolio_cpt' );
```

**Explanation:**

- **Labels**: Defines the text used in the admin dashboard for this post type.
- **Arguments (`$args`)**: Configures the post type's behavior and features.
    - **`public`**: Makes the post type publicly accessible.
    - **`show_in_rest`**: Enables the block editor (Gutenberg) support.
    - **`rewrite`**: Sets the URL slug.
    - **`supports`**: Defines what features are available (e.g., title, editor, thumbnail).

**Important:** Place this code in your theme's `functions.php` file or, preferably, in a custom plugin to ensure portability.

### Using Plugins

If you prefer not to handle code, several plugins can create Custom Post Types:

- **Custom Post Type UI**: User-friendly interface for creating CPTs and taxonomies.
- **Pods**: Offers advanced features for custom content types and fields.
- **Toolset Types**: Allows creating CPTs, custom fields, and taxonomies.

### Using an MU-Plugin in `/wp-content/mu-plugins/`

**Note:**: This is the method used in the course. See [mu-plugins](/docs/plugins/university-post-types.php).
See also [ACF custom fields](/docs/md/custom_fields.md) plugin.

**MU-Plugins** (Must-Use Plugins) are plugins that are automatically enabled by WordPress and cannot be deactivated through the admin interface. They are ideal for site-specific functionality that should always be active, such as registering Custom Post Types.

#### **Why Use MU-Plugins for Custom Post Types?**

- **Portability**: Keeps functionality separate from the theme, allowing you to switch themes without losing custom post types.
- **Consistency**: Ensures critical functionality is always active.
- **Organization**: Keeps custom code organized in one place.

#### **Steps to Create an MU-Plugin for Custom Post Types**

##### **Step 1: Create the `mu-plugins` Directory**

If it doesn't exist already, create an `mu-plugins` directory inside the `wp-content` folder:

```
/wp-content/mu-plugins/
```

##### **Step 2: Create the MU-Plugin File**

Create a new PHP file within the `mu-plugins` directory. For example:

```
/wp-content/mu-plugins/custom-post-types.php
```

##### **Step 3: Add the Plugin Header**

At the top of the file, include a plugin header comment:

```php
<?php
/*
Plugin Name: Custom Post Types
Description: Registers custom post types for the site.
Author: Your Name
Version: 1.0
*/
```

##### **Step 4: Add the Custom Post Type Code**

Insert the code to register your custom post types. Here's the earlier "Portfolio" CPT code adjusted for the MU-Plugin:

```php
<?php
/*
Plugin Name: Custom Post Types
Description: Registers custom post types for the site.
Author: Your Name
Version: 1.0
*/

function create_portfolio_cpt() {

    $labels = array(
        'name' => __( 'Portfolios', 'textdomain' ),
        'singular_name' => __( 'Portfolio', 'textdomain' ),
        // ... (other labels)
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'A custom post type for portfolios.', 'textdomain' ),
        'public'             => true,
        // ... (other arguments)
    );

    register_post_type( 'portfolio', $args );
}

add_action( 'init', 'create_portfolio_cpt' );
```

**Note:** Ensure that all the necessary labels and arguments are included.

##### **Step 5: Save and Verify**

- Save the file.
- Visit your WordPress admin dashboard.
- The "Portfolios" custom post type should now appear in the admin menu.

#### **Advantages of Using MU-Plugins**

- **Theme Independence**: Custom post types remain available even if you change themes.
- **Always Active**: Cannot be deactivated via the admin interface, ensuring essential functionality is always running.
- **Organization**: Keeps custom functionality separate from theme and regular plugins.

#### **Important Considerations**

- **No Subdirectories**: By default, WordPress only loads MU-Plugins in the root of the `mu-plugins` directory, not in subdirectories. If you have multiple files, you'll need to include them manually.

  **Example of Including Multiple Files:**

  Create a loader file in `mu-plugins`:

  ```php
  <?php
  // mu-plugins/loader.php

  require_once __DIR__ . '/custom-post-types/portfolio.php';
  require_once __DIR__ . '/custom-post-types/events.php';
  // Add more as needed
  ```

  Place your individual CPT files in a subdirectory and include them using `require_once`.

- **Plugin Updates**: Since MU-Plugins are custom code, they don't receive updates like regular plugins. Ensure you maintain and update them as needed.

---

## Custom Post Type Parameters

When registering a Custom Post Type, you can configure various parameters:

- **`public`**: (bool) Whether it's accessible publicly.
- **`publicly_queryable`**: (bool) Whether queries can be performed on the front end.
- **`show_ui`**: (bool) Whether to display the admin UI.
- **`show_in_menu`**: (bool) Whether to show in the admin menu.
- **`show_in_nav_menus`**: (bool) Whether available for selection in navigation menus.
- **`rewrite`**: (array) URL rewrite settings.
- **`has_archive`**: (bool) Whether to have an archive page.
- **`supports`**: (array) Features like 'title', 'editor', 'thumbnail'.
- **`taxonomies`**: (array) Taxonomies associated with the CPT.
- **`menu_icon`**: (string) Icon for the admin menu (e.g., Dashicons class).

**Example of Configuring Parameters:**

```php
$args = array(
    'public' => true,
    'rewrite' => array( 'slug' => 'products' ),
    'has_archive' => true,
    'supports' => array( 'title', 'editor', 'custom-fields' ),
    'menu_icon' => 'dashicons-cart',
);
```

---

## Custom Taxonomies

Custom Taxonomies allow you to group your Custom Post Types in meaningful ways, similar to categories and tags.

### Registering a Custom Taxonomy

**Example: Creating a "Genre" Taxonomy for "Books" CPT**

```php
<?php
function create_book_taxonomy() {

    $labels = array(
        'name'              => __( 'Genres', 'textdomain' ),
        'singular_name'     => __( 'Genre', 'textdomain' ),
        // ... (other labels)
    );

    $args = array(
        'hierarchical'      => true, // Like categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => array( 'slug' => 'genre' ),
    );

    register_taxonomy( 'genre', array( 'book' ), $args );
}

add_action( 'init', 'create_book_taxonomy' );
```

**Explanation:**

- **`register_taxonomy()`**: Registers the taxonomy.
- **`hierarchical`**: Set to `true` for category-like behavior, `false` for tag-like.
- **Associating with CPT**: The second parameter, `array( 'book' )`, links the taxonomy to the "Book" CPT.

---

## Displaying Custom Post Types on the Front End

### Template Hierarchy for Custom Post Types

WordPress uses specific templates for displaying CPTs:

- **Single Post View**: `single-{post_type}.php`
    - Example: `single-portfolio.php`
- **Archive Page**: `archive-{post_type}.php`
    - Example: `archive-portfolio.php`
- **Taxonomy Archive**: `taxonomy-{taxonomy}.php`
    - Example: `taxonomy-genre.php`

If these templates don't exist, WordPress falls back to `single.php` and `archive.php`.

**Creating `single-portfolio.php` Template**

```php
<?php get_header(); ?>

<main id="main" class="site-main">
    <?php
    while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

            <?php if ( get_post_meta( get_the_ID(), 'client_name', true ) ) : ?>
                <p><strong>Client:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), 'client_name', true ) ); ?></p>
            <?php endif; ?>

        </article>

    <?php endwhile; ?>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
```

### Custom Queries

To display CPTs in loops or on specific pages, use `WP_Query` or `get_posts()`.

**Example: Display Latest 3 Portfolio Items**

```php
<?php
$args = array(
    'post_type' => 'portfolio',
    'posts_per_page' => 3,
);

$portfolio_query = new WP_Query( $args );

if ( $portfolio_query->have_posts() ) : ?>
    <div class="portfolio-items">
        <?php while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post(); ?>
            <div class="portfolio-item">
                <a href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'medium' );
                    } ?>
                    <h2><?php the_title(); ?></h2>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p><?php _e( 'No portfolio items found.', 'textdomain' ); ?></p>
<?php endif; ?>
```

**Note:** Always use `wp_reset_postdata()` after custom queries to restore the global `$post` variable.

---

## Best Practices

- **Use Plugins or MU-Plugins for Functionality**: Consider using plugins or MU-Plugins to register CPTs, especially if you plan to change themes without losing content.
- **Localization**: Use translation functions (`__()`, `_e()`) for strings to support multilingual sites.
- **Flush Rewrite Rules**: After adding new CPTs, go to **Settings > Permalinks** and click **Save Changes** to refresh rewrite rules.
- **Security**: Sanitize and validate input/output, especially when using custom fields and meta boxes.
- **Capabilities**: Adjust capabilities if you need custom permissions for different user roles.
- **REST API Support**: Set `'show_in_rest' => true` to enable Gutenberg editor and REST API functionality.
- **Avoid Editing Core Files**: Always place custom code in theme files, plugins, or MU-Plugins, not in WordPress core files.

---

## Conclusion

Custom Post Types in WordPress offer a flexible way to manage and display diverse content types, making your website more dynamic and tailored to specific needs. Whether you're building a portfolio, an e-commerce site, or any specialized platform, CPTs provide the structure necessary to handle custom content efficiently.

By understanding how to create and utilize Custom Post Types—whether in `functions.php`, through plugins, or by using an MU-Plugin in the `/wp-content/mu-plugins/` directory—you unlock the full potential of WordPress as a content management system, allowing for greater customization and scalability.

---

## Further Resources

- **WordPress Developer Resources:**
    - [Registering Custom Post Types](https://developer.wordpress.org/plugins/post-types/registering-custom-post-types/)
    - [Function Reference: `register_post_type()`](https://developer.wordpress.org/reference/functions/register_post_type/)
    - [Custom Taxonomies](https://developer.wordpress.org/plugins/taxonomies/working-with-custom-taxonomies/)
    - [Must-Use Plugins](https://codex.wordpress.org/Must_Use_Plugins)
    - [Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)

- **Plugins:**
    - [Custom Post Type UI](https://wordpress.org/plugins/custom-post-type-ui/)
    - [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/)
    - [Toolset Types](https://wordpress.org/plugins/types/)

- **Tutorials and Guides:**
    - [How to Create Custom Post Types in WordPress](https://www.wpbeginner.com/wp-tutorials/how-to-create-custom-post-types-in-wordpress/)
    - [A Guide to WordPress Custom Post Types](https://www.smashingmagazine.com/2012/01/create-custom-post-types-taxonomies-wordpress/)
    - [WordPress MU-Plugins: A Complete Guide](https://kinsta.com/knowledgebase/mu-plugins/)

---

By implementing Custom Post Types thoughtfully, and utilizing MU-Plugins when appropriate, you can enhance your WordPress site's functionality, improve content management, and provide a better experience for both site administrators and visitors.
