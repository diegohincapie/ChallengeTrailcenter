<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Addsoftdeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('libraries', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('libraries', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
