<?php

use Illuminate\Database\Seeder;
use App\Meta;

class MetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metas[] = [
            'code' => 'level',
            'label' => 'Access level',
            'description' => __("Access level for the user."),
        ];

        $metas[] = [
            'code' => 'last_login',
            'label' => 'Last Login',
            'description' => __("Last time this user successfully logged in to the application."),
            'updateable' => false,
        ];

        foreach ($metas as $meta) {
            try {
                Meta::create($meta);
            } catch (Exception $e) {
                // do nothing;
            }
        }

        $meta = Meta::where('code', 'level')->first();

        if ($meta->using('admin')->count() == 0) {
            try {
                \App\User::first()->updateMeta('level', 'admin');
            } catch (Exception $e) {
                // do nothing
            }
        }
    }
}
