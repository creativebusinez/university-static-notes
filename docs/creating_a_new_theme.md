# Creating a New Theme

**Note:** These notes assumes you have installed [Local by Flywheel](https://localwp.com/) and created a WordPress site with the program.

## Step 1: Navigate to your WordPress `app/public/wp-content/themes` directory and create a new folder with your new theme name. i.e. `fictional-university`

## Step 2: Open the newly created `fictional-university` theme folder in VS Code (less clutter)

## Step 3: Open `fictional-university` in an integrated terminal, in my case im using [Git Bash](https://git-scm.com/downloads) within VS Code

## Step 4: Create two new files called `index.php` and `style.css` in the newly created `fictional-university` theme site folder

```bash
cd fictional-university
touch index.php style.css
```

## Step 5: Add theme information on your `style.css` file. See [/docs](/docs/lang/css/style.css) for more information

## Step 6: Add a screenshot of your theme in your `app/public/wp-content/themes/fictional-university` folder by uploading a `.png` image and renaming it `screenshot.png` so it can be detected by WordPress

## Step 7: Activate your new theme (it may be a good idea to delete all other themes so they are not accidentally activated)

**Note:** To work faster with new projects, it's a best practice to create new directories and files using an integrated terminal. In my case I have Git installed and I'm using the Git Bash shell. You can navigate into directories using Linux's `cd` command, view contents in a directory using `ls`, create new directories using `mkdir`, and create new files in a directory using `touch`. i.e. You can `cd` into your WordPress `app/public/wp-content/themes` directory, `mkdir your-new-theme`, and `touch index.php` to quicky get you started. It's also possible to create multiple directories and files in a single command.
