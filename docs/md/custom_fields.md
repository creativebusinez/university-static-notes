# Custom Fields

WordPress Custom Fields are a feature that allows users and developers to add additional metadata to posts, pages, and custom post types. This metadata can store extra information that doesn't naturally fit into the content of a post or page, such as mood, weather conditions at the time of writing, a rating for a review, or any other arbitrary data. Custom fields are a powerful tool for extending the functionality and flexibility of WordPress content, enabling personalized and complex data management within the WordPress ecosystem.

## How Custom Fields Work

Each custom field consists of two main components:

- **Key**: Also known as the name of the custom field. It identifies the type of data stored.
- **Value**: The actual data or information stored in the custom field.

## Implementing Custom Fields

Custom fields can be added directly from the WordPress post or page editor. Below the editor area, there's a section titled "Custom Fields" where you can add new custom fields by entering a key and a value. If the "Custom Fields" section is not visible, you may need to enable it through the "Screen Options" panel at the top of the editor page.

## Usage Examples

Imagine you're writing a book review and want to include a rating. You could create a custom field named `rating` and assign it a value, like `4.5`. This data can then be programmatically retrieved and displayed anywhere within your theme.

## Displaying Custom Field Data

To display custom field data within your theme files, you use the `get_post_meta()` function. Here's how you could display the `rating` custom field mentioned earlier:

```php
<?php
$rating = get_post_meta(get_the_ID(), 'rating', true);
if (!empty($rating)) {
    echo 'Rating: ' . esc_html($rating);
}
?>
```

## Advanced Custom Fields (ACF) Plugin

While WordPress supports custom fields natively, managing them through the WordPress UI can be cumbersome, especially for non-developers or for complex data structures. The Advanced Custom Fields plugin simplifies the process, providing a user-friendly interface for creating, managing, and displaying custom data more efficiently. ACF extends the capabilities of custom fields, allowing for repeater fields, flexible content fields, galleries, and much more, significantly enhancing the way you can manage and use custom data in WordPress.

## CMB2 (Custom Meta Boxes) Plugin

CMB2, which stands for Custom Meta Boxes 2, is a developer's toolkit for building metaboxes, custom fields, and forms for WordPress. This helps to add custom data to posts, users, or comments. The plugin creates a way to show fields on an admin page, as well as handle sanitization, validation and saving of the field data.

Here's an example of how CMB2 can be used to add a metabox with custom fields:

```php
function cmb2_sample_metaboxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_cmb2_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => 'test_metabox',
        'title'         => __( 'Test Metabox', 'cmb2' ),
        'object_types'  => array( 'page', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

    // Regular text field
    $cmb->add_field( array(
        'name'       => __( 'Test Text', 'cmb2' ),
        'desc'       => __( 'field description (optional)', 'cmb2' ),
        'id'         => $prefix . 'text',
        'type'       => 'text',
        'show_on_cb' => 'cmb2_hide_if_no_cats',
    ) );
}
add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes' );
```

The above code adds a metabox with a single text field to the 'page' post type. The new_cmb2_box function is used to initialize a new metabox, and the add_field method is used to add fields to the metabox. The 'id', 'type', 'name', etc., are options used to configure the field.

## Benefits of Using Custom Fields

- **Flexibility**: They allow for the addition of custom data to posts and pages, enabling unique content features tailored to specific needs.
- **Personalization**: Custom fields can be used to provide a more personalized experience by displaying relevant data that enhances the content.
- **Integration**: They can be used to integrate WordPress content with external applications by storing identifiers, URLs, or other data relevant for API calls.

## Best Practices

- **Consistent Naming**: Use consistent, descriptive names for your custom field keys to avoid confusion and conflicts.
- **Validation and Sanitization**: Always validate and sanitize custom field data when saving and escaping it when displaying to ensure security and data integrity.
- **Check for Existence**: Before displaying custom field data, check if the field exists and is not empty to avoid displaying unwanted empty sections.

Custom fields are a cornerstone feature for developers looking to extend WordPress beyond standard posts and pages, enabling the creation of detailed and structured content for any type of website.

### ACF and the `mu-plugins.php` ( Must-Use Plugins ) file

- **Must-Use Plugins** (located in the `mu-plugins` directory) are ideal for critical functionality like registering custom post types that you want always to be active, regardless of changes to your theme or other plugins.[See Usage](/docs/plugins/mu_plugins.md)
- By placing custom post type registration and core logic in `mu-plugins.php`, you ensure that essential components like "Products" and "Discounts" are always available, providing a stable and reliable backbone for your e-commerce site.

### Relationship Overview

- **Custom Post Types** in `mu-plugins.php` define the core content structures of the e-commerce site, like "Products" and "Discounts."
- **ACF** extends these post types by allowing you to add custom fields (e.g., price, stock status, dimensions) that provide more detailed product information.
- **`mu-plugins.php`** ensures the core logic for custom post types and any required global custom field logic (like applying discounts) remains active across the site.

This combination creates a powerful, flexible system for managing e-commerce content efficiently.

### ACF Examples

In an **e-commerce website**, **ACF (Advanced Custom Fields)** and the `mu-plugins.php` (Must-Use Plugins) file work together to enhance functionality by defining custom post types for your products, categories, or other essential content types, while adding custom fields to manage extra product details.

### Key Components

1. **Custom Post Types in `mu-plugins.php`:**
   - The `mu-plugins.php` file is used to define multiple custom post types for your e-commerce website. For example, you could create custom post types for "Products," "Discounts," and "Vendors."
   - The `register_post_type()` function allows you to control how these content types are handled, such as adding REST API support, defining custom URLs (slugs), setting admin icons, and more.

   - Example: Creating custom post types for an e-commerce site:

   ```php
   function ecommerce_post_types() {
       // Product post type
       register_post_type('product', [
           'supports' => ['title', 'editor', 'thumbnail'],
           'rewrite' => ['slug' => 'products'],
           'has_archive' => true,
           'public' => true,
           'show_in_rest' => true,
           'labels' => [
               'name' => 'Products',
               'add_new_item' => 'Add New Product',
               'edit_item' => 'Edit Product',
               'all_items' => 'All Products',
               'singular_name' => 'Product'
           ],
           'menu_icon' => 'dashicons-cart',
       ]);

       // Discount post type
       register_post_type('discount', [
           'supports' => ['title', 'editor'],
           'rewrite' => ['slug' => 'discounts'],
           'has_archive' => true,
           'public' => true,
           'show_in_rest' => true,
           'labels' => [
               'name' => 'Discounts',
               'add_new_item' => 'Add New Discount',
               'edit_item' => 'Edit Discount',
               'all_items' => 'All Discounts',
               'singular_name' => 'Discount'
           ],
           'menu_icon' => 'dashicons-tag',
       ]);

       // Vendor post type
       register_post_type('vendor', [
           'supports' => ['title', 'editor'],
           'public' => true,
           'show_in_rest' => true,
           'labels' => [
               'name' => 'Vendors',
               'add_new_item' => 'Add New Vendor',
               'edit_item' => 'Edit Vendor',
               'all_items' => 'All Vendors',
               'singular_name' => 'Vendor'
           ],
           'menu_icon' => 'dashicons-store',
       ]);
   }

   add_action('init', 'ecommerce_post_types');
   ```

2. **ACF and Custom Fields**:
   - Once the custom post types (like "Products" or "Discounts") are registered in `mu-plugins.php`, ACF allows you to add custom fields to store additional metadata for each post type.
   - For instance, for the "Product" post type, you might want to add fields such as "Price," "SKU," "Stock Availability," "Product Dimensions," and "Color Options." ACF makes it easy to define and manage these fields through a user-friendly admin interface.
   - These fields give you the flexibility to capture more product-specific information that is not available by default.

3. **Displaying ACF Fields in Templates**:
   - After setting up the custom fields using ACF, you would display them on the front end (e.g., product pages) using template files or logic in `mu-plugins.php` or `functions.php`.

   - Example of displaying a custom product price:

     ```php
     if( function_exists('the_field') ) {
         $price = get_field('product_price');
         if( $price ) {
             echo '<p>Price: $' . esc_html($price) . '</p>';
         }
     }
     ```

4. **Custom Logic for ACF Fields in `mu-plugins.php`**:
   - You can also use the `mu-plugins.php` file to define global logic that interacts with your custom fields, such as displaying a message when stock is low or automatically applying a discount based on certain criteria.

   - Example of applying a discount if a custom field for "Discount Percentage" is set:

 ```php
     add_action('woocommerce_before_calculate_totals', 'apply_custom_discount');
     function apply_custom_discount($cart) {
         if( !is_admin() && !empty($cart->get_cart()) ) {
             foreach( $cart->get_cart() as $cart_item ) {
                 $product_id = $cart_item['product_id'];
                 $discount = get_field('discount_percentage', $product_id);
                 if ( $discount ) {
                     $price = $cart_item['data']->get_price();
                     $new_price = $price - ($price * ($discount / 100));
                     $cart_item['data']->set_price($new_price);
                 }
             }
         }
     }
     ```
