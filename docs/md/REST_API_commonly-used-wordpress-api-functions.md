# Commonly Used WordPress API Functions

Here’s a list of commonly used WordPress REST API functions:

## 1. **`register_rest_route()`**

- Registers a new REST API route.
- Example: `register_rest_route( 'namespace/v1', '/route/', array( 'methods' => 'GET', 'callback' => 'function_name' ) );`

## 2. **`register_rest_field()`**

- Registers a new field on a REST API response object (e.g., adding custom fields to posts).
- Example: `register_rest_field( 'post', 'custom_field', array( 'get_callback' => 'get_custom_field_value', 'update_callback' => 'update_custom_field_value' ) );`

## 3. **`rest_ensure_response()`**

- Ensures that a value is a valid `WP_REST_Response` object.
- Example: `return rest_ensure_response( $data );`

## 4. **`rest_request_before_callbacks`**

- Filter that fires before any callbacks are executed.
- Example: `add_filter( 'rest_request_before_callbacks', 'my_custom_function', 10, 3 );`

## 5. **`rest_request_after_callbacks`**

- Filter that fires after callbacks have been executed.
- Example: `add_filter( 'rest_request_after_callbacks', 'my_custom_function', 10, 3 );`

## 6. **`rest_prepare_*`**

- Filters the response data before returning it to the client. Replace `*` with the name of the object type (e.g., `post`, `user`).
- Example: `add_filter( 'rest_prepare_post', 'modify_post_response', 10, 3 );`

## 7. **`rest_url()`**

- Retrieves the URL to a REST endpoint.
- Example: `rest_url( '/wp/v2/posts' );`

## 8. **`register_rest_controller()`**

- Registers a custom REST API controller class.
- Example: `register_rest_controller( new My_Custom_Controller() );`

### 9. **`WP_REST_Controller`**

- Base class for creating custom REST API controllers.
- Example: `class My_Custom_Controller extends WP_REST_Controller { /* methods here */ }`

## 10. **`WP_REST_Request`**

- Represents a REST API request.
- Example: `$param = $request->get_param('param_name');`

### 11. **`WP_REST_Response`**

- Represents a REST API response.
- Example: `return new WP_REST_Response( $data, 200 );`

## 12. **`rest_validate_request_arg()`**

- Validates an argument passed to an endpoint.
- Example: `rest_validate_request_arg( $value, $request, 'param_name' );`

## 13. **`rest_parse_request_arg()`**

- Parses and prepares an argument for use.
- Example: `$parsed_arg = rest_parse_request_arg( $arg_value, $request, 'param_name' );`

## 14. **`rest_get_server()`**

- Retrieves the REST API server instance.
- Example: `$server = rest_get_server();`

## 15. **`is_rest_request()`**

- Determines if the current request is a REST API request.
- Example: `if ( is_rest_request() ) { /* do something */ }`

These functions form the core of interacting with the WordPress REST API, helping developers to register routes, handle requests and responses, and manipulate data.
