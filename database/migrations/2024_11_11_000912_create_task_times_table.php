<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_times', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id');
            $table->dateTime('start_at')->useCurrent(); //default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('end_at')->nullable();
            // $table->integer('duration')->nullable();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_times');
    }
};
