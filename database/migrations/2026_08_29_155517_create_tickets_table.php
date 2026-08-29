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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference', 32)->unique();
            $table->string('customer_name', 120);
            $table->string('email', 191);
            $table->string('phone', 32);
            $table->text('ticket_description');
            // 'new' | 'opened' | 'replied' | 'closed'
            $table->string('status', 20)->default('new')->index();
            $table->timestamp('opened_at')->nullable();
            $table->timestamps();
            // add db index for customer_name to improve db search.
            $table->index('customer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
