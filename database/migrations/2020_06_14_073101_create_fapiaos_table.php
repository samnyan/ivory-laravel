<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFapiaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fapiaos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('order_id')->nullable(false)->comment('订单号');
            $table->boolean('is_vat')->nullable(false)->comment('是否增值税发票');
            $table->string('fp_title', 100)->nullable(false)->comment('发票抬头名称');
            $table->string('fp_content', 255)->nullable(false)->comment('发票内容');
            $table->float('fp_amount')->nullable(false)->comment('发票金额');
            $table->string('fp_tax_no', 20)->nullable(false)->comment('发票税号');
            $table->integer('fp_tax')->nullable(false)->comment('税率');
            $table->string('vat_company_name', 100)->nullable(false)->comment('公司名称');
            $table->string('vat_company_address', 100)->nullable(false)->comment('公司地址');
            $table->string('vat_telephone', 20)->nullable(false)->comment('联系电话');
            $table->string('vat_bank_name', 50)->nullable(false)->comment('开户银行');
            $table->string('vat_bank_account', 20)->nullable(false)->comment('银行帐号');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fapiaos');
    }
}
