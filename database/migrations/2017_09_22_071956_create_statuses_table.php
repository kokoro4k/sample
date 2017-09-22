<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('info');    //用于储存微博的内容
            $table->integer('user_id')->index();    //用于储存微博发布者的个人 id
            $table->index(['created_at']);
            $table->timestamps();   //timestamps 方法会为微博数据表生成一个微博创建时间字段 created_at 和一个微博更新时间字段 updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
