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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nodin_id')->constrained();
            $table->foreignId('customer_product_id')->constrained();
            $table->string('invoice_subject');
            $table->string('description');
            $table->decimal('amount', 15, 2);
            $table->string('file_path');
            $table->date('date');
            $table->date('due_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
