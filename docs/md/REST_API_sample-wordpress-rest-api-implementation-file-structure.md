# Sample WordPress REST API Implementation File Structure

Here is a sample file structure for implementing a custom REST API route in WordPress. This structure assumes you are adding the custom API routes in a custom plugin, but similar principles can be applied within a theme.

## File Structure

```txt
/wp-content/
    /plugins/
        /my-custom-api/
            my-custom-api.php
            /includes/
                class-my-custom-api-controller.php
                class-my-custom-api-endpoints.php
                /helpers/
                    helper-functions.php
```

### Explanation of Each File

1. **`/wp-content/plugins/my-custom-api/my-custom-api.php`**
   This is the main plugin file. It initializes the plugin and includes necessary files.

    ```php
    <?php
    /**
     * Plugin Name: My Custom API
     * Description: Adds custom REST API routes to WordPress.
     * Version: 1.0
     * Author: Your Name
     */

    // Prevent direct access
    if (!defined('ABSPATH')) {
        exit;
    }

    // Include necessary files
    require_once plugin_dir_path(__FILE__) . 'includes/class-my-custom-api-controller.php';
    require_once plugin_dir_path(__FILE__) . 'includes/class-my-custom-api-endpoints.php';

    // Initialize the API
    add_action('rest_api_init', ['My_Custom_API_Controller', 'register_routes']);
    ```

2. **`/wp-content/plugins/my-custom-api/includes/class-my-custom-api-controller.php`**  
   This file contains the main class that handles the registration of custom API routes.

    ```php
    <?php

    if (!defined('ABSPATH')) {
        exit;
    }

    class My_Custom_API_Controller {

        public static function register_routes() {
            register_rest_route('my-namespace/v1', '/my-endpoint/', [
                'methods' => 'GET',
                'callback' => ['My_Custom_API_Endpoints', 'handle_get_request'],
                'permission_callback' => '__return_true', // Example: allow all users
            ]);
        }
    }
    ```

3. **`/wp-content/plugins/my-custom-api/includes/class-my-custom-api-endpoints.php`**
   This file contains the logic for handling the requests made to your custom endpoints.

    ```php
    <?php

    if (!defined('ABSPATH')) {
        exit;
    }

    class My_Custom_API_Endpoints {

        public static function handle_get_request(WP_REST_Request $request) {
            // Example response data
            $data = [
                'message' => 'Hello, this is a custom endpoint!',
                'status' => 'success'
            ];

            return new WP_REST_Response($data, 200);
        }

        // You can add more methods for handling POST, PUT, DELETE requests, etc.
    }
    ```

4. **`/wp-content/plugins/my-custom-api/includes/helpers/helper-functions.php`**  
   This file can contain any helper functions that you might need across your plugin. It's optional but useful for organizing reusable code.

    ```php
    <?php

    if (!defined('ABSPATH')) {
        exit;
    }

    // Example helper function
    function my_custom_api_format_response($data) {
        return [
            'data' => $data,
            'status' => 'success',
            'timestamp' => current_time('Y-m-d H:i:s'),
        ];
    }
    ```

### Summary of Workflow

1. **Main Plugin File**: Initializes the plugin and hooks into `rest_api_init` to register custom routes.
2. **Controller Class**: Handles the registration of custom routes and defines the callback functions for each route.
3. **Endpoints Class**: Contains the logic for processing API requests and returning responses.
4. **Helper Functions**: Contains reusable functions that can be used across the plugin.

This modular structure keeps your code organized, making it easier to manage and extend as needed.
