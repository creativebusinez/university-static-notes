# Functions Used in the course

```php
// Fetches the parent post ID of the current post or page 
$theParent = wp_get_post_parent_id(get_the_ID());

// Checks if the fetched post or page does have a parent
if ($theParent) {
   // If the post or page has a parent, this block will execute
   
}

```

In detail:

`$theParent = wp_get_post_parent_id(get_the_ID())`: This line first retrieves the current post or page ID with `get_the_ID()` and then finds its parent ID using `wp_get_post_parent_id()`. The parent ID is stored in the variable `$theParent`.

`if ($theParent)`: This if statement checks whether `$theParent` (the parent ID) exists. If it does (i.e., the current post or page does have a parent), the code within the curly braces `{}` will be executed.
