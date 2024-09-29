# **Creating a Menu of Child Pages in WordPress**

In WordPress, displaying a menu of child pages under a parent page is a common requirement for enhancing site navigation and user experience. This can be particularly useful for sites with hierarchical content structures, such as documentation, tutorials, or multi-level service pages. Below is a comprehensive guide on how to create a menu of child link pages using various methods.

---

## **Understanding Parent and Child Pages**

Before proceeding, ensure you have a parent page with child pages assigned:

- **Parent Page**: A top-level page that serves as a container for related child pages.
- **Child Pages**: Sub-pages that fall under the parent page, creating a hierarchical relationship.

---

## **Method 1: Using `wp_list_pages()` Function**

The `wp_list_pages()` function generates a list of pages, which can be customized to display only the child pages of a specific parent.

### **Step 1: Identify the Parent Page ID**

- **Option A**: Use within the parent page template:

  ```php
  <?php $parent_id = get_the_ID(); ?>
  ```

- **Option B**: Specify the parent page ID directly (replace `123` with your parent page ID):

  ```php
  <?php $parent_id = 123; ?>
  ```

### **Step 2: Generate the Menu**

```php
<?php
$child_pages = wp_list_pages(array(
    'title_li'    => '',
    'child_of'    => $parent_id,
    'echo'        => false,
    'sort_column' => 'menu_order', // Optional: Orders pages by the order set in admin
));

if ($child_pages) {
    echo '<ul class="child-page-menu">' . $child_pages . '</ul>';
}
?>
```

**Parameters Explained**:

- **`title_li`**: Sets the list title; an empty string removes it.
- **`child_of`**: Filters pages to only those that are children of the specified parent.
- **`echo`**: When set to `false`, the function returns the output instead of printing it.
- **`sort_column`**: Orders the pages; options include `post_title`, `menu_order`, etc.

### **Step 3: Styling the Menu**

Add CSS to your theme's stylesheet (`style.css`):

```css
.child-page-menu {
    list-style: none;
    padding: 0;
}

.child-page-menu li {
    margin-bottom: 10px;
}

.child-page-menu li a {
    text-decoration: none;
    color: #333;
}

.child-page-menu li a:hover {
    color: #0073aa;
}
```

---

## **Method 2: Using `get_pages()` Function**

If you need more control over the output, `get_pages()` returns an array of page objects, allowing you to build the menu manually.

### **Step 1: Retrieve Child Pages**

```php
<?php
$child_pages = get_pages(array(
    'parent'      => $parent_id,
    'sort_column' => 'menu_order',
));
?>
```

### **Step 2: Loop Through and Display Links**

```php
<?php if (!empty($child_pages)): ?>
    <ul class="child-page-menu">
        <?php foreach ($child_pages as $page): ?>
            <li>
                <a href="<?php echo get_permalink($page->ID); ?>">
                    <?php echo esc_html($page->post_title); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
```

---

## **Method 3: Using Custom Menus**

Create a custom menu in the WordPress admin and display it using `wp_nav_menu()`.

### **Step 1: Register a Menu Location**

In your `functions.php`:

```php
<?php
function register_child_pages_menu() {
    register_nav_menu('child-pages-menu', __('Child Pages Menu'));
}
add_action('init', 'register_child_pages_menu');
?>
```

### **Step 2: Create the Menu in Admin**

1. Go to **Appearance > Menus**.
2. Click **Create a new menu**, name it (e.g., "Child Pages Menu"), and add your child pages.
3. Assign the menu to the "Child Pages Menu" location.

### **Step 3: Display the Menu in Your Template**

```php
<?php
wp_nav_menu(array(
    'theme_location' => 'child-pages-menu',
    'menu_class'     => 'child-page-menu',
));
?>
```

---

## **Method 4: Using Widgets**

If your theme supports widgets, you can use the **Pages** widget to display child pages.

### **Step 1: Add a Widget**

1. Go to **Appearance > Widgets**.
2. Drag the **Pages** widget to your desired widget area.
3. Configure the widget:
   - **Title**: Optional.
   - **Sort by**: Choose your preference.
   - **Include**: Leave blank or specify page IDs.
   - **Exclude**: Specify IDs of pages to exclude.
4. Save the widget.

### **Step 2: Limit to Child Pages (Optional)**

By default, the Pages widget displays all pages. To limit it to child pages, you may need a plugin or custom code, as the default widget doesn't support this directly.

---

## **Method 5: Using Shortcodes and Plugins**

### **Option A: Use a Plugin**

Install a plugin like **List Subpages** or **Child Pages Shortcode**.

1. **Install and Activate the Plugin**:
   - Go to **Plugins > Add New**.
   - Search for the plugin and install it.
2. **Use the Shortcode**:
   - In the page editor, add `[child_pages]` or the plugin's specific shortcode.
   - Customize attributes as needed (refer to the plugin's documentation).

### **Option B: Create a Custom Shortcode**

In `functions.php`, add:

```php
<?php
function child_pages_menu_shortcode($atts) {
    global $post;
    $atts = shortcode_atts(array(
        'parent_id' => $post->ID,
    ), $atts, 'child_pages_menu');

    $child_pages = wp_list_pages(array(
        'title_li' => '',
        'child_of' => $atts['parent_id'],
        'echo'     => false,
    ));

    if ($child_pages) {
        return '<ul class="child-page-menu">' . $child_pages . '</ul>';
    }
}
add_shortcode('child_pages_menu', 'child_pages_menu_shortcode');
?>
```

**Usage in Page Content**:

```plaintext
[child_pages_menu parent_id="123"]
```

---

## **Method 6: Advanced Customization with Template Parts**

### **Step 1: Create a Template Part**

Create a file named `child-page-menu.php` in your theme folder.

```php
<?php
// Get the current page ID
$current_page_id = get_the_ID();

// Get the topmost parent page ID
$parent_id = $post->post_parent ? $post->post_parent : $post->ID;

// Get child pages
$child_pages = wp_list_pages(array(
    'title_li'    => '',
    'child_of'    => $parent_id,
    'echo'        => false,
    'sort_column' => 'menu_order',
));

if ($child_pages) {
    echo '<ul class="child-page-menu">' . $child_pages . '</ul>';
}
?>
```

### **Step 2: Include the Template Part in Your Theme**

In your page templates (`page.php`, `single.php`, etc.):

```php
<?php get_template_part('child-page-menu'); ?>
```

---

## **Additional Tips**

### **1. Dynamically Determine the Parent Page**

If you want the menu to adapt based on the current page:

```php
<?php
if ($post->post_parent) {
    // This is a child page
    $parent_id = $post->post_parent;
} else {
    // This is a parent page
    $parent_id = $post->ID;
}
?>
```

### **2. Exclude Certain Pages**

To exclude pages from the menu:

```php
<?php
$child_pages = wp_list_pages(array(
    'title_li' => '',
    'child_of' => $parent_id,
    'exclude'  => '10,15', // IDs of pages to exclude
    'echo'     => false,
));
?>
```

### **3. Customizing Output with Filters**

Use filters like `wp_list_pages` to modify the output:

```php
<?php
function custom_wp_list_pages_filter($output) {
    // Modify the output as needed
    return $output;
}
add_filter('wp_list_pages', 'custom_wp_list_pages_filter');
?>
```

---

## **Best Practices**

### **Use Proper Escaping**

Always sanitize and escape output to enhance security:

```php
<?php echo esc_html($page->post_title); ?>
```

### **Accessibility**

Ensure your menu is accessible:

- Use semantic HTML (`<nav>`, `<ul>`, `<li>`, `<a>`).
- Include ARIA attributes if necessary.

### **Styling and Responsive Design**

- Test the menu on different devices.
- Ensure the menu collapses or adapts appropriately on smaller screens.

---

## **Conclusion**

Creating a menu of child link pages in WordPress enhances navigation and helps users easily access related content. Whether you choose to use built-in functions, widgets, plugins, or custom code, WordPress provides flexible options to suit your needs. By following the methods outlined above, you can create dynamic, hierarchical menus that improve the usability of your website.

---

## **Further Resources**

- **WordPress Codex**:
  - [wp_list_pages() Function](https://codex.wordpress.org/Function_Reference/wp_list_pages)
  - [get_pages() Function](https://codex.wordpress.org/Function_Reference/get_pages)
- **Template Tags**:
  - [wp_nav_menu()](https://developer.wordpress.org/reference/functions/wp_nav_menu/)
- **Plugins**:
  - [List Subpages](https://wordpress.org/plugins/list-subpages/)
  - [Child Pages Shortcode](https://wordpress.org/plugins/child-pages-shortcode/)
- **Tutorials**:
  - [How to List Child Pages for a Parent Page in WordPress](https://www.wpbeginner.com/wp-themes/how-to-list-child-pages-for-a-parent-page-in-wordpress/)
  - [Creating Dynamic Submenus in WordPress](https://premium.wpmudev.org/blog/dynamic-submenus-in-wordpress/)

By utilizing these techniques and best practices, you can effectively create and manage menus of child pages, enhancing both the functionality and user experience of your WordPress site.
