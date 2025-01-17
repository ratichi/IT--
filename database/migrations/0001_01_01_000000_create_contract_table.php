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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ფიზიკური', 'ციფრული']);            
            $table->string('contract_name');
            $table->boolean('secret')->default(false);
            $table->integer('quantity');
            $table->string('agreement_number')->nullable();;
            $table->date('contract_date');
            $table->date('contract_term');
            $table->date('recive_term');
            $table->string('organization');
            $table->string('purpose');
            $table->string('funding_code');
            $table->string('guarantee_time')->default('2025/01');
            $table->string('letter_initiator');
            $table->enum('status', ['მიმდინარე', 'ჩაბარებული'])->default('მიმდინარე');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts'); // This should drop the 'contracts' table
    }
};
