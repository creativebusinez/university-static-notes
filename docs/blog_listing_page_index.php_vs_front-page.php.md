# Blog Listing Page vs. Front Page

In the WordPress admin dashboard, under Settings > Reading, the "Front page displays" options allow you to configure how your site's front page and blog posts are displayed. These settings are crucial for customizing your site's navigation and structure to fit your needs, especially if you want to separate your home page (a static front page) from your blog page (where your posts are listed).

## Front Page Displays Options

1. **Your latest posts**: Selecting this option will make your front page display your most recent blog posts in reverse chronological order. This is the default setting for a fresh WordPress installation and is ideal for bloggers or news sites that want the focus to be on the newest content.

2. **A static page (select below)**: This option allows you to select separate pages for your home page and posts page, effectively separating the front page of your site from your blog.

   - **Front page**: Here, you choose which page you want to serve as your site's main landing page or home page. This is where you might have a welcome message, an introduction to your services, or featured content.

   - **Posts page**: This is where you select the page that will display your blog posts. If you have a "Blog" page, this is where you'd set it to display your latest posts.

## How to Separate the Home Page from the Blog Page

To implement this separation, follow these steps:

1. **Create front-page.php**: Create a new file named "front-page.php" in your WordPress theme directory. This file will serve as your static front page.

2. **Create Two Pages**:
   - Go to Pages > Add New in the WordPress admin dashboard.
   - Create a page named "Home" (or any name you prefer for your front page).
   - Create another page named "Blog" (or any name you prefer for your posts page).

3. **Set Your Front Page and Posts Page**:
   - Navigate to Settings > Reading in your WordPress dashboard.
   - Select "A static page (select below)" under the "Front page displays" option.
   - In the "Front page" dropdown, select the "Home" page you created.
   - In the "Posts page" dropdown, select the "Blog" page you created.

4. **Save Changes**: Click the "Save Changes" button at the bottom of the screen to apply your settings.

After these steps, your site will display the "Home" page as the static front page, and the "Blog" page will list your latest posts. This setup is ideal for businesses or individuals who want a static introduction page for visitors but also want to maintain a separate blog section for updates, news, or articles.
