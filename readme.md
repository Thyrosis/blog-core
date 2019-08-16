<p align="center">CMS @ Sax{xites}</p>

## About Blog-Core

There are many solutions available for online publishing of content. I used to be an avid WordPress user, until my own blog started to behave unexpectedly and, quite frankly, being a total mess. That's why I started working on a custom made blog using Laravel.

## Why Laravel

Because, why not? I am familiar with PHP and, coming from CodeIgniter, Laravel is a step up in the world of web application frameworks. They believe development must be an enjoyable and creative experience and with Laravel, it is. 

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Installation

Couldn't be easier.

 - git clone https://github.com/Thyrosis/blog-core
 - composer install
 - php artisan blog:configure
 - php artisan blog:install
 - cd public; ln -s ../storage/app storage

## Setup

Everyone is different, so you'll have to find your own way. I can only tell you what I do.

 - On a staging server, clone from the Github repo.
 - On development PC, clone from the staging server and branch to template. 
 - In development/template, make the customisations to the template. 
 - Push to staging/template, merge into staging/master.
 - From the live server, I pull staging/master.

Then just Log in via yourdomain.com/admin. Create your own posts and pages, tags and categories, upload media files and publish your site with the default theme.

## Templates

There is a default layout which is (honestly) dreadful. To override those, create new view folders and blade files in the resources/views directory. You'll need at least:

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

## Forms

There is a rudimentary form functionality included in the project. You can make your own form and use it in a template or use a default one provided and style it using css.

To use the default, use @include('forms._show', App\Form::find($id)) in your blade file. It will load the given forms ID. You can find the ID in the admin panel, it's the last digit of the Action URL.

To build up your own form using HTML, open the form using the POST method and use the action in the admin panel. Don't forget to use the CSRF field in your form ( @csrf )

## Contributing

As I only use this blog for my own projects, I don't expect any contributions. If you do happen to stumble across this repo and think "wow, that's a really roundabout way of doing something", feel free to create a pull request or something.

## Security Vulnerabilities

In case I forgot to plug a few holes, feel free to leave a comment on the repo.

> If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

This blog is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
