# **Custom Query Pagination in WordPress**

Pagination is an essential aspect of web development, allowing users to navigate through multiple pages of content easily. In WordPress, pagination is handled automatically for the main query, but when you create **custom queries** using `WP_Query` or `get_posts()`, you need to implement pagination manually to ensure proper navigation and functionality.

This guide will explain how to implement pagination in custom queries, covering the necessary steps, best practices, and practical examples to help you integrate pagination seamlessly into your WordPress site.

---

## **Table of Contents**

- [**Custom Query Pagination in WordPress**](#custom-query-pagination-in-wordpress)
  - [**Table of Contents**](#table-of-contents)
  - [**Understanding Pagination in WordPress**](#understanding-pagination-in-wordpress)
  - [**Why Custom Queries Need Special Pagination Handling**](#why-custom-queries-need-special-pagination-handling)
  - [**Implementing Pagination in Custom Queries**](#implementing-pagination-in-custom-queries)
    - [**Step 1: Set Up the Custom Query with Pagination Parameters**](#step-1-set-up-the-custom-query-with-pagination-parameters)
    - [**Step 2: Display the Posts**](#step-2-display-the-posts)
    - [**Step 3: Add Pagination Links**](#step-3-add-pagination-links)
  - [**Pagination Functions**](#pagination-functions)
    - [**`paginate_links()`**](#paginate_links)
    - [**`previous_posts_link()` and `next_posts_link()`**](#previous_posts_link-and-next_posts_link)
  - [**Practical Examples**](#practical-examples)
    - [**Example 1: Paginating a Custom Post Type Archive**](#example-1-paginating-a-custom-post-type-archive)
    - [**Example 2: Paginating Posts Filtered by Category**](#example-2-paginating-posts-filtered-by-category)
  - [**Handling Pagination on Custom Page Templates**](#handling-pagination-on-custom-page-templates)
    - [**Retrieve the Correct Page Number**](#retrieve-the-correct-page-number)
    - [**Ensure Pagination Links Point to the Correct URL**](#ensure-pagination-links-point-to-the-correct-url)
  - [**Common Pitfalls and How to Avoid Them**](#common-pitfalls-and-how-to-avoid-them)
  - [**Best Practices**](#best-practices)
  - [**Conclusion**](#conclusion)
  - [**Further Resources**](#further-resources)

---

## **Understanding Pagination in WordPress**

In WordPress, pagination allows users to navigate through paginated content, typically using links like "Previous" and "Next" or page numbers. The main query automatically handles pagination based on the **`posts_per_page`** setting and the **`paged`** query variable.

**Key Concepts:**

- **`posts_per_page`**: The number of posts displayed per page.
- **`paged`**: The current page number.

When dealing with custom queries, you must manually manage these parameters to ensure pagination works correctly.

---

## **Why Custom Queries Need Special Pagination Handling**

When you create a custom query using `WP_Query`, the query operates independently of the main query. Therefore:

- **Custom Query Pagination**: The custom query does not automatically receive the global pagination variables.
- **URL Parameter**: The **`paged`** parameter needs to be correctly retrieved from the URL to know which page to display.
- **Pagination Functions**: Functions like `paginate_links()` and `previous_posts_link()` need to be used with the custom query.

---

## **Implementing Pagination in Custom Queries**

To implement pagination in custom queries, follow these steps:

### **Step 1: Set Up the Custom Query with Pagination Parameters**

You need to pass the **`paged`** parameter to your custom query to let it know which page of results to display.

**Retrieve the Current Page Number:**

```php
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
```

**Set Up the Custom Query:**

```php
$args = array(
    'post_type'      => 'post', // Change to your custom post type if needed
    'posts_per_page' => 10,     // Number of posts per page
    'paged'          => $paged, // Current page number
    // Add other query parameters as needed
);

$custom_query = new WP_Query( $args );
```

### **Step 2: Display the Posts**

Loop through the posts as usual:

```php
if ( $custom_query->have_posts() ) :
    while ( $custom_query->have_posts() ) : $custom_query->the_post();
        // Display post content
        the_title( '<h2>', '</h2>' );
        the_excerpt();
    endwhile;
    wp_reset_postdata();
else :
    echo '<p>No posts found.</p>';
endif;
```

### **Step 3: Add Pagination Links**

Use pagination functions to display pagination links based on your custom query.

**Using `paginate_links()`:**

```php
$pagination_args = array(
    'total'        => $custom_query->max_num_pages,
    'current'      => $paged,
    'prev_text'    => __('« Previous'),
    'next_text'    => __('Next »'),
);

echo paginate_links( $pagination_args );
```

**Using `previous_posts_link()` and `next_posts_link()`:**

```php
previous_posts_link( '« Newer Posts', $custom_query->max_num_pages );
next_posts_link( 'Older Posts »', $custom_query->max_num_pages );
```

---

## **Pagination Functions**

### **`paginate_links()`**

Generates pagination links with page numbers.

**Parameters:**

- **`total`**: The total number of pages (usually `$custom_query->max_num_pages`).
- **`current`**: The current page number.
- **`prev_text`**: Text for the "Previous" link.
- **`next_text`**: Text for the "Next" link.
- **`base`** and **`format`**: Controls the structure of the pagination URLs. These are automatically handled in most cases.

**Example Usage:**

```php
$pagination = paginate_links( array(
    'total'   => $custom_query->max_num_pages,
    'current' => $paged,
) );

if ( $pagination ) {
    echo '<div class="pagination">' . $pagination . '</div>';
}
```

### **`previous_posts_link()` and `next_posts_link()`**

Display "Previous" and "Next" links for pagination.

**Parameters:**

- **`$label`**: The text displayed for the link.
- **`$max_page`**: The maximum number of pages (usually `$custom_query->max_num_pages`).

**Example Usage:**

```php
if ( get_previous_posts_link() ) {
    previous_posts_link( '« Previous', $custom_query->max_num_pages );
}

if ( get_next_posts_link() ) {
    next_posts_link( 'Next »', $custom_query->max_num_pages );
}
```

---

## **Practical Examples**

### **Example 1: Paginating a Custom Post Type Archive**

**Scenario:**

You have a custom post type called 'portfolio', and you want to display 6 items per page with pagination.

**Code:**

```php
<?php
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$args = array(
    'post_type'      => 'portfolio',
    'posts_per_page' => 6,
    'paged'          => $paged,
);

$portfolio_query = new WP_Query( $args );

if ( $portfolio_query->have_posts() ) :
    echo '<div class="portfolio-items">';
    while ( $portfolio_query->have_posts() ) : $portfolio_query->the_post();
        // Display portfolio item
        echo '<div class="portfolio-item">';
        the_title( '<h2>', '</h2>' );
        the_excerpt();
        echo '</div>';
    endwhile;
    echo '</div>';

    // Pagination
    $pagination = paginate_links( array(
        'total'   => $portfolio_query->max_num_pages,
        'current' => $paged,
    ) );

    if ( $pagination ) {
        echo '<div class="pagination">' . $pagination . '</div>';
    }

    wp_reset_postdata();
else :
    echo '<p>No portfolio items found.</p>';
endif;
?>
```

### **Example 2: Paginating Posts Filtered by Category**

**Scenario:**

Display posts from the 'news' category, 5 per page, with pagination.

**Code:**

```php
<?php
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$args = array(
    'category_name'  => 'news',
    'posts_per_page' => 5,
    'paged'          => $paged,
);

$news_query = new WP_Query( $args );

if ( $news_query->have_posts() ) :
    while ( $news_query->have_posts() ) : $news_query->the_post();
        // Display post content
        the_title( '<h2>', '</h2>' );
        the_excerpt();
    endwhile;

    // Pagination
    $pagination = paginate_links( array(
        'total'   => $news_query->max_num_pages,
        'current' => $paged,
    ) );

    if ( $pagination ) {
        echo '<div class="pagination">' . $pagination . '</div>';
    }

    wp_reset_postdata();
else :
    echo '<p>No news posts found.</p>';
endif;
?>
```

---

## **Handling Pagination on Custom Page Templates**

When using custom page templates, you need to ensure the **`paged`** parameter is correctly retrieved and that pagination links generate the appropriate URLs.

### **Retrieve the Correct Page Number**

When using a custom page, you might need to use **`page`** instead of **`paged`**.

**Retrieve the Current Page Number:**

```php
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
```

If the above doesn't work, try:

```php
$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
```

Or combine both:

```php
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$paged = ( get_query_var('page') ) ? get_query_var('page') : $paged;
```

### **Ensure Pagination Links Point to the Correct URL**

When using pagination on a page (e.g., `yoursite.com/your-page/`), you need to modify the base of the pagination links.

**Example:**

```php
$big = 999999999; // need an unlikely integer

$pagination = paginate_links( array(
    'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format'    => '?paged=%#%',
    'current'   => max( 1, $paged ),
    'total'     => $custom_query->max_num_pages,
) );

if ( $pagination ) {
    echo '<div class="pagination">' . $pagination . '</div>';
}
```

---

## **Common Pitfalls and How to Avoid Them**

1. **Not Passing the 'paged' Parameter:**

   - **Issue:** The custom query always shows the first page of results.
   - **Solution:** Ensure you pass the correct **`paged`** parameter to your query.

2. **Incorrect Retrieval of Page Number:**

   - **Issue:** Pagination links don't work or lead to incorrect pages.
   - **Solution:** Use `get_query_var('paged')` and, if necessary, `get_query_var('page')`.

3. **Forgetting to Reset Post Data:**

   - **Issue:** Global variables remain altered, causing issues with other loops or functions.
   - **Solution:** Use `wp_reset_postdata()` after your custom loop.

4. **Pagination Links Not Displaying Correctly:**

   - **Issue:** Pagination links are missing or incorrect.
   - **Solution:** Ensure you use the correct pagination functions and pass the necessary arguments.

5. **Custom Permalinks Affecting Pagination:**

   - **Issue:** Custom permalink structures may interfere with pagination.
   - **Solution:** Test pagination thoroughly when using custom permalinks and adjust the **`base`** and **`format`** parameters in `paginate_links()` as needed.

---

## **Best Practices**

- **Use `WP_Query` for Custom Queries:**

  - Provides flexibility and control over query parameters.

- **Always Pass the 'paged' Parameter:**

  - Ensures the query retrieves the correct set of posts for the current page.

- **Use `max_num_pages`:**

  - Use `$custom_query->max_num_pages` to determine the total number of pages.

- **Reset Post Data:**

  - Use `wp_reset_postdata()` after your custom loop to restore global variables.

- **Sanitize Output:**

  - Always sanitize and escape output to enhance security.

- **Test Pagination Thoroughly:**

  - Ensure that pagination works correctly across different pages and scenarios.

- **Use Consistent Naming:**

  - Use clear variable names (e.g., `$custom_query`, `$paged`) for readability.

---

## **Conclusion**

Implementing pagination in custom queries is crucial for displaying large amounts of content in a user-friendly manner. By carefully setting up your custom query with the correct parameters and using the appropriate pagination functions, you can provide seamless navigation through your content.

Remember to handle edge cases, test thoroughly, and follow best practices to ensure your pagination works correctly and enhances the user experience on your WordPress site.

---

## **Further Resources**

- **WordPress Developer Resources:**

  - [Class Reference: WP_Query](https://developer.wordpress.org/reference/classes/wp_query/)
  - [Function Reference: paginate_links()](https://developer.wordpress.org/reference/functions/paginate_links/)
  - [Function Reference: get_query_var()](https://developer.wordpress.org/reference/functions/get_query_var/)
  - [Pagination in WordPress](https://codex.wordpress.org/Pagination)

- **Tutorials and Guides:**

  - [Custom Query Pagination with WP_Query](https://developer.wordpress.org/themes/basics/pagination/#custom-query-with-pagination)
  - [Pagination for Custom Loops in WordPress](https://premium.wpmudev.org/blog/pagination-for-custom-loops-in-wordpress/)
  - [How to Fix Pagination for Custom Post Types in WordPress](https://www.wpbeginner.com/wp-tutorials/how-to-fix-wordpress-pagination-for-custom-post-types/)

- **Plugins for Advanced Pagination:**

  - [WP-PageNavi](https://wordpress.org/plugins/wp-pagenavi/) – Adds more advanced pagination controls.

---
