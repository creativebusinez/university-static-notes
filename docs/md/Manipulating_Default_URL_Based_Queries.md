# **Manipulating Default URL-Based Queries in WordPress**

WordPress processes URLs to determine what content to display by translating the URL into a query that fetches data from the database. Sometimes, you may need to manipulate these default queries to customize the content displayed based on specific conditions or URL parameters.

This guide will explain how WordPress handles URL-based queries, how to manipulate them using hooks like `pre_get_posts`, how to add custom query variables, and how to modify the URL structures using the Rewrite API.

---

## **Table of Contents**

- [**Manipulating Default URL-Based Queries in WordPress**](#manipulating-default-url-based-queries-in-wordpress)
  - [**Table of Contents**](#table-of-contents)
  - [**Understanding WordPress Query Processing**](#understanding-wordpress-query-processing)
  - [**Modifying the Main Query with `pre_get_posts`**](#modifying-the-main-query-with-pre_get_posts)
    - [**Basic Usage**](#basic-usage)
    - [**Conditional Modifications**](#conditional-modifications)
  - [**Adding Custom Query Variables**](#adding-custom-query-variables)
    - [**Registering Custom Query Vars**](#registering-custom-query-vars)
    - [**Using Custom Query Vars in Queries**](#using-custom-query-vars-in-queries)
  - [**Modifying Queries Based on URL Parameters**](#modifying-queries-based-on-url-parameters)
    - [**Example: Filtering Posts by Custom Field via URL**](#example-filtering-posts-by-custom-field-via-url)
  - [**Customizing URL Structures with the Rewrite API**](#customizing-url-structures-with-the-rewrite-api)
    - [**Adding Custom Rewrite Rules**](#adding-custom-rewrite-rules)
    - [**Example: Creating Custom Permalinks**](#example-creating-custom-permalinks)
  - [**Best Practices and Considerations**](#best-practices-and-considerations)
  - [**Conclusion**](#conclusion)
  - [**Further Resources**](#further-resources)

---

## **Understanding WordPress Query Processing**

When a user visits a WordPress site, the URL they access is processed to determine what content to display. This involves several steps:

1. **Parsing the URL**: WordPress examines the URL to identify query variables (e.g., post ID, category slug).
2. **Generating the Query**: Based on the query variables, WordPress constructs a database query to retrieve the appropriate content.
3. **Running the Query**: The query is executed, and the results are stored in the `$wp_query` global variable.
4. **Loading the Template**: WordPress uses the template hierarchy to load the appropriate template file for displaying the content.

**Example URLs and Queries:**

- **Homepage** (`https://example.com/`): Displays the latest posts.
- **Category Archive** (`https://example.com/category/news/`): Displays posts in the 'news' category.
- **Single Post** (`https://example.com/2023/09/15/sample-post/`): Displays a single post.

**Understanding the Query Variables:**

- **Query Vars**: Variables used to construct the query (e.g., `p`, `cat`, `author`, `s` for search terms).
- **Rewrite Rules**: Patterns that translate pretty URLs into query vars.

---

## **Modifying the Main Query with `pre_get_posts`**

The `pre_get_posts` action hook allows you to modify the main query before it runs. This is the preferred method for altering queries based on URL parameters.

### **Basic Usage**

**Syntax:**

```php
add_action( 'pre_get_posts', 'my_custom_query_modification' );

function my_custom_query_modification( $query ) {
    // Modify the query
}
```

**Important Considerations:**

- **Check if it's the main query**: Use `$query->is_main_query()`.
- **Check the context**: Use conditional tags like `is_home()`, `is_archive()`, `is_search()`, etc.
- **Avoid affecting admin queries**: Use `! is_admin()`.

### **Conditional Modifications**

**Example: Modify the number of posts displayed on the main blog page:**

```php
add_action( 'pre_get_posts', 'modify_main_blog_query' );

function modify_main_blog_query( $query ) {
    if ( $query->is_main_query() && ! is_admin() && $query->is_home() ) {
        $query->set( 'posts_per_page', 12 );
    }
}
```

**Explanation:**

- **`$query->is_main_query()`**: Ensures we're modifying the main query, not a secondary one.
- **`! is_admin()`**: Ensures the modification applies only to front-end queries.
- **`$query->is_home()`**: Targets the main blog page.
- **`$query->set( 'posts_per_page', 12 )`**: Changes the number of posts per page.

---

## **Adding Custom Query Variables**

To manipulate queries using custom URL parameters, you need to register custom query variables.

### **Registering Custom Query Vars**

Use the `query_vars` filter to add custom query variables.

**Example: Adding a custom 'rating' query variable:**

```php
add_filter( 'query_vars', 'add_custom_query_vars' );

function add_custom_query_vars( $vars ) {
    $vars[] = 'rating';
    return $vars;
}
```

### **Using Custom Query Vars in Queries**

Now you can access the 'rating' variable via `$wp_query->get( 'rating' )` or `get_query_var( 'rating' )`.

**Example: Modifying the main query based on 'rating' parameter:**

```php
add_action( 'pre_get_posts', 'filter_posts_by_rating' );

function filter_posts_by_rating( $query ) {
    if ( $query->is_main_query() && ! is_admin() && $query->get( 'rating' ) ) {
        $meta_query = array(
            array(
                'key'     => 'rating',
                'value'   => $query->get( 'rating' ),
                'compare' => '=',
            ),
        );
        $query->set( 'meta_query', $meta_query );
    }
}
```

**Explanation:**

- **`$query->get( 'rating' )`**: Retrieves the 'rating' query variable from the URL.
- **`$meta_query`**: Adds a meta query to filter posts by the 'rating' custom field.
- **`$query->set( 'meta_query', $meta_query )`**: Applies the meta query to the main query.

---

## **Modifying Queries Based on URL Parameters**

You can manipulate the default queries based on URL parameters, including both default and custom query variables.

### **Example: Filtering Posts by Custom Field via URL**

**Scenario:**

- You have a custom field 'color' for products.
- You want users to filter products by color using a URL parameter (e.g., `?color=red`).

**Step 1: Register the 'color' Query Var**

```php
add_filter( 'query_vars', 'add_color_query_var' );

function add_color_query_var( $vars ) {
    $vars[] = 'color';
    return $vars;
}
```

**Step 2: Modify the Query in `pre_get_posts`**

```php
add_action( 'pre_get_posts', 'filter_products_by_color' );

function filter_products_by_color( $query ) {
    if ( $query->is_main_query() && ! is_admin() && is_post_type_archive( 'product' ) && get_query_var( 'color' ) ) {
        $meta_query = array(
            array(
                'key'     => 'color',
                'value'   => sanitize_text_field( get_query_var( 'color' ) ),
                'compare' => '=',
            ),
        );
        $query->set( 'meta_query', $meta_query );
    }
}
```

**Explanation:**

- **`is_post_type_archive( 'product' )`**: Ensures the filter applies only to the 'product' post type archive.
- **`sanitize_text_field( get_query_var( 'color' ) )`**: Sanitizes the 'color' query variable.
- **Access URL**: `https://example.com/products/?color=red`

**Step 3: Update Rewrite Rules (Optional)**

To make the URL prettier (e.g., `https://example.com/products/color/red/`), you need to add rewrite rules.

**Add Rewrite Rule:**

```php
add_action( 'init', 'add_color_rewrite_rule' );

function add_color_rewrite_rule() {
    add_rewrite_rule(
        '^products/color/([^/]*)/?',
        'index.php?post_type=product&color=$matches[1]',
        'top'
    );
}
```

**Flush Rewrite Rules:**

After adding rewrite rules, flush them by visiting **Settings > Permalinks** and clicking **Save Changes**.

---

## **Customizing URL Structures with the Rewrite API**

The WordPress Rewrite API allows you to create custom URL structures by mapping URL patterns to query variables.

### **Adding Custom Rewrite Rules**

**Syntax:**

```php
add_rewrite_rule( $regex, $query, $after );
```

- **`$regex`**: The regular expression to match the URL.
- **`$query`**: The query variables to pass.
- **`$after`**: Position in the rewrite array ('top' or 'bottom').

### **Example: Creating Custom Permalinks**

**Scenario:**

- You have an 'event' custom post type.
- You want event URLs to be structured as `https://example.com/events/2023/conference-name/`.

**Step 1: Modify the 'event' Post Type Rewrite**

When registering the 'event' post type, set the 'rewrite' parameter.

```php
register_post_type( 'event', array(
    'rewrite' => array(
        'slug'       => 'events/%year%',
        'with_front' => false,
    ),
    // ... other arguments
) );
```

**Step 2: Add Rewrite Tags**

```php
add_action( 'init', 'add_event_rewrite_tags' );

function add_event_rewrite_tags() {
    add_rewrite_tag( '%year%', '([0-9]{4})' );
}
```

**Step 3: Add Custom Rewrite Rules**

```php
add_action( 'init', 'add_event_rewrite_rules' );

function add_event_rewrite_rules() {
    add_rewrite_rule(
        '^events/([0-9]{4})/([^/]+)/?$',
        'index.php?post_type=event&name=$matches[2]',
        'top'
    );
}
```

**Step 4: Modify Permalink Structure**

Filter the permalink to replace '%year%' with the actual year.

```php
add_filter( 'post_type_link', 'event_permalink', 10, 2 );

function event_permalink( $post_link, $post ) {
    if ( $post->post_type == 'event' ) {
        $year = get_post_meta( $post->ID, 'event_year', true );
        if ( $year ) {
            $post_link = str_replace( '%year%', $year, $post_link );
        }
    }
    return $post_link;
}
```

**Explanation:**

- **`add_rewrite_tag()`**: Adds '%year%' as a rewrite tag.
- **`add_rewrite_rule()`**: Creates a custom rewrite rule to match the URL structure.
- **`post_type_link` Filter**: Modifies the permalink to include the event year.

**Step 5: Flush Rewrite Rules**

- Visit **Settings > Permalinks** and click **Save Changes**.

---

## **Best Practices and Considerations**

1. **Always Check the Main Query**: Use `$query->is_main_query()` in `pre_get_posts` to avoid unintended modifications.

2. **Avoid Affecting Admin Queries**: Use `! is_admin()` to ensure your changes apply only to front-end queries.

3. **Sanitize Input**: Always sanitize query variables using appropriate functions (e.g., `sanitize_text_field()`, `intval()`).

4. **Flush Rewrite Rules Carefully**:

   - **When to Flush**: After adding or modifying rewrite rules.
   - **How to Flush**: Visit **Settings > Permalinks** and click **Save Changes**.
   - **Avoid Flushing on Every Page Load**: Do not call `flush_rewrite_rules()` in functions hooked to actions that run on every page load; it can degrade performance.

5. **Use Conditional Tags Wisely**: Combine conditional tags (e.g., `is_post_type_archive()`, `is_tax()`, `is_search()`) to target specific queries.

6. **Test Thoroughly**: Ensure your modifications do not break existing functionality and that URLs resolve correctly.

7. **Debugging Tools**:

   - Use plugins like **Query Monitor** to inspect queries and debug issues.
   - Enable **WP_DEBUG** in `wp-config.php` during development.

---

## **Conclusion**

Manipulating default URL-based queries in WordPress allows you to customize how content is retrieved and displayed based on URL parameters. By using hooks like `pre_get_posts`, registering custom query variables, and leveraging the Rewrite API, you can create dynamic and user-friendly URLs and tailor queries to your site's specific needs.

Understanding how WordPress processes URLs and queries is essential for advanced theme and plugin development, enabling you to build more flexible and powerful WordPress sites.

---

## **Further Resources**

- **WordPress Developer Resources**:

  - [pre_get_posts Hook](https://developer.wordpress.org/reference/hooks/pre_get_posts/)
  - [WP_Query Class Reference](https://developer.wordpress.org/reference/classes/wp_query/)
  - [Query Vars](https://developer.wordpress.org/reference/hooks/query_vars/)
  - [Rewrite API](https://codex.wordpress.org/Rewrite_API)
  - [Rewrite Tags](https://codex.wordpress.org/Rewrite_API/add_rewrite_tag)
  - [Rewrite Rules](https://codex.wordpress.org/Rewrite_API/add_rewrite_rule)
  - [post_type_link Filter](https://developer.wordpress.org/reference/hooks/post_type_link/)

- **Tutorials and Guides**:

  - [Modifying the Main Query with pre_get_posts](https://developer.wordpress.org/reference/hooks/pre_get_posts/#more-information)
  - [A Guide to Custom WordPress URLs](https://www.smashingmagazine.com/2012/05/developers-guide-wordpress-permalinks/)
  - [Creating Custom URL Rewrites in WordPress](https://premium.wpmudev.org/blog/create-custom-url-rewrites-wordpress/)

- **Plugins**:

  - [Query Monitor](https://wordpress.org/plugins/query-monitor/) – A debugging plugin that helps inspect database queries.

---

By mastering the manipulation of default URL-based queries, you can greatly enhance the functionality and user experience of your WordPress site, providing more relevant content and cleaner URLs tailored to your audience's needs.
