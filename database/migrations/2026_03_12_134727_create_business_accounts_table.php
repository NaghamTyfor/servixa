<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('activity_type_id')->nullable()->constrained('activity_types')->nullOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->json('business_name');
            $table->string('license_number')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->text('activities')->nullable();
            $table->text('details')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])->default('pending');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('admins');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->unique(['user_id', 'activity_type_id']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_accounts');
    }
};
