<?php

return [

    'feeds' => [
        'main' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'App\Post@getFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => env('FEED_URL', 'posts.rss'),

            'title' => env('FEED_TITLE', 'Post feed title'),
        ],
        'custom' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'App\Category@getFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => env('CUSTOM_FEED_URL', 'custom.rss'),

            'title' => env('CUSTOM_FEED_TITLE', 'Custom post feed title'),
        ],
    ],

];
