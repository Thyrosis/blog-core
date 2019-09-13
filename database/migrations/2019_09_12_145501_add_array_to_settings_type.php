<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class AddArrayToSettingsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $settings = App\Setting::all();

        Schema::dropIfExists('settings');

        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->index();
            $table->string('type', 15)->default('TEXT');
            $table->string('label');
            $table->text('description')->nullable();
            $table->text('value')->nullable();
            $table->string('category')->nullable();
            $table->boolean('hidden');
            $table->timestamps();
        });

        foreach ($settings as $setting) {
            $s = new App\Setting;
            $s->create($setting->toArray());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $settings = App\Setting::all();

        Schema::dropIfExists('settings');

        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->index();
            $table->enum('type', ['BOOLEAN', 'NUMBER', 'DATE', 'TEXT', 'SELECT', 'FILE', 'TEXTAREA']);
            $table->string('label');
            $table->text('description')->nullable();
            $table->text('value')->nullable();
            $table->string('category')->nullable();
            $table->boolean('hidden');
            $table->timestamps();
        });

        foreach ($settings as $setting) {
            $s = new App\Setting;
            $s->create($setting->toArray());
        }
    }
}
