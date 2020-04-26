# Release Notes

## Todo

- Better form management (ordering fields, validation, response by mail)
- Make readTime a global setting
- Twitter oAPI plug-in
- On Media index page, style images
- On Menu admin page, split pages and posts & provide visual feedback for published status

## 1.7.1 (2020-04-26)

- Changed: Laravel/framework (v7.2.1 => 7.8.1)
- Changed: TailwindCSS@1.3.5
- Changed: Composer update: 2 installs, 38 updates, 3 removals
- Changed: NPM update: removed 4 packages, updated 4 packages

## 1.7.0 (2020-03-19)

- Added: laravel/ui to composer.json
- Changed: laravel/framework (v6.15.0 => v7.2.1)
- Changed: Composer update: 2 installs, 55 updates, 0 removals
- Changed: Hide created_at/updated_at in Category, Tag and User models to avoid PHPUnit errors on finding wrong timestamp formats. 
- Changed: Override Post->serializeDate() as described by https://laravel.com/docs/7.x/upgrade#date-serialization .

## 1.6.17 (2020-02-21)

- Changed: Added mobile specific parameters to TinyMCE-full code.
- Fixed: Excluded authorised users from Google including analytics.
- Removed: Commented out unused social block in footer of core.layout.app.

## 1.6.16 (2020-02-18)

- Added: Option to add keywords and metadescription to Posts. Requires migration.
- Fixed: Missing translation lines in Post/create and Post/edit.

## 1.6.15 (2020-02-14)

- Added: Post::getFeaturedPosts and Post::getFeaturedPost to retrieve all or just one featured post.

## 1.6.14 (2020-02-11)

- Added: Settings to add Google Analytics to template using the @google custom Blade directive.
- Added: Option to compile a custom scss files in resources/sass.
- Changed: Made TinyMCE more mobile friendly on edit and create post.
- Changed: Updated TailwindCSS to version 1.2.0.
- Changed: added active variant for backgroundColor to Tailwind config.
- Changed: laravel/framework (v6.10.1 => v6.15.0)
- Changed: Package operations: 0 installs, 24 updates, 1 removal

## 1.6.13 (2020-01-21)

- Added: create Purify folder on Artisan command blog:configure
- Added: A ton of changes from the past couple of months to the changelog
- Changed: Comment preapproval is now true if authorised user posts comment that has already passed Akismet
- Fixed: An issue with saving array-settings not being saved to the database.
- Improved: output from blog:configure command
- Improved: Custom RSS feed items are now sorted in descending order by published_at column

## 1.6.12 (2020-01-13)

- Improved: In admin.settings.edit, show the settings per category.
- Changed: Exclude Purify folders from repository.
- Changed: laravel/framework (v6.6.2 => v6.10.1)
- Changed: Composer Update: 3 installs, 60 updates, 1 removal

## 1.6.11 (2020-01-10)

- Added: Displays the current version date in the footer of admin template.
- Improved: Clean up dashboard header & footer

## 1.6.10 (2020-01-07)

- Improved: In admin.post.index, provide better visual differentation between regular, future and unpublished posts and pages.

## 1.6.9 (2019-12-19)

- Added: Change the author of a post of page to a different user_id.

## 1.6.8 (2019-12-13)

- Added: Create a custom RSS feed based on a set number of categories.

## 1.6.7 (2019-12-09)

- Changed: A few fixes to the comment system.
- Changed: laravel/framework (v6.6.0 => v6.6.2)
- Changed: Composer Update: 0 installs, 29 updates, 0 removals

## 1.6.6 (2019-11-27)

- Changed: Update Laravel version to 6.6.0
- Changed: Update all Composer packages to the latest versions.
- Fixed: Fix memory error on busy blogs

## 1.6.5 (2019-11-08)

- Fixed: Perform extra validation on routes creation based on user settings.
- Changed: Update all tests to continue working with new versions of Laravel and PHPUnit.
- Added: Add the ability to submit spam

## 1.6.4 (2019-10-21)

- Added: Make mails customisable by creating a different view file in mail folder
- Changed: Remove the copyright/reserved part from the mail template footer

## 1.6.3 (2019-10-06)

- Added: Use cache to remember application settings
- Fixed: sub-items in menu generator
- Fixed: ignore empty custom classes in routes file

## 1.6.2 (2019-10-05)

- Changed: new lay-out for the admin backend

## 1.6.1 (2019-10-01)

- Add ApiAuthentication middleware (needs Database Migration for new api_token column for user).
- Add API method to store posts (needs ApiAuthentication).
- Changes in API responses, they now always return (boolean) result, followed by (array) data.
- Bugfix: APi method to show single post.
- Composer update: Laravel to 6.0.4

## 1.6.0 (2019-09-13)
- UPDATE TO LARAVEL 6.0
- Changed version naming: {master}.{laravel master}.{minor}
- Updates the way menus are converted to HTML
- Updates to Form building (https://github.com/Thyrosis/blog-core/commit/ee6c4afd6322da750c463ae7a25a7cae67183041)
- Feature: Add setting to load routes of custom classes
- Feature: Add TinyMCE custom classes
- Bugfix: ReCaptcha-setting wasn't properly used in the FormResponseController

## 1.0.26 (2019-08-12)

- Add Akismet to comment preapprove method (needs Database Seed for new settings)
- Clean up in Post model
- Update Post factory and tests to fix errors in test suite due to code updates
- Larvel update to 5.8.31

## 1.0.25 (2019-07-18)

- Change default reading speed for method readTime to 175 words
- Bugfix: home route was not always defined
- Add new methods get and getHTML to menu class
- Add global setting Purify to disable purification of post body
- Composer and NPM update
- Laravel update to 5.8.28

## 1.0.24 (2019-07-03)

- Show media files on post add/edit admin pages
- Add new methods duplicate and getTitle to Post
- Post class overhaul (comments, sorting, new method getTitle)

## 1.0.23 (2019-06-27)

- Add Dutch translation file for TinyMCE
- Composer and NPM update
- Laravel update to 5.8.26

## 1.0.22 (2019-06-12)

- Laravel update to 5.8.21
- Composer, NPM en TinyMCE update.
- Run NPM production

## 1.0.21 (2019-06-06)

- Add posthash feature, which allows unauthenticated users to read content ahead of unpublished posts

## 1.0.20 (2019-05-28)

- Add automatic sitemap.xml

## 1.0.19 (2019-05-24)

- Upgrade Tailwind to v1.0

## 1.0.18 (2019-05-01)

- User management (roles, profile)
- Custom user profile options
- Improvements to TinyMCE and Purify config
- Translation updates
- Fix tests
- Add signInAdmin method
- Laravel update to 5.8.15

## 1.0.17 (2019-04-03)

- Bugfix for 1.0.15 and meta-seeder

## 1.0.16 (2019-03-28)

- Make profile-controller and views
- Redirect user to homepage after login
- Allow for metadata in secondary auth-connection
- Change menu depending on authenticated user's level
- Add Meta-related routes to routes.web file
- Laravel update to 5.8.8
- Update the core layout template to make the comment index on admin level responsive.
- Extend published date and time fields to allow for full date and time to fit
- Preselect home.url setting when editing settings
- Update Purify config to allow style on every HTML element

## 1.0.15 (2019-03-15)

- First shot at admin user-management including Meta-data.
- Save last login timestamp as user meta data
- Add Google reCAPTCHA to forms, including settings to set site and private key.
- Composer update to Laravel 5.8.4 (also install Guzzle for reCAPTCHA)
- Updates to post & page creating and editing
- Divide post and pages on admin index page for better overview
- Hide categories and labels when none are available

## 1.0.14 (2019-02-22)

- Composer update to Laravel 5.7.26
- Add database settings
- Skip Googlebot when storing views
- Attempt to fix Purify's target="_blank" issue (but failed to some extent)

## 1.0.13 (2019-02-06)

- Add multilangual support with nl.json translation file
- Switch TinyMCE Cloud from 5-testing to 5 (stable)
- Composer update to Laravel 5.7.25

## 1.0.12 (2019-02-05)

- Add user-agent to view recording
- Add view.index and view.show to Admin panel
- TODO: listen to DNT-header

## 1.0.11 (2019-01-28)

- Complete dashboard template overhaul
- Add responsive elements to admin pages
- Add option to remove unused form element rows when creating form
- Store FormResponseController.create feedback in flash variable

## 1.0.10 (2019-01-23)

- Add required column to admin.form.create
- Add validation to admin.form.create
- Add Form->toHTML() to retrieve HTMLified form
- In addition to purifying Post->body, also parse for ||FORM|| tags
- Add Post->body() method to retrieve original content (non-purified or parsed)
- Add .form-button CSS class for default buttons

## 1.0.9 (2019-01-22)

- Added Views to track Post-views.
- Composer update (Laravel to 5.7.22)
- Fixed a bug in validation feedback (admin panel)
- Added User functionality. It works in the most basic way, so needs some polishing.
- Added .form-group to the CSS file. View files still need to be converted.
 
## 1.0.8 (2019-01-17)

- Added form functionality. It works in the most basic way, so needs some polishing.

## 1.0.7 (2019-01-11)

- Purify Config change to allow style attribute on all HTML elements

## 1.0.6 (2019-01-08)

- Composer update
- TinyMCE upgrade to 5
- Bugfixes in RSS Feed
- Added To-Do list in todo.md

## 1.0.5 (2018-12-04)

- Added blockquote to admin TinyMCE panel
- Added button to view post on blog to post.edit
- Added post-column to admin.comments.index

## 1.0.4 (2018-11-19)

- Alphabetically arranged HTML.Allowed in purify configuration
- Added hr and pre as well as several other items to HTML.Allowed elements

## 1.0.3 (2018-11-11)

- Removed route /home from routes file to avoid conflict with possible Home Post
- Removed Route::resource for MenuController out of public routes
- Added 'code' plugin to full TinyMCE
- Added 'img[style] to both TinyMCE and Purifier allowed elements
- Added 'float' to Purifier allowed CSS elements
- Reorded TinyMCE plugins alphabetically
- Changed redirect after posting new post from post.show to admin.post.edit
- Added 'View post' button to admin.post.edit
- Added parameter 'default' to Post->getFeatureImage ()
- Add function Menu->rebuild()
- Rebuild cached Menu-item after Menu update

## 1.0.2 (2018-11-08)

- Composer update

### Package operations
- 0 installs
- 24 updates
- 0 removals

### Details
- Updating symfony/css-selector (v4.1.6 => v4.1.7)
- Updating symfony/polyfill-php72 (v1.9.0 => v1.10.0)
- Updating symfony/polyfill-mbstring (v1.9.0 => v1.10.0)
- Updating symfony/var-dumper (v4.1.6 => v4.1.7)
- Updating symfony/routing (v4.1.6 => v4.1.7)
- Updating symfony/process (v4.1.6 => v4.1.7)
- Updating symfony/polyfill-ctype (v1.9.0 => v1.10.0)
- Updating symfony/http-foundation (v4.1.6 => v4.1.7)
- Updating symfony/event-dispatcher (v4.1.6 => v4.1.7)
- Updating symfony/debug (v4.1.6 => v4.1.7)
- Updating symfony/http-kernel (v4.1.6 => v4.1.7)
- Updating symfony/finder (v4.1.6 => v4.1.7)
- Updating symfony/console (v4.1.6 => v4.1.7)
- Updating symfony/translation (v4.1.6 => v4.1.7)
- Updating nesbot/carbon (1.34.0 => 1.34.1)
- Updating monolog/monolog (1.23.0 => 1.24.0)
- Updating league/flysystem (1.0.47 => 1.0.48)
- Updating laravel/framework (v5.7.9 => v5.7.13)
- Updating filp/whoops (2.2.1 => 2.3.1)
- Updating phpunit/php-token-stream (3.0.0 => 3.0.1)
- Updating phpunit/php-code-coverage (6.0.8 => 6.1.4)
- Updating phpunit/phpunit (7.4.0 => 7.4.3)
- Updating tightenco/collect (v5.7.9 => v5.7.12)
- Updating psy/psysh (v0.9.8 => v0.9.9)

## 1.0.1 (2018-11-08)

- Started tracking changes in this changelog by adding changelog.md to the root of the project.
- Updated TinyMCE from 4.7.13 to 4.8.5
- Updated .env.example with new TinyMCE configurable option
- Added TinyMCE configurable option to custom config
- Updated Core/Admin blade files to load TinyMCE style based on config value
