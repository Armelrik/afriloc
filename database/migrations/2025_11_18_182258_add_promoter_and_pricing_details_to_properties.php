<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->foreignId('promoter_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->enum('rental_frequency', ['daily', 'weekly', 'monthly', 'yearly'])->default('monthly')->after('price');
            $table->decimal('monthly_rent', 10, 2)->nullable()->after('rental_frequency');
            $table->decimal('deposit_amount', 10, 2)->default(0)->after('monthly_rent');
            $table->decimal('advance_payment', 10, 2)->default(0)->after('deposit_amount');
            $table->decimal('commission_amount', 10, 2)->default(0)->after('advance_payment');
            $table->decimal('commission_rate', 5, 2)->default(10.00)->after('commission_amount');
            $table->boolean('is_for_rent')->default(true)->after('featured');
            $table->boolean('is_for_sale')->default(false)->after('is_for_rent');
            $table->enum('availability_status', ['available', 'rented', 'sold', 'maintenance'])->default('available')->after('is_for_sale');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['promoter_id']);
            $table->dropColumn([
                'promoter_id',
                'rental_frequency',
                'monthly_rent',
                'deposit_amount',
                'advance_payment',
                'commission_amount',
                'commission_rate',
                'is_for_rent',
                'is_for_sale',
                'availability_status',
            ]);
        });
    }
};
