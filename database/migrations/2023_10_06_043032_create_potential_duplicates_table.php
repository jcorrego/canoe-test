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
        Schema::create('potential_duplicates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_fund_id');
            $table->foreign('original_fund_id')->references('id')->on('funds')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('duplicate_fund_id');
            $table->foreign('duplicate_fund_id')->references('id')->on('funds')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unique(['original_fund_id', 'duplicate_fund_id']);
            $table->enum('status', ['pending', 'resolved', 'ignored'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potential_duplicates');
    }
};
