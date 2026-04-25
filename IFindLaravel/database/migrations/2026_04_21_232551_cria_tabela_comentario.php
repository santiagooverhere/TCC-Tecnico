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
        Schema::create('comentario', function (Blueprint $table) {
            $table->foreignId('users_id')->constrained('users')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('post_id')->constrained('post')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name_user', 100);
            $table->text('texto')->nullable();
            $table->primary(['users_id', 'post_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentario');
    }
};