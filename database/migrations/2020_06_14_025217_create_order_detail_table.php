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
            $table->engine = 'MyISAM';
            $table->collation = 'latin1_swedish_ci';
            $table->charset = 'latin1';
            $table->integer('id')->autoIncrement()->comment('自动编号');
            $table->integer('order_no')->nullable(false)->comment('订单编号');
            $table->char('product_no', 15)->charset('latin1')->collation('latin1_swedish_ci')->nullable(false)
                ->comment('产品编号');
            $table->string('product_name', 15)->charset('latin1')->collation('latin1_swedish_ci')->nullable(false)
                ->comment('产品名称');
            $table->json('product_params')->nullable(false)->comment('JSON格式的产品参数');
            $table->integer('product_count')->nullable(false)->comment('产品数量');
            $table->integer('product_price')->nullable(false)->comment('价格');
            $table->string('customer_comments', 50)->charset('latin1')->collation('latin1_swedish_ci')->nullable(false)
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
