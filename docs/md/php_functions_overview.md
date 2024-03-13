# PHP Functions

PHP functions are blocks of code designed to perform specific tasks in a PHP script. They are used to encapsulate code that performs a single action or a related group of actions, making your PHP code more organized, reusable, and readable. Functions can reduce code duplication, as you can call the same function multiple times with different parameters instead of writing the same code over and over.

## Basic Structure

The basic syntax for declaring a function in PHP is as follows:

```php
function functionName($parameter1, $parameter2, ...) {
    // Code to be executed
}
```

- `function`: The keyword used to define a function.
- `functionName`: The name of the function. It should be descriptive and follow PHP's naming conventions.
- `$parameter1, $parameter2, ...`: Optional parameters (or arguments) that the function can accept. Functions can also be defined without parameters.

### Calling a Function

To execute a function, you call it by its name followed by parentheses. If the function requires parameters, you pass them inside the parentheses:

```php
functionName($argument1, $argument2, ...);
```

### Returning Values

Functions can return values back to the calling code using the `return` statement. Once `return` is executed, the function ends, and the specified value is returned to the caller:

```php
function add($num1, $num2) {
    $sum = $num1 + $num2;
    return $sum;
}

$result = add(5, 10); // Calls the function and stores the return value in $result
```

### Scope

Variables declared inside a function are local to that function and cannot be accessed outside of it. To access a variable from the global scope within a function, you must use the `global` keyword or the `$GLOBALS` array:

```php
$x = 5;

function myTest() {
    global $x;
    echo $x;
}

myTest(); // Outputs 5
```

### Default Parameter Values

You can specify default values for function parameters. If a caller does not provide an argument, the default value is used:

```php
function greet($name = "World") {
    echo "Hello, $name!";
}

greet(); // Outputs "Hello, World!"
greet("John"); // Outputs "Hello, John!"
```

### Variable Functions and Anonymous Functions

PHP supports variable functions (functions assigned to variables) and anonymous functions (functions without a name, often used as callback functions):

```php
// Variable function
$myFunc = function($name) {
    echo "Hello, $name!";
};
$myFunc("Jane");

// Anonymous function
array_walk($array, function($value) {
    echo $value;
});
```

Functions are a fundamental part of PHP, enabling you to write more modular, maintainable, and efficient code.
