<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('transaction_id', 100)->nullable()->after('course_id');
            $table->string('payment_method', 50)->nullable()->after('transaction_id');
            $table->string('payment_status', 50)->nullable()->after('payment_method');
            $table->decimal('amount', 10, 2)->nullable()->after('payment_status');
            $table->string('izipay_order_id', 100)->nullable()->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn(['transaction_id', 'payment_method', 'payment_status', 'amount', 'izipay_order_id']);
        });
    }
};
