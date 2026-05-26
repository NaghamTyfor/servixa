<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dynamic_fields', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->enum('type', ['text', 'number', 'select', 'textarea', 'date']);
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->morphs('dynamic_fieldable');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('dynamic_fields');
    }
};
