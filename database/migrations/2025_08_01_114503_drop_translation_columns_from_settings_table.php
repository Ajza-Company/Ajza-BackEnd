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
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'value_ar')) {
                $table->dropColumn('value_ar');
            }
            if (Schema::hasColumn('settings', 'value_en')) {
                $table->dropColumn('value_en');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('value_ar')->nullable()->after('value');
            $table->text('value_en')->nullable()->after('value_ar');
        });
    }
};
