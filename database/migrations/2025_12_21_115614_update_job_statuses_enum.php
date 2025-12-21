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
        DB::statement("ALTER TABLE jobs MODIFY COLUMN status ENUM('open', 'in_progress', 'waiting_for_review', 'waiting_for_payment', 'payment_verification', 'completed', 'cancelled') DEFAULT 'open'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE jobs MODIFY COLUMN status ENUM('open', 'in_progress', 'completed', 'cancelled') DEFAULT 'open'");
    }
};
