<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')
                ->constrained('services')
                ->restrictOnDelete();
            $table->foreignId('requester_business_account_id')
                ->constrained('business_accounts')->restrictOnDelete();;
            $table->foreignId('provider_business_account_id')
                ->constrained('business_accounts')->restrictOnDelete();;
            $table->timestamp('needed_time')->nullable();
            $table->text('details')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
