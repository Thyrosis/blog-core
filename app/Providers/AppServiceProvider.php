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
            if (Setting::get('analytics.enabled') && auth()->guest()) {   
                $trackingcode = Setting::get('analytics.trackingID');

                if ($trackingcode !== null) {
            
                    $html = "<!-- Global site tag (gtag.js) - Google Analytics -->
                    <script async src=\'https://www.googletagmanager.com/gtag/js?id=".$trackingcode."\'></script>
                    <script>
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag(\'js\', new Date());

                    gtag(\'config\', \'".$trackingcode."\');
                    </script>";

                    return "<?php echo '$html'; ?>";
                }
            }
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
