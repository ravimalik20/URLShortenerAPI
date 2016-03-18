<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClickTrackingMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("url_requests", function ($table)
        {
            $table->increments("id");
            $table->integer("url_id")->unsigned();
            $table->foreign("url_id")->references("id")->on("url");
            $table->string("ip_address");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("url_requests");
    }
}
