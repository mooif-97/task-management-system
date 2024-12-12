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
        Schema::create('task', function (Blueprint $table) {
            $table->increments('task_id');
            $table->string('title')->index('title_index');
            $table->string('description');
            $table->string('created_by')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamps();
            $table->index(['due_date', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
