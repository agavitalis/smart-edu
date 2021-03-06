<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolFeeInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_fee_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('invoice_number');
            $table->string('session');
            $table->string('level');
            $table->string('term');
            $table->string('amount')->nullable();
            $table->string('amount_paid')->nullable();
            $table->enum('status', ['NOT PAID', 'PARTLY PAID', 'PAID'])->default("NOT PAID");
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('school_fee_invoices');
    }
}
