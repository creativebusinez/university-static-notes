# WordPress Theme Structure

wordpress-project/
├── wp-content/                   # Custom content directory
│   ├── themes/                   # Themes directory
│   │   └── your-theme/           # Your custom theme
│   │       ├── assets/           # CSS, JavaScript, images, fonts
│   │       │   ├── css/
│   │       │   ├── js/
│   │       │   ├── images/
│   │       │   └── fonts/
│   │       ├── inc/              # PHP includes - functions, setups, hooks
│   │       ├── languages/        # Language files
│   │       ├── template-parts/   # Theme partials
│   │       ├── front-page.php    # Front page template
│   │       ├── functions.php     # Theme functions
│   │       ├── index.php         # Main template file
│   │       ├── page.php          # Single page template for individual pages
│   │       ├── single.php        # Single post template for individual posts
│   │       ├── style.css         # Main stylesheet with theme info
│   │       └── screenshot.png    # Theme screenshot
│   └── plugins/                  # Custom or developed plugins
│       └── your-plugin/          # Your custom plugin
│           ├── your-plugin.php   # Main plugin file
│           └── ...               # Other plugin directories and files
└── wp-config.php                 # Main configuration file

## WordPress Project Structure Overview

- **`wp-content/`**: This directory is where all your custom content lives, separate from the core WordPress files. It includes themes, plugins, and uploads.

  - **`themes/`**: The themes directory houses one or more themes available for your WordPress site. Each theme has its own directory within here.
  
    - **`your-theme/`**: This is your custom theme's directory. The name of the directory is typically the theme's slug.

      - **`assets/`**: Contains all static resources like CSS, JavaScript, images, and fonts. These are essential for the styling and functionality of your theme.
        - **`css/`**: Houses CSS files.
        - **`js/`**: Contains JavaScript files.
        - **`images/`**: Stores image files used in your theme.
        - **`fonts/`**: Holds font files.

      - **`inc/`**: Used for PHP includes such as theme functions, setups, hooks, and custom functionality snippets. It helps keep your `functions.php` cleaner and more organized.

      - **`languages/`**: Contains translation files (.pot, .po, .mo) for making the theme multilingual and accessible to a global audience.

      - **`template-parts/`**: Holds partial template files, like headers, footers, and other reusable sections. This promotes DRY (Don't Repeat Yourself) principles in theme development.

      - **`front-page.php`**: The template file used for the front page of your site if “A static page” is selected in the Reading Settings.

      - **`functions.php`**: A powerful file that acts as a plugin and is used to add features and extend the functionality of WordPress and your theme.

      - **`index.php`**: The main fallback template file; WordPress will use this if it doesn't find any more specific template files for the requested page.

      - **`page.php`**: The template used for individual pages.

      - **`single.php`**: The template used for individual posts.

      - **`style.css`**: The main stylesheet file. It also contains the header section that defines the theme name, version, author, and other details.

      - **`screenshot.png`**: A preview image of the theme that is shown in the WordPress admin theme selection interface.

  - **`plugins/`**: This directory holds all the plugins installed on your WordPress site. Plugins extend the functionality of WordPress.

    - **`your-plugin/`**: An example directory for a custom plugin you might develop.

      - **`your-plugin.php`**: The main file of your custom plugin, which includes the plugin header information and foundational code.

- **`wp-config.php`**: This is the main WordPress configuration file. It includes database connection details, secret keys, WordPress database table prefix, and other settings.

This structure represents a well-organized approach to theme and plugin development in WordPress, ensuring that your projects are maintainable and scalable.
