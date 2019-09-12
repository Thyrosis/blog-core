<?php

use Illuminate\Database\Migrations\Migration;
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
        DB::statement("ALTER TABLE settings MODIFY COLUMN type ENUM('ARRAY', 'BOOLEAN', 'DATE', 'FILE', 'NUMBER', 'SELECT', 'TEXT', 'TEXTAREA') NOT NULL DEFAULT 'TEXT'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE settings MODIFY COLUMN type ENUM('BOOLEAN', 'DATE', 'FILE', 'NUMBER', 'SELECT', 'TEXT', 'TEXTAREA') NOT NULL DEFAULT 'TEXT'");
    }
}
