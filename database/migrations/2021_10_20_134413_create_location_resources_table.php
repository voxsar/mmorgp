<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_resources', function (Blueprint $table) {
            $table->id();
            $table->integer('level')->default(1);
            $table->integer('production')->default(0);
            $table->integer('is_production')->default(0);
            $table->integer('current_production_perhour')->default(0);
            $table->integer("is_upgrading")->default(0);
            $table->datetime("upgrade_endtime")->nullable();
            $table->timestamps();
            $table->foreignId('resource_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_resources');
    }
}
