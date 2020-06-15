<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('order_id')->nullable(false)->comment('订单编号');
            $table->char('product_no', 15)->nullable(false)
                ->comment('产品编号');
            $table->string('product_name', 15)->nullable(false)
                ->comment('产品名称');
            $table->json('product_params')->nullable(false)->comment('JSON格式的产品参数');
            $table->integer('product_count')->nullable(false)->comment('产品数量');
            $table->integer('product_price')->nullable(false)->comment('价格');
            $table->string('customer_comments', 50)->nullable(false)
                ->comment('客户备注');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_detail');
    }
}
