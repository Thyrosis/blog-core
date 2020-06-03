<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::directive('google', function () {
            $html = "";

            if (!auth()->guest()) {
                return "<?php echo \"<!-- Authorised users don't count towards analytics. -->\"; ?>";
            }

            if (Setting::get('analytics.enabled')) {   
                $html = "<!-- Google tracking code goes here -->";

                $trackingcode = Setting::get('analytics.trackingID');

                if ($trackingcode !== null) {
                    $html .= "<!-- Global site tag (gtag.js) - Google Analytics -->
                    <script async src=\'https://www.googletagmanager.com/gtag/js?id=".$trackingcode."\'></script>
                    <script>
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag(\'js\', new Date());

                    gtag(\'config\', \'".$trackingcode."\');
                    </script>";

                    return "<?php echo '$html'; ?>";
                }

                $html .= "<!-- At least it would, if someone had set a tracking code... -->";
            }

            return "<?php echo '$html'; ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
