<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceRelatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_related', function (Blueprint $table) {
            $table->id();
            $table->integer('eligible_level')->default(0);
            $table->timestamps();
            $table->foreignId('resource_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->foreignId('resource_related_id')->nullable()->constrained('resources')->onDelete('set null')->onUpdate('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_related');
    }
}
