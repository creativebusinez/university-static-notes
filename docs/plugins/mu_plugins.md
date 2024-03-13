# Must Use Plugins Folder

This `mu_plugins` folder contains the plugins that are used in the theme. It must be created in your site's C:\Local Sites\YourSite\app\public\wp-content folder.

The "Must Use" plugins folder in WordPress, commonly referred to as the `mu-plugins` directory, is a special location within the WordPress file structure designed for storing plugins that you want to be automatically activated and cannot be disabled through the WordPress admin dashboard. This feature provides a powerful way to ensure essential functionality is always active and available across the site, regardless of changes to themes or other plugins.

## Key Characteristics of MU-Plugins

1. **Auto-Activation**: Plugins placed in the `mu-plugins` directory are automatically activated by WordPress. There's no need to manually activate them through the admin interface.

2. **Hidden from the Plugins Menu**: MU-plugins do not appear in the WordPress admin's Plugins menu. Therefore, they cannot be deactivated from the WordPress dashboard.

3. **Ideal for Critical Functionality**: This feature is particularly useful for functionality that must remain active, such as customizations critical to a site's operation, security enhancements, or network-wide features on a multisite installation.

### How to Use MU-Plugins

1. **Location**: The `mu-plugins` folder is located in `wp-content/mu-plugins`. If it doesn’t exist, you can manually create it.

2. **Installation**: Simply drop your plugin files (or directories) into the `mu-plugins` folder. Note that unlike regular plugins, MU-plugins loaded directly from this directory must be single PHP files. If your MU-plugin is structured as a directory with an initializer file, you will need to manually include it from a single PHP file placed directly in the `mu-plugins` directory.

3. **Loading Subdirectories**: If your MU-plugin includes multiple files organized in a subdirectory, you need to create a PHP loader file in the `mu-plugins` root that includes or requires the necessary files from the subdirectory.

### Example of a Loader File

```php
<?php
// my-mu-plugin-loader.php in wp-content/mu-plugins

require WPMU_PLUGIN_DIR.'/my-mu-plugin/my-mu-plugin.php';
```

This loader file ensures that `my-mu-plugin.php` (which resides in a subdirectory) is executed.

### Considerations

- **Updates**: MU-plugins do not automatically receive updates like standard WordPress plugins from the WordPress repository. Updates must be managed manually.

- **Use Sparingly**: Given their auto-activation and invisibility in the admin dashboard, use MU-plugins only for essential functionality to minimize the risk of conflicts and ensure easy site management.

- **Compatibility**: Because MU-plugins are loaded before regular plugins, ensure any dependencies your MU-plugins might have on other plugins are carefully managed.

The `mu-plugins` directory offers a robust solution for ensuring critical functionality remains uninterrupted on a WordPress site, making it a valuable tool for developers and site administrators who need to enforce certain features or customizations.
