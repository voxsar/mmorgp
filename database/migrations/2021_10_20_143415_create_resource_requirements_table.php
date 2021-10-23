<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_requirements', function (Blueprint $table) {
            $table->id();
            $table->integer('value')->default(0);
            $table->double('level_multiplier')->default(0);
            $table->timestamps();
            $table->foreignId('resource_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->foreignId('resource_requirement_id')->nullable()->constrained('resources')->onDelete('set null')->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_requirements');
    }
}
