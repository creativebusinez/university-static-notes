# Ordering (Sorting) Custom Queries in WordPress

Ordering, or sorting, custom queries in WordPress allows you to control the display order of your posts or custom post types based on specific criteria. By customizing the order, you can enhance user experience by presenting content in a logical and meaningful sequence.

This guide will explain how to order custom queries using the `WP_Query` class, including sorting by default parameters and custom fields (meta values), and provide practical examples.

---

## Table of Contents

- [Ordering (Sorting) Custom Queries in WordPress](#ordering-sorting-custom-queries-in-wordpress)
  - [Table of Contents](#table-of-contents)
  - [Understanding WP\_Query Parameters](#understanding-wp_query-parameters)
  - [Ordering by Default Parameters](#ordering-by-default-parameters)
    - [Order by Date](#order-by-date)
    - [Order by Title](#order-by-title)
    - [Order by Menu Order](#order-by-menu-order)
    - [Order by Author](#order-by-author)
  - [Ordering by Custom Fields (Meta Values)](#ordering-by-custom-fields-meta-values)
    - [Order by Meta Value](#order-by-meta-value)
    - [Order by Numeric Meta Value](#order-by-numeric-meta-value)
  - [Combining Multiple Orderby Parameters](#combining-multiple-orderby-parameters)
  - [Practical Examples](#practical-examples)
    - [Example 1: Order Products by Price (Numeric Meta Field)](#example-1-order-products-by-price-numeric-meta-field)
    - [Example 2: Order Events by Event Date (Date Meta Field)](#example-2-order-events-by-event-date-date-meta-field)
    - [Example 3: Order Posts Alphabetically by Title](#example-3-order-posts-alphabetically-by-title)
  - [Custom Queries with Pagination](#custom-queries-with-pagination)
  - [Best Practices](#best-practices)
  - [Conclusion](#conclusion)
  - [Further Resources](#further-resources)

---

## Understanding WP_Query Parameters

The `WP_Query` class allows you to create custom queries by passing an array of parameters. Two key parameters for ordering are:

- **`orderby`**: Specifies the field(s) to sort by.
- **`order`**: Specifies the sorting order (`'ASC'` for ascending, `'DESC'` for descending).

---

## Ordering by Default Parameters

### Order by Date

By default, WordPress orders posts by date in descending order (newest first).

**Parameters:**

```php
'orderby' => 'date',
'order'   => 'DESC' // or 'ASC' for oldest first
```

**Example:**

```php
$args = array(
    'post_type' => 'post',
    'orderby'   => 'date',
    'order'     => 'DESC',
);
$query = new WP_Query( $args );
```

### Order by Title

Sort posts alphabetically by title.

**Parameters:**

```php
'orderby' => 'title',
'order'   => 'ASC' // or 'DESC' for reverse alphabetical
```

**Example:**

```php
$args = array(
    'post_type' => 'post',
    'orderby'   => 'title',
    'order'     => 'ASC',
);
$query = new WP_Query( $args );
```

### Order by Menu Order

Useful for custom post types where you can set the order manually via the 'Order' field in the Page Attributes metabox.

**Parameters:**

```php
'orderby' => 'menu_order',
'order'   => 'ASC' // or 'DESC'
```

**Example:**

```php
$args = array(
    'post_type' => 'page', // or your custom post type
    'orderby'   => 'menu_order',
    'order'     => 'ASC',
);
$query = new WP_Query( $args );
```

### Order by Author

Sort posts by author.

**Parameters:**

```php
'orderby' => 'author',
'order'   => 'ASC' // or 'DESC'
```

---

## Ordering by Custom Fields (Meta Values)

To order posts by custom fields (also known as meta values), you need to specify additional parameters.

### Order by Meta Value

When the meta value is a string (e.g., text).

**Parameters:**

```php
'meta_key' => 'your_meta_key',
'orderby'  => 'meta_value',
'order'    => 'ASC' // or 'DESC'
```

**Example:**

```php
$args = array(
    'post_type' => 'your_post_type',
    'meta_key'  => 'custom_field_key',
    'orderby'   => 'meta_value',
    'order'     => 'ASC',
);
$query = new WP_Query( $args );
```

### Order by Numeric Meta Value

When the meta value is numeric (e.g., price, numerical ratings).

**Parameters:**

```php
'meta_key'  => 'your_meta_key',
'orderby'   => 'meta_value_num',
'order'     => 'ASC' // or 'DESC'
```

**Example:**

```php
$args = array(
    'post_type' => 'product',
    'meta_key'  => 'price',
    'orderby'   => 'meta_value_num',
    'order'     => 'ASC',
);
$query = new WP_Query( $args );
```

**Important Note:**

- Use `'meta_value_num'` for numeric values to ensure proper numerical sorting.
- For dates stored as strings (e.g., '2022-12-31'), you might need to use `'meta_value'` and ensure the date format allows for proper string comparison.

---

## Combining Multiple Orderby Parameters

You can sort by multiple fields by passing an array to `'orderby'`.

**Example:**

```php
$args = array(
    'post_type' => 'event',
    'meta_key'  => 'event_date',
    'orderby'   => array(
        'meta_value' => 'ASC',
        'title'      => 'ASC',
    ),
    // 'order' is ignored when 'orderby' is an array with directions
);
$query = new WP_Query( $args );
```

**Explanation:**

- The query will first sort by 'event_date' (meta_value), and then by 'title' if there are events with the same date.

---

## Practical Examples

### Example 1: Order Products by Price (Numeric Meta Field)

**Scenario:**

You have a custom post type 'product' with a custom field 'price', and you want to display products sorted by price from lowest to highest.

**Code:**

```php
$args = array(
    'post_type'  => 'product',
    'meta_key'   => 'price',
    'orderby'    => 'meta_value_num',
    'order'      => 'ASC',
    'posts_per_page' => -1, // Display all products
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
        $query->the_post();
        $price = get_post_meta( get_the_ID(), 'price', true );
        // Display product information
        echo '<h2>' . get_the_title() . '</h2>';
        echo '<p>Price: $' . esc_html( $price ) . '</p>';
    }
    wp_reset_postdata();
} else {
    echo 'No products found.';
}
```

### Example 2: Order Events by Event Date (Date Meta Field)

**Scenario:**

You have an 'event' custom post type with a custom field 'event_date' stored in 'YYYYMMDD' format, and you want to display upcoming events in chronological order.

**Code:**

```php
$today = date( 'Ymd' );

$args = array(
    'post_type'      => 'event',
    'meta_key'       => 'event_date',
    'meta_value'     => $today,
    'meta_compare'   => '>=',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
    'posts_per_page' => -1,
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    echo '<ul>';
    while ( $query->have_posts() ) {
        $query->the_post();
        $event_date = get_post_meta( get_the_ID(), 'event_date', true );
        // Display event information
        echo '<li>';
        echo '<strong>' . esc_html( $event_date ) . '</strong>: ';
        echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
        echo '</li>';
    }
    echo '</ul>';
    wp_reset_postdata();
} else {
    echo 'No upcoming events found.';
}
```

**Explanation:**

- **`meta_compare`**: Used to compare the 'event_date' meta value with today's date.
- **`orderby`**: Sorts events by 'event_date'.
- **Date Format**: Ensure dates are stored in a format suitable for string comparison (e.g., 'YYYYMMDD' or 'YYYY-MM-DD').

### Example 3: Order Posts Alphabetically by Title

**Scenario:**

Display all posts ordered alphabetically by title.

**Code:**

```php
$args = array(
    'post_type'      => 'post',
    'orderby'        => 'title',
    'order'          => 'ASC',
    'posts_per_page' => -1,
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    echo '<ul>';
    while ( $query->have_posts() ) {
        $query->the_post();
        // Display post title
        echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    }
    echo '</ul>';
    wp_reset_postdata();
} else {
    echo 'No posts found.';
}
```

---

## Custom Queries with Pagination

When ordering custom queries, you may also need pagination.

**Example:**

```php
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$args = array(
    'post_type'      => 'product',
    'meta_key'       => 'price',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
    'posts_per_page' => 10,
    'paged'          => $paged,
);

$query = new WP_Query( $args );

// Display posts as before

// Pagination links
echo paginate_links( array(
    'total' => $query->max_num_pages,
) );
```

**Note:**

- Ensure you pass the 'paged' parameter to the query.
- Use `paginate_links()` or `the_posts_pagination()` to display pagination links.

---

## Best Practices

- **Use Correct 'orderby' Value:**

  - Use `'meta_value_num'` for numeric meta values.
  - Use `'meta_value'` for string meta values.

- **Data Storage:**

  - Store dates and numbers in formats suitable for sorting.
  - For dates, use 'YYYYMMDD' or UNIX timestamps.

- **Index Meta Keys:**

  - Frequently queried meta keys can be indexed for better performance (requires database optimization).

- **Test Queries:**

  - Ensure your queries return expected results.
  - Test edge cases (e.g., when meta values are missing).

- **Security:**

  - Always sanitize and escape output when displaying data.

---

## Conclusion

Ordering (sorting) custom queries in WordPress allows you to present content in a way that best suits your site's needs and enhances user experience. By leveraging the 'orderby' and 'order' parameters in `WP_Query`, you can sort posts by default fields or custom fields (meta values), whether they are strings, numbers, or dates.

Understanding how to properly construct your queries and format your data is crucial to achieving accurate and efficient sorting.

---

## Further Resources

- **WordPress Developer Resources:**

  - [Class Reference: WP_Query](https://developer.wordpress.org/reference/classes/wp_query/)
  - [WP_Query Parameters](https://developer.wordpress.org/reference/classes/wp_query/#parameters)
  - [Order & Orderby Parameters](https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters)

- **Tutorials and Guides:**

  - [Mastering WP_Query](https://www.smashingmagazine.com/2013/12/wordpress-developers-guide-the-loop/)
  - [Ordering WordPress Posts with WP_Query](https://developer.wordpress.org/themes/basics/the-loop/#ordering-posts)

- **Advanced Custom Fields (ACF):**

  - [Ordering Posts by Custom Fields](https://www.advancedcustomfields.com/resources/query-posts-custom-fields/)

---
