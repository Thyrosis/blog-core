<?php 

if (!function_exists('is_current_url')) {
    function is_current_url($url)
    {
        return Request::path() == str_replace(config('app.url').'/', '', $url);
    }
}

if (!function_exists('setting')) {
    function setting($setting)
    {
        return App\Setting::get($setting);
    }
}
