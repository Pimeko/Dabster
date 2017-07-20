<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeToDatetimeAndPathInUserposts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_posts', function ($table) {
            $table->datetime('post_date')->change();
            $table->renameColumn('data', 'img_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_posts', function ($table) {
            $table->date('post_date')->change();
            $table->renameColumn('img_path', 'data');
        });
    }
}
