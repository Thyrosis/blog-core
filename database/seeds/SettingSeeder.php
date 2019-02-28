<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = array();
        
        $settings[] = [
            'code' => 'post.index',
            'type' => 'TEXT',
            'label' => __("Blog URL"),
            'description' => __("At what URL is the blogpost-index available."),
            'value' => 'blog',
            'category' => 'post',
            'hidden' => '0',
        ];

        $settings[] = [
            'code' => 'post.commentable',
            'type' => 'BOOLEAN',
            'label' => __("Allow comments"),
            'description' => __("Can be used to show or hide comment fields on the front end."),
            'value' => '0',
            'category' => 'post',
            'hidden' => '0',
        ];

        $settings[] = [
            'code' => 'post.published',
            'type' => 'BOOLEAN',
            'label' => __("Published status"),
            'description' => __("Whether the post is included in 'published' collections."),
            'value' => '0',
            'category' => 'post',
            'hidden' => '0',
        ];

        $settings[] = [
            'code' => 'post.defaultFeatureImage',
            'type' => 'TEXT',
            'label' => __("Feature Image"),
            'description' => __("Doesn't serve a technical purpose, but can be used in themes."),
            'value' => '',
            'category' => 'post',
            'hidden' => '0',
        ];

        $settings[] = [
            'code' => 'post.defaultType',
            'type' => 'TEXT',
            'label' => __("Post type"),
            'description' => __("Sets the default type to either post or page."),
            'value' => 'post',
            'category' => 'post',
            'hidden' => '0',
        ];

        $settings[] = [
            'code' => 'post.allowRandomSlugs',
            'type' => 'BOOLEAN',
            'label' => __("Allow random slugs"),
            'description' => __('If the title of the new post would result in an URL already in use, allow the application to append a random string to the URL so that duplicate titles are allowed.'),
            'value' => 1,
            'category' => 'post',
            'hidden' => '0',
        ];

        $settings[] = [
            'code' => 'post.defaultAuthor',
            'type' => 'TEXT',
            'label' => __('Default Author'),
            'description' => __("This author name is used when no username can't be found"),
            'value' => __('Anonymous'),
            'category' => 'post',
            'hidden' => '0',
        ];

        $settings[] = [
            'code' => 'post.showPerPage',
            'type' => 'NUMBER',
            'label' => __("Posts per page"),
            'description' => __("On index pages, this is the amount of posts that are shown per page"),
            'value' => '10',
            'category' => 'post',
            'hidden' => '0',
        ];

        $settings[] = [
            'code' => 'comment.notification.subject',
            'type' => 'TEXT',
            'label' => __("New comment subject"),
            'description' => __("The subject for new comment notifcation emails."),
            'value' => __("A new comment has been posted"),
            'category' => 'comment',
            'hidden' => '0',
        ];

        $settings[] = [
            'code' => 'comment.notification.subscribed',
            'type' => 'TEXT',
            'label' => __("Notification thanks"),
            'description' => __("The thank you message for subscribing to a post."),
            'value' => __("Thanks! You'll receive a notification when a new comment is posted."),
            'category' => 'comment',
            'hidden' => '0',
        ];

        $settings[] = [
            'code' => 'tinyMCE.license',
            'type' => 'TEXT',
            'label' => __("TinyMCE API key"),
            'description' => __("The API key for TinyMCE cloud."),
            'value' => 'wvehkw38tagss2qgbuy9l1sid91wvjtghr6kiak4n6wovnl4',
            'category' => 'general',
            'hidden' => '1',
        ];

        $settings[] = [
            'code' => 'cdn.url',
            'type' => 'TEXT',
            'label' => __("CDN URL"),
            'description' => __("The URL where feature images are retrieved from."),
            'value' => 'https://source.unsplash.com/random/1000x300',
            'category' => 'general',
            'hidden' => '1',
        ];

        $settings[] = [
            'code' => 'home.url',
            'type' => 'TEXT',
            'label' => __("Homepage"),
            'description' => __("When someone visits your domain (not a specific page) what URL do they see?"),
            'value' => 'post.index',
            'category' => 'general',
            'hidden' => '1',
        ];

        $settings[] = [
            'code' => 'user.allowRegistrations',
            'type' => 'BOOLEAN',
            'label' => __("Allow registrations"),
            'description' => __("Allow for new users to register themselves via the site."),
            'value' => 0,
            'category' => 'user',
            'hidden' => '0',
        ];

        foreach ($settings as $setting) {
            try {
                Setting::create($setting);
            } catch (Exception $e) {
                // do nothing;
            }
        }        
    }
}
