<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('PRAGMA foreign_keys=off');

        DB::statement('CREATE TABLE purchases_v2 (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NULL,
            course_id INTEGER NOT NULL,
            status TEXT NOT NULL DEFAULT "activo",
            purchased_at DATETIME NULL,
            completed_at DATETIME NULL,
            created_at DATETIME NULL,
            updated_at DATETIME NULL,
            contact_name TEXT NULL,
            contact_email TEXT NULL,
            contact_phone TEXT NULL,
            transaction_id TEXT NULL,
            payment_method TEXT NULL,
            payment_status TEXT NULL,
            amount DECIMAL(10,2) NULL,
            izipay_order_id TEXT NULL
        )');

        $oldRows = DB::table('purchases')->get();
        foreach ($oldRows as $row) {
            DB::table('purchases_v2')->insert((array) $row);
        }

        $maxId = DB::table('purchases_v2')->max('id') ?? 0;

        Schema::drop('purchases');
        DB::statement('ALTER TABLE purchases_v2 RENAME TO purchases');
        DB::statement("UPDATE sqlite_sequence SET seq={$maxId} WHERE name='purchases'");

        DB::statement('PRAGMA foreign_keys=on');
    }

    public function down(): void
    {
        DB::statement('PRAGMA foreign_keys=off');

        DB::statement('CREATE TABLE purchases_v1 (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            course_id INTEGER NOT NULL,
            status TEXT NOT NULL DEFAULT "activo",
            purchased_at DATETIME NULL,
            completed_at DATETIME NULL,
            created_at DATETIME NULL,
            updated_at DATETIME NULL,
            contact_name TEXT NULL,
            contact_email TEXT NULL,
            contact_phone TEXT NULL,
            transaction_id TEXT NULL,
            payment_method TEXT NULL,
            payment_status TEXT NULL,
            amount DECIMAL(10,2) NULL,
            izipay_order_id TEXT NULL
        )');

        $oldRows = DB::table('purchases')->get();
        foreach ($oldRows as $row) {
            $arr = (array) $row;
            $arr['user_id'] = $arr['user_id'] ?? 0;
            DB::table('purchases_v1')->insert($arr);
        }

        Schema::drop('purchases');
        DB::statement('ALTER TABLE purchases_v1 RENAME TO purchases');
        DB::statement('PRAGMA foreign_keys=on');
    }
};
