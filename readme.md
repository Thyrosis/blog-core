<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Blog-Core

There are many solutions available for online publishing of content. I used to be an avid WordPress user, until my own blog started to behave unexpectedly and, quite frankly, being a total mess. That's why I started working on a custom made blog using Laravel.

## Why Laravel

Because, why not? I am familiar with PHP and, coming from CodeIgniter, Laravel is a step up in the world of web application frameworks. They believe development must be an enjoyable and creative experience and with Laravel, it is. 

## Installation

Couldn't be easier.

Just clone, do a composer install, set the application key and env-files (mind the database!) and migrate the tables. Et voila!

## Usage

Logging in via yoururl/admin. Create a user, a category and some tags and start writing.

## Templates

There is a default layout which is (honestly) dreadful. To override those, just create new view folders and blade files in the resources/views directory. You'll need at least:

- post/index
- post/show

If you want to use the SearchController, you'll also need:

- search/show

Of course, it's easiest to create a base layout file from which you extend those. So, the advised structure is

- **layout/app**: base layout file
- **post/index**: post index (main, category and tag), extends layout/app. Gets *$posts* as Blade parameter
- **post/show**: single post, extends layout/app. Gets *$post* as Blade parameter
- **post/_single**: a single post (summary) for the index pages (post.index, category.index, tag.index)
- **category/index**: Showing all posts related to this category (prone to change as it should be category.show)
- **tag/index**: Showing all posts related to this tag (prone to change as it should be tag.show)
- **search/_create**: an includable snippet which only has a form that POSTS to the search.create route
- **search/show**: show search results, extends layout/app. Gets *$posts* as Blade parameter
- **errors**: to include 403, 404, 429, 500 and 503.blade.php in your own templates

## Contributing

As I only use this blog for my own projects, I don't expect any contributions. If you do happen to stumble across this repo and think "wow, that's a really roundabout way of doing something", feel free to create a pull request or something.

## Security Vulnerabilities

In case I forgot to plug a few holes, feel free to leave a comment on the repo.

> If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

This blog is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
