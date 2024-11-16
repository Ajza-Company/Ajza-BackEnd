<?php

use App\Enums\DiscountTypeEnum;
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
        Schema::table('product_offers', function (Blueprint $table) {
            $table->enum('discount_type', DiscountTypeEnum::asArray())->default('percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_offers', function (Blueprint $table) {
            $table->dropColumn('discount_type');
        });
    }
};
