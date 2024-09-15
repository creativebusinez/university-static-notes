# Interior Pages Guide

**Interior pages** in a WordPress theme refer to all the pages of a website that are not the homepage. These pages typically include:

- **Static Pages**: Such as About Us, Contact, Services, Privacy Policy, etc.
- **Blog Posts**: Individual articles or posts.
- **Category and Archive Pages**: Listings of posts grouped by categories, tags, dates, or authors.
- **Search Results Pages**: Display results based on user search queries.
- **Custom Post Type Pages**: Pages for custom content types like portfolios, testimonials, products, etc.
- **404 Error Page**: Displayed when a requested page is not found.

Interior pages often share a common layout and design elements distinct from the homepage. They are crucial for providing detailed information and guiding users through the site's content.

---

## **Understanding Interior Page Templates**

WordPress uses a **template hierarchy** to determine which template file to use for displaying content. Common template files for interior pages include:

- **`page.php`**: The default template for all static pages.
- **`single.php`**: The default template for individual blog posts.
- **`single-{post-type}.php`**: Templates for custom post types (e.g., `single-product.php`).
- **`archive.php`**: Template for category, tag, author, or date archives.
- **`category.php`**, **`tag.php`**, **`author.php`**, **`date.php`**: Specific templates for different archive types.
- **`search.php`**: Template for search results.
- **`404.php`**: Template for 404 error pages.

### **Template Hierarchy Example**

When a user accesses a page, WordPress follows the template hierarchy to determine which template file to use. For instance:

- Accessing a **blog post**:
  - `single-{post-type}.php` (e.g., `single-post.php`)
  - `single.php`
  - `index.php`

- Accessing a **static page**:
  - `page-{slug}.php` (e.g., `page-contact.php`)
  - `page-{ID}.php` (e.g., `page-10.php`)
  - `page.php`
  - `index.php`

---

## **Creating and Customizing Interior Pages**

### **1. Custom Page Templates**

To create a unique layout for a specific page:

1. **Create a New Template File**: For example, `page-contact.php`.

2. **Add Template Name Comment** (optional if using Template Name):

   ```php
   <?php
   /* Template Name: Custom Contact Page */
   get_header(); ?>

   <!-- Page-specific HTML and PHP code -->

   <?php get_footer(); ?>
   ```

3. **Assign the Template to a Page**:

   - In the WordPress admin dashboard, edit the page.
   - In the **Page Attributes** box, select the custom template from the **Template** dropdown.

### **2. Using Conditional Tags**

Modify content based on the type of page being viewed:

```php
<?php if (is_page('about')): ?>
  <!-- Code specific to the About page -->
<?php elseif (is_single()): ?>
  <!-- Code specific to single posts -->
<?php else: ?>
  <!-- Default code -->
<?php endif; ?>
```

### **3. Template Parts**

Reuse code across multiple templates using `get_template_part()`:

- **Create a Template Part**:

  ```php
  <!-- content-page.php -->
  <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h1><?php the_title(); ?></h1>
    <div class="page-content">
      <?php the_content(); ?>
    </div>
  </article>
  ```

- **Include in Templates**:

  ```php
  <?php get_template_part('content', 'page'); ?>
  ```

---

## **Styling Interior Pages**

### **1. Body Classes**

Use the `body_class()` function to add unique classes to the `<body>` tag:

```php
<body <?php body_class(); ?>>
```

This outputs classes like:

- `page`
- `page-id-2`
- `page-contact`
- `single`
- `postid-45`

**CSS Example**:

```css
/* Style for the Contact page */
.page-contact .site-header {
  background-color: #f0f0f0;
}
```

### **2. Enqueue Page-Specific Styles and Scripts**

In `functions.php`, enqueue styles or scripts conditionally:

```php
function enqueue_page_specific_assets() {
  if (is_page('gallery')) {
    wp_enqueue_style('gallery-styles', get_template_directory_uri() . '/css/gallery.css');
    wp_enqueue_script('gallery-scripts', get_template_directory_uri() . '/js/gallery.js', array('jquery'), null, true);
  }
}
add_action('wp_enqueue_scripts', 'enqueue_page_specific_assets');
```

### **3. Custom Fields and Metadata**

Utilize custom fields to add unique content to interior pages:

- **Using Advanced Custom Fields (ACF) Plugin**:

  ```php
  <?php
  $subtitle = get_field('subtitle');
  if ($subtitle):
  ?>
    <h2><?php echo esc_html($subtitle); ?></h2>
  <?php endif; ?>
  ```

---

## **Best Practices for Interior Pages**

### **Consistency and Reusability**

- **Maintain Consistent Navigation**: Keep menus and navigation elements consistent across pages.
- **Use Template Parts**: Modularize code for headers, footers, sidebars, and content sections.

### **Accessibility**

- **Semantic HTML**: Use proper heading levels (`<h1>` to `<h6>`), lists, and landmarks.
- **Alt Text for Images**: Ensure all images have descriptive `alt` attributes.

### **SEO Optimization**

- **Title Tags and Meta Descriptions**: Use `wp_title()` and plugins like Yoast SEO.
- **Structured Data**: Implement schema markup where appropriate.

### **Performance**

- **Optimize Images**: Use appropriate image sizes and formats.
- **Minimize HTTP Requests**: Combine CSS and JS files when possible.

---

## **Examples of Interior Page Templates**

### **1. `page.php` (Default Page Template)**

```php
<?php get_header(); ?>

<main id="main" class="site-main">
  <?php
  while (have_posts()): the_post();
    get_template_part('content', 'page');
  endwhile;
  ?>
</main>

<?php get_footer(); ?>
```

### **2. `single.php` (Single Post Template)**

```php
<?php get_header(); ?>

<main id="main" class="site-main">
  <?php
  while (have_posts()): the_post();
    get_template_part('content', get_post_format());
  endwhile;
  ?>
</main>

<?php get_footer(); ?>
```

### **3. `archive.php` (Archive Template)**

```php
<?php get_header(); ?>

<main id="main" class="site-main">
  <header class="page-header">
    <h1 class="page-title"><?php the_archive_title(); ?></h1>
    <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
  </header>

  <?php if (have_posts()): ?>
    <?php
    while (have_posts()): the_post();
      get_template_part('content', get_post_format());
    endwhile;

    the_posts_navigation();
    ?>
  <?php else: ?>
    <p><?php esc_html_e('No posts found.', 'textdomain'); ?></p>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
```

---

## **Customizing Interior Pages with Page Builders**

- **Gutenberg Block Editor**: Use blocks to create complex layouts.
- **Page Builder Plugins**: Elementor, Beaver Builder, and Divi offer advanced customization.

---

## **Advanced Techniques**

### **Custom Post Types and Taxonomies**

- **Register Custom Post Types**:

  ```php
  function create_custom_post_type() {
    register_post_type('portfolio',
      array(
        'labels' => array('name' => __('Portfolios')),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
      )
    );
  }
  add_action('init', 'create_custom_post_type');
  ```

- **Create Custom Templates**:

  - `single-portfolio.php` for single portfolio items.
  - `archive-portfolio.php` for portfolio archives.

### **Customizing the Loop**

Modify the WordPress Loop to display posts differently on interior pages:

```php
<?php
$args = array(
  'post_type' => 'portfolio',
  'posts_per_page' => 10,
);
$portfolio_query = new WP_Query($args);

if ($portfolio_query->have_posts()):
  while ($portfolio_query->have_posts()): $portfolio_query->the_post();
    // Display portfolio item
  endwhile;
  wp_reset_postdata();
else:
  echo '<p>No portfolio items found.</p>';
endif;
?>
```

---

## **Conclusion**

Interior pages are essential components of a WordPress theme, representing the various content types and pages beyond the homepage. By understanding and utilizing WordPress's template hierarchy, conditional tags, and template parts, you can create customized and dynamic interior pages that enhance user experience and meet the specific needs of your website.

---

## **Further Resources**

- **WordPress Theme Development**: [WordPress Theme Handbook](https://developer.wordpress.org/themes/)
- **Template Hierarchy**: [Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- **Creating Custom Page Templates**: [Page Templates](https://developer.wordpress.org/themes/template-files-section/page-template-files/)
- **Custom Post Types**: [Registering Custom Post Types](https://developer.wordpress.org/plugins/post-types/registering-custom-post-types/)
- **Conditional Tags**: [Conditional Tags Reference](https://developer.wordpress.org/themes/basics/conditional-tags/)

By leveraging these tools and best practices, you can effectively design and implement interior pages that are both functional and aesthetically pleasing, contributing to a comprehensive and engaging WordPress website.
