<?php

use App\Models\Purchase;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Purchase::where('status', 'pendiente')
            ->whereNull('transaction_id')
            ->update(['status' => 'cancelado']);

        Purchase::where('status', 'pendiente')
            ->whereNotNull('transaction_id')
            ->whereNull('payment_status')
            ->update(['status' => 'cancelado']);

        Purchase::where('status', 'pendiente')
            ->whereNotNull('transaction_id')
            ->whereIn('payment_status', ['REFUSED', 'CANCELLED', 'ERROR'])
            ->update(['status' => 'rechazado']);

        Purchase::where('status', 'pendiente')
            ->whereNotNull('transaction_id')
            ->whereIn('payment_status', ['PAID', 'SUCCESS', 'AUTHORISED'])
            ->update([
                'status' => 'activo',
                'completed_at' => now(),
            ]);
    }

    public function down(): void
    {
    }
};
