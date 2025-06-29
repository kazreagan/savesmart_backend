<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixAccountNumberField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // For Laravel 10+ with Doctrine DBAL issues, use raw SQL as a workaround
        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE users MODIFY account_number VARCHAR(255) NULL');
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('account_number')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (config('database.default') === 'mysql') {
            DB::statement('ALTER TABLE users MODIFY account_number VARCHAR(255) NOT NULL');
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->string('account_number')->nullable(false)->change();
            });
        }
    }
}