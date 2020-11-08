<?php
//
//use Illuminate\Support\Facades\Schema;
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Database\Migrations\Migration;
//
//class CreateProductsTable extends Migration
//{
//    /**
//     * Run the migrations.
//     *
//     * @return void
//     */
//    public function up()
//    {
//        Schema::create('products', function (Blueprint $table) {
//            $table->increments('id');
//            $table->timestamps();
//            $table->string('title');
//            $table->integer('category_id')->unsigned();
//            $table->foreign('category_id')->references('id')->on('categories');
//            $table->integer('subcategory_id')->unsigned();
//            $table->foreign('subcategory_id')->references('id')->on('subcategories');
//            $table->integer('brand_id')->unsigned();
//            $table->foreign('brand_id')->references('id')->on('brands');
//            $table->longText('description');
//            $table->longText('image')->nullable();
//            $table->double('price', 2);
//            $table->string('top')->nullable();
//        });
//
//    }
//
//    /**
//     * Reverse the migrations.
//     *
//     * @return void
//     */
//    public function down()
//    {
//        // Schema::dropIfExists('products');
//    }
//}
