<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string("title")->index()->comment("帖子标题");
            $table->text("body")->comment("帖子内容");
            $table->integer("user_id")->unsigned()->comment("关联用户id");
            $table->integer("category_id")->unsigned()->comment("关联分类话题id");
            $table->integer("reply_count")->unsigned()->nullable()->default(0)->comment("回复数量");
            $table->integer("view_count")->unsigned()->nullable()->default(0)->comment("查看数");
            $table->integer("last_reply_user_id")->unsigned()->nullable()->comment("最后回复的用户id");
            $table->integer("order")->default(0)->nullable()->comment("排序字段");
            $table->string("slug")->nullable()->comment("seo 友好的url");
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
        Schema::dropIfExists('topics');
    }
}
