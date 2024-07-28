# Using an `.env` File in a WordPress Theme

Using an `.env` file to manage environment variables, including API keys, is a good practice for securing sensitive data. Here's how to implement it in a WordPress theme:

## Step 1: Install PHP dotenv Library

First, you need to install the `vlucas/phpdotenv` library using Composer. If you don't have Composer installed, you can get it from [getcomposer.org](https://getcomposer.org/).

1. Navigate to your WordPress theme directory in the terminal:
   ```sh
   cd /path/to/your/wordpress/wp-content/themes/your-theme
   ```

2. Run the following command to install `vlucas/phpdotenv`:
   ```sh
   composer require vlucas/phpdotenv
   ```

## Step 2: Create the `.env` File

Create a `.env` file in the root directory of your WordPress theme and add your API key:

```plaintext
GOOGLE_MAP_API_KEY=yourKeyGoesHere
```

## Step 3: Add `.env` to `.gitignore`

To ensure that your `.env` file is not tracked by Git, add the following line to your `.gitignore` file:

```plaintext
/wp-content/themes/your-theme/.env
```

## Step 4: Update Your Theme's `functions.php` File

Modify your theme's `functions.php` file to load the `.env` file and use the environment variables:

1. Open your theme's `functions.php` file, typically located at `wp-content/themes/your-theme/functions.php`.
2. Add the following code to load the `.env` file and use the environment variables:

```php
<?php
// Load the Composer autoload file
require_once __DIR__ . '/vendor/autoload.php';

// Load the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function universityMapKey($api) {
    // Use the environment variable
    $api['key'] = $_ENV['GOOGLE_MAP_API_KEY'];
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');
```

## File Structure

Here is what your file structure should look like:

```
/your-wordpress-installation
    /wp-content
        /themes
            /your-theme
                .env
                config.php
                functions.php
                /vendor
                    /autoload.php
    .gitignore
```

## Explanation

1. **Define the API Key**: The `.env` file in the root directory of your theme contains the API key as an environment variable.
2. **Ignore the .env File**: The `.gitignore` entry ensures that the `.env` file is not tracked by version control.
3. **Load the .env File**: The `Dotenv\Dotenv::createImmutable` function loads the `.env` file, making the environment variables available.
4. **Use the API Key**: The `universityMapKey` function sets the `key` in the `$api` array to the value of the `GOOGLE_MAP_API_KEY` environment variable.

By following these steps, you can securely manage your API keys using an `.env` file in a WordPress theme.
