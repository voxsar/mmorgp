<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->integer("production_perhour")->nullable()->default(0);
            $table->integer("damage_perattack")->nullable()->default(0);
            $table->integer("consumption_perhour")->nullable()->default(0);
            $table->integer("upgrade_timeseconds")->nullable()->default(0);
            $table->integer("upgrade_population")->nullable()->default(0);
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
        Schema::dropIfExists('resources');
    }
}
