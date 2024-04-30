# Solution To "Undefined array key" Warnings

Solution To "Undefined array key" Warnings
Hello everyone,

I want to explain how to fix the PHP warning messages that we're seeing on our website after we just created our pageBanner function. Before we look at the solution, let's first understand what the problem is.

Essentially, in older versions of PHP, while it wasn't a good idea to check the value of an array item that might not exist PHP would still let us do it. However, in modern versions of PHP you cannot try to access an array item that doesn't exist; if you do you will receive a warning message.

So, how can we safely write an IF statement where we want to do one thing if a variable is set, but do an entirely different thing if that variable isn't set? Simple, we can use a function in PHP called isset()

So, to fix our warnings we'd go into our theme's functions.php file and start adjusting our pageBanner function.

Instead of:

```php
if (!$args['title']) {
    $args['title'] = get_the_title();
  }
```

We'd now have:

```php
if (!isset($args['title'])) {
    $args['title'] = get_the_title();
  }
```

The difference is that we're not directly trying to access an array item if it doesn't exist, we're using the specifically designed isset tool in PHP to check if it exists or not. This will fix our warning issue.

Instead of:

```php
if (!$args['subtitle']) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
```

We'd now have:

```php
if (!isset($args['subtitle'])) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
```

Instead of:

```php
if (!$args['photo']) {
    if (get_field('page_banner_background_image')) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }
```

We'd now have:

```php
if (!isset($args['photo'])) {
    if (get_field('page_banner_background_image')) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }
```

This is a very common issue you'll run into on a variety of PHP projects and it's great to be able to identify the problem and know how to implement the fix.
