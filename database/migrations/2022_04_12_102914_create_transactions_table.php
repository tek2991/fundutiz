<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fund_id')->constrained();
            $table->foreignId('team_id')->constrained();
            $table->string('type');
            $table->string('status')->nullable();
            $table->date('sactioned_at');
            $table->bigInteger('amount_in_cents');
            $table->string('item')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('file_number')->nullable();
            $table->boolean('is_gem')->nullable();
            $table->string('non_gem_remark')->nullable();
            $table->boolean('gem_non_availability')->nullable();
            $table->string('gem_non_availability_remark')->nullable();
            $table->foreignId('sanctioner_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
