# Using SASS in WordPress Theme Development Guide

Certainly! Incorporating SASS (Syntactically Awesome Style Sheets) into your WordPress theme development workflow can significantly enhance your CSS coding efficiency and maintainability. SASS is a CSS preprocessor that adds powerful features like variables, nested rules, mixins, functions, and more. This guide will walk you through setting up and using SASS in your WordPress theme.

---

## **Prerequisites**

- **Basic Knowledge**: Familiarity with CSS, SASS syntax, and WordPress theme development.
- **Development Environment**: A local WordPress installation.
- **Node.js and npm**: Installed on your machine to manage packages and tools.
- **Task Runner or Bundler**: Tools like Gulp, Grunt, or Webpack (we'll use Gulp in this guide).

---

## **Step-by-Step Guide to Using SASS in a WordPress Theme**

### **Step 1: Set Up Your Theme Directory**

Assuming you already have a WordPress theme set up:

1. **Navigate to Your Theme Folder**:
   - Located at `wp-content/themes/your-theme/`.

2. **Create a `scss` Directory**:
   - This will hold all your `.scss` files.

3. **Organize Your SASS Files**:
   - Create partials and organize them into subdirectories if needed.
   - Example structure:

     ```
     your-theme/
     ├── scss/
     │   ├── base/
     │   │   ├── _reset.scss
     │   │   └── _typography.scss
     │   ├── components/
     │   │   ├── _buttons.scss
     │   │   └── _navigation.scss
     │   ├── layout/
     │   │   ├── _header.scss
     │   │   └── _footer.scss
     │   ├── pages/
     │   │   ├── _home.scss
     │   │   └── _about.scss
     │   └── style.scss
     ├── functions.php
     ├── header.php
     ├── footer.php
     ├── ...
     ```

4. **Create a `style.scss` File**:
   - This will be your main SASS file that imports all partials.

     ```scss
     // style.scss

     // Base
     @import 'base/reset';
     @import 'base/typography';

     // Components
     @import 'components/buttons';
     @import 'components/navigation';

     // Layout
     @import 'layout/header';
     @import 'layout/footer';

     // Pages
     @import 'pages/home';
     @import 'pages/about';
     ```

### **Step 2: Install Node.js and npm**

If you haven't already, download and install [Node.js](https://nodejs.org/) (which includes npm).

### **Step 3: Initialize npm in Your Theme Directory**

1. **Open Terminal or Command Prompt**:
   - Navigate to your theme directory.

2. **Initialize npm**:

   ```bash
   npm init -y
   ```

   - This creates a `package.json` file.

### **Step 4: Install Gulp and Necessary Packages**

1. **Install Gulp Globally** (optional but recommended):

   ```bash
   npm install --global gulp-cli
   ```

2. **Install Gulp and Plugins Locally**:

   ```bash
   npm install --save-dev gulp gulp-sass sass gulp-postcss autoprefixer cssnano gulp-rename gulp-sourcemaps
   ```

   - **Packages Explained**:
     - `gulp`: Task runner.
     - `gulp-sass` and `sass`: For compiling SASS to CSS.
     - `gulp-postcss`, `autoprefixer`, `cssnano`: For processing CSS (adding vendor prefixes, minifying).
     - `gulp-rename`: For renaming files.
     - `gulp-sourcemaps`: For generating source maps.

### **Step 5: Create a `gulpfile.js` in Your Theme Directory**

This file defines Gulp tasks.

```javascript
// gulpfile.js

const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');

// Compile SASS
function compileSass() {
  return src('scss/style.scss')
    .pipe(sourcemaps.init())
    .pipe(
      sass({
        outputStyle: 'expanded',
        includePaths: ['node_modules'],
      }).on('error', sass.logError)
    )
    .pipe(postcss([autoprefixer()]))
    .pipe(sourcemaps.write('.'))
    .pipe(dest('.'));
}

// Minify CSS
function minifyCss() {
  return src('style.css')
    .pipe(sourcemaps.init())
    .pipe(postcss([cssnano()]))
    .pipe(
      rename({
        suffix: '.min',
      })
    )
    .pipe(sourcemaps.write('.'))
    .pipe(dest('.'));
}

// Watch Files
function watchFiles() {
  watch('scss/**/*.scss', series(compileSass, minifyCss));
}

// Default Task
exports.default = series(compileSass, minifyCss, watchFiles);
```

- **Explanation**:
  - **`compileSass`**: Compiles `style.scss` to `style.css`, generates source maps, and adds vendor prefixes.
  - **`minifyCss`**: Minifies `style.css` to `style.min.css`.
  - **`watchFiles`**: Watches for changes in any `.scss` file and runs the compile and minify tasks.
  - **`exports.default`**: Runs the tasks in sequence and starts watching.

### **Step 6: Update Your `functions.php` to Enqueue Compiled CSS**

1. **Enqueue Compiled CSS**:

   ```php
   <?php
   function my_theme_enqueue_styles() {
       // Enqueue the main stylesheet
       wp_enqueue_style(
           'main-styles',
           get_template_directory_uri() . '/style.css',
           array(),
           filemtime(get_template_directory() . '/style.css'),
           'all'
       );

       // Optionally enqueue the minified version
       wp_enqueue_style(
           'main-styles-min',
           get_template_directory_uri() . '/style.min.css',
           array(),
           filemtime(get_template_directory() . '/style.min.css'),
           'all'
       );
   }
   add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
   ```

   - **Notes**:
     - `filemtime()` ensures the version number updates whenever the file changes (useful for cache busting).
     - You can choose to enqueue either the regular or minified CSS.

2. **Remove Any Other CSS Enqueues**:
   - Ensure you're not enqueueing other styles that might conflict.

### **Step 7: Run Gulp to Compile SASS**

1. **Run Gulp**:

   ```bash
   gulp
   ```

   - This will compile your SASS, minify the CSS, and start watching for changes.

2. **Development Workflow**:
   - Leave Gulp running in your terminal.
   - As you edit `.scss` files, Gulp will automatically recompile and refresh your CSS.

### **Step 8: Incorporate SASS Features into Your Styles**

Now you can use SASS features in your `.scss` files:

- **Variables**:

  ```scss
  // _variables.scss
  $primary-color: #3498db;
  $secondary-color: #2ecc71;
  ```

- **Nesting**:

  ```scss
  // _navigation.scss
  nav {
    ul {
      list-style: none;
      li {
        display: inline-block;
        a {
          color: $primary-color;
          &:hover {
            color: $secondary-color;
          }
        }
      }
    }
  }
  ```

- **Mixins**:

  ```scss
  // _mixins.scss
  @mixin transition($property, $duration) {
    transition: $property $duration ease-in-out;
  }

  // Usage
  .button {
    @include transition(all, 0.3s);
  }
  ```

- **Imports**:
  - Use `@import` statements in your `style.scss` to include partials.

### **Step 9: Optimize for Production**

When you're ready to deploy:

1. **Run Gulp Tasks Without Watching**:

   ```bash
   gulp compileSass minifyCss
   ```

   - This compiles and minifies your CSS without starting the watch task.

2. **Ensure Source Maps Are Not Included**:
   - You may want to disable source maps in production for security reasons.

     - Modify your `gulpfile.js`:

       ```javascript
       function compileSass() {
         return src('scss/style.scss')
           // .pipe(sourcemaps.init()) // Comment out or remove
           .pipe(
             sass({
               outputStyle: 'expanded',
               includePaths: ['node_modules'],
             }).on('error', sass.logError)
           )
           .pipe(postcss([autoprefixer()]))
           // .pipe(sourcemaps.write('.')) // Comment out or remove
           .pipe(dest('.'));
       }

       function minifyCss() {
         return src('style.css')
           // .pipe(sourcemaps.init()) // Comment out or remove
           .pipe(postcss([cssnano()]))
           .pipe(
             rename({
               suffix: '.min',
             })
           )
           // .pipe(sourcemaps.write('.')) // Comment out or remove
           .pipe(dest('.'));
       }
       ```

3. **Update Enqueued Styles**:
   - In `functions.php`, ensure you're enqueueing the correct CSS file for production.

### **Step 10: Using SASS with CSS Libraries**

If you're using a CSS library like Bootstrap that offers SASS source files:

1. **Install the Library via npm**:

   ```bash
   npm install bootstrap
   ```

2. **Include Bootstrap SASS in Your `style.scss`**:

   ```scss
   // style.scss

   // Import Bootstrap SASS (adjust the path if necessary)
   @import 'node_modules/bootstrap/scss/bootstrap';

   // Your custom styles
   @import 'base/reset';
   @import 'components/buttons';
   // ...
   ```

3. **Customize Bootstrap Variables**:
   - Before importing Bootstrap, override variables:

     ```scss
     // Custom Bootstrap Variables
     $primary: #ff6347; // Tomato color

     // Import Bootstrap
     @import 'node_modules/bootstrap/scss/bootstrap';
     ```

### **Step 11: Handle Autoprefixing and Polyfills**

- **Autoprefixer**: Already included in the Gulp setup, it adds vendor prefixes based on browser support.
- **CSS Polyfills**: If needed, consider using PostCSS plugins to add polyfills for newer CSS features.

---

## **Best Practices**

### **Organize Your SASS Files**

- **Use Partials**: Break your styles into logical partials with filenames starting with an underscore (e.g., `_header.scss`).
- **Modular Approach**: Group related styles together for better maintainability.

### **Use Variables and Mixins Wisely**

- **Variables**: Centralize common values like colors, fonts, and sizes.
- **Mixins**: Reuse blocks of styles to avoid repetition.

### **Leverage SASS Functions**

- **Color Manipulation**:

  ```scss
  $primary-color: #3498db;
  $primary-dark: darken($primary-color, 10%);
  ```

- **Math Operations**:

  ```scss
  $gutter: 20px;
  .container {
    padding: $gutter / 2;
  }
  ```

### **Keep Output CSS Clean**

- **Avoid Deep Nesting**: Overly nested selectors can lead to bloated CSS.
- **Use Placeholders (`%` selector)**: For styles that shouldn't output CSS unless extended.

  ```scss
  %btn {
    display: inline-block;
    padding: 10px 20px;
    text-decoration: none;
  }

  .button {
    @extend %btn;
    background-color: $primary-color;
  }
  ```

### **Version Control**

- **Ignore Compiled Files**: In your `.gitignore`, exclude `node_modules/`, `style.css`, and `style.min.css` if you don't want to track compiled files.

  ```
  /node_modules/
  style.css
  style.css.map
  style.min.css
  style.min.css.map
  ```

---

## **Additional Tips**

### **Use `@use` and `@forward` Directives**

- **Note**: SASS introduced `@use` and `@forward` to replace `@import`.
- **Example**:

  ```scss
  // _colors.scss
  $primary-color: #3498db;

  // style.scss
  @use 'colors' as *;

  body {
    background-color: $primary-color;
  }
  ```

### **Linting**

- **Install a Linter**: Use tools like `stylelint` to maintain code quality.
- **Integrate with Gulp**:

  ```bash
  npm install --save-dev gulp-stylelint
  ```

  - Add to `gulpfile.js`:

    ```javascript
    const stylelint = require('gulp-stylelint');

    function lintScss() {
      return src('scss/**/*.scss')
        .pipe(
          stylelint({
            reporters: [{ formatter: 'string', console: true }],
          })
        );
    }

    exports.lint = lintScss;
    ```

### **Sourcemaps**

- **Use in Development**: Sourcemaps help you debug SASS by mapping CSS back to the original `.scss` files.

### **Integrate with BrowserSync**

- **Automatic Reloading**: Use BrowserSync to reload the browser automatically when files change.

  ```bash
  npm install --save-dev browser-sync
  ```

  - Update `gulpfile.js`:

    ```javascript
    const browserSync = require('browser-sync').create();

    function serve() {
      browserSync.init({
        proxy: 'your-local-site.test', // Replace with your local development URL
      });

      watch('scss/**/*.scss', series(compileSass, minifyCss)).on('change', browserSync.reload);
      watch('**/*.php').on('change', browserSync.reload);
    }

    exports.default = series(compileSass, minifyCss, serve);
    ```

---

## **Conclusion**

Using SASS in your WordPress theme development workflow brings powerful features that make your CSS more maintainable, scalable, and efficient. By setting up a task runner like Gulp to automate the compilation and processing of your SASS files, you can focus on writing clean, organized styles. Additionally, integrating SASS with CSS libraries like Bootstrap allows for greater customization and control over your theme's design.

---

## **Resources for Further Learning**

- **SASS Official Documentation**: [https://sass-lang.com/documentation](https://sass-lang.com/documentation)
- **Gulp.js Documentation**: [https://gulpjs.com/docs/en/getting-started/quick-start](https://gulpjs.com/docs/en/getting-started/quick-start)
- **Autoprefixer**: [https://github.com/postcss/autoprefixer](https://github.com/postcss/autoprefixer)
- **BrowserSync**: [https://browsersync.io/docs/gulp](https://browsersync.io/docs/gulp)
- **WordPress Theme Handbook**: [https://developer.wordpress.org/themes/](https://developer.wordpress.org/themes/)

By following this guide and utilizing these resources, you'll be well-equipped to enhance your WordPress theme development with SASS, leading to a more efficient and enjoyable coding experience.
