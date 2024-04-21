# Manipulating Default Based Queries

Manipulating default URL-based queries in WordPress involves modifying the parameters of the query WordPress automatically generates based on the URL visited. This is typically done to alter the default behavior of archive pages, categories, tag listings, search results, and more, without changing the actual URLs. WordPress provides hooks such as `pre_get_posts` to adjust these queries before they are executed.

## Using `pre_get_posts`

The `pre_get_posts` action hook allows you to alter the main query by accessing the query object before it retrieves posts from the database. This is powerful for customizing query parameters based on conditional tags without writing custom queries, thus maintaining efficiency and speed.

### How It Works

1. **Add Action**: You hook a custom function to `pre_get_posts`.
2. **Modify the Query**: Within your function, you check if the current query is the main query (to avoid affecting custom queries) and whether it meets certain conditions. Then, you set query variables or modify existing ones.

### Example: Modifying Posts Per Page for Categories

To change the number of posts displayed on category archive pages to 5, you might use:

```php
function modify_category_query( $query ) {
    if ( !is_admin() && $query->is_main_query() && $query->is_category() ) {
        $query->set( 'posts_per_page', 5 );
    }
}
add_action( 'pre_get_posts', 'modify_category_query' );
```

### Key Points

- **Check if `is_main_query`**: Ensures you're only modifying the main query and not affecting other queries like widgets or custom loops.
- **Use Conditional Tags**: Functions like `is_category()`, `is_archive()`, or `is_search()` let you specify when and how the query should be modified.
- **The `set` Method**: This method of the query object allows you to alter query variables. In the example, `'posts_per_page'` is changed to `5`.

### Modifying Query Based on Custom Parameters

You can also check for custom parameters passed in the URL to conditionally modify queries. For instance, adding a custom filter through a URL parameter:

```php
function modify_query_based_on_parameter( $query ) {
    if ( !is_admin() && $query->is_main_query() ) {
        // Assume a URL parameter 'custom_filter' is used
        $custom_filter = get_query_var( 'custom_filter', '' );
        if ( !empty($custom_filter) ) {
            // Modify the query based on the custom filter value
            $query->set( 'meta_key', 'custom_meta' );
            $query->set( 'meta_value', $custom_filter );
        }
    }
}
add_action( 'pre_get_posts', 'modify_query_based_on_parameter' );
```

### Modifying Queries Based on Conditional Tags

```php
function university_adjust_queries($query) {

    if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        //$query->set('posts_per_page', '1'); not a real use case, just for pagination test
        $today = date('Ymd');
        $query->set('meta_key', 'event_date'); // Required when ordering by a custom field
        $query->set('orderby', 'meta_value_num'); // Use 'meta_value' for non-numeric fields
        $query->set('order', 'ASC'); // Use 'ASC' or 'DESC'
        $query->set('meta_query', array(// Array of query parameters
            array( // Associative array
                'key' => 'event_date', // Custom field
                'compare' => '>=', // Operator
                'value' => $today,
                'type' => 'numeric' // 'numeric' or 'date'
            )
        ));
    }
}

add_action('pre_get_posts', 'university_adjust_queries');
```

### Conclusion

Manipulating default URL-based queries using hooks like `pre_get_posts` is a powerful feature in WordPress. It enables developers to customize how content is queried and displayed based on different contexts or custom conditions, enhancing the site's flexibility and user experience. This approach is efficient because it leverages the built-in query system, avoiding the overhead of additional queries. Always ensure your modifications are conditional to avoid unintended effects on the admin side or other queries.
