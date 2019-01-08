# Release Notes

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
