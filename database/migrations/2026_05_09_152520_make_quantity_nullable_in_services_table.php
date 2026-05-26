<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedInteger('quantity')->nullable()->change();
        });

        if (!Schema::hasColumn('services', 'reserved_quantity')) {
            Schema::table('services', function (Blueprint $table) {
                $table->unsignedInteger('reserved_quantity')->default(0)->after('quantity');
            });
        }
        if (!Schema::hasColumn('services', 'pending_quantity')) {
            Schema::table('services', function (Blueprint $table) {
                $table->unsignedInteger('pending_quantity')->default(0)->after('reserved_quantity');
            });
        }
    }

    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
        });
    }
};
