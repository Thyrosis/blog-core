<?php

return [
    'featureImage' => env('DEFAULT_FEATUREIMAGE', 'https://source.unsplash.com/random/1000x300'),

    'defaultAuthor' => env('DEFAULT_AUTHOR', 'Anonymous'),

    'defaultCommentable' => env('DEFAULT_COMMENTABLE', 0),
    'defaultPublished' => env('DEFAULT_PUBLISHED', 0),

    'postsPerPage' => env('POSTS_PER_PAGE', 10),

    'allowRegistrations' => env('ALLOW_REGISTRATIONS', false),

    'allowRandomSlugs' => env('ALLOW_RANDOM_SLUGS', true),

    'customAuthDB' => env('DB_AUTH', false),

    'cdnUrl' => env('CDN_URL', 'https://unsplash.com/'),

    'commentSubject' => env('COMMENT_SUBJECT', 'A new comment has been posted'),

    'commentSubscriptionAdded' => env('COMMENT_SUBSCRIPTION_ADDED', 'Bedankt! Je krijgt een berichtje als er een reactie geplaatst wordt.'),

    'tinyMCEStyle' => env('TINYMCE_STYLE', 'regular'),

    'tinyMCEAPIkey' => env('TINYMCE_APIKEY', false),
];
