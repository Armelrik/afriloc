<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->integer('rental_duration')->default(1)->after('num_people');
            $table->enum('rental_frequency', ['daily', 'weekly', 'monthly', 'yearly'])->default('monthly')->after('rental_duration');
            $table->decimal('total_rent', 10, 2)->default(0)->after('rental_frequency');
            $table->decimal('deposit_paid', 10, 2)->default(0)->after('total_rent');
            $table->decimal('advance_paid', 10, 2)->default(0)->after('deposit_paid');
            $table->decimal('platform_commission', 10, 2)->default(0)->after('advance_paid');
            $table->decimal('promoter_amount', 10, 2)->default(0)->after('platform_commission');
            $table->enum('payment_method', ['mobile_money', 'card', 'cash', 'bank_transfer'])->nullable()->after('payment_status');
            $table->string('payment_provider')->nullable()->after('payment_method');
            $table->string('payment_reference')->nullable()->after('payment_provider');
            $table->timestamp('payment_completed_at')->nullable()->after('payment_intent_id');
            $table->boolean('transferred_to_promoter')->default(false)->after('payment_completed_at');
            $table->date('transfer_date')->nullable()->after('transferred_to_promoter');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'rental_duration',
                'rental_frequency',
                'total_rent',
                'deposit_paid',
                'advance_paid',
                'platform_commission',
                'promoter_amount',
                'payment_method',
                'payment_provider',
                'payment_reference',
                'payment_completed_at',
                'transferred_to_promoter',
                'transfer_date',
            ]);
        });
    }
};
