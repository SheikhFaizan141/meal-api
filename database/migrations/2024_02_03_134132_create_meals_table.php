<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// {
//     "id": 1,
//     "name": "Lemon Chicken",
//     "slug": "lemon-chicken",
//     "title": "",
//     "img": "",
//     "description": "Lemon, chicken, dried chilli, garlic and some seriously delectable sugarcane juice is all you need for this fantastic recipe",
//     "price": 200,
//     "ingridents": [],
//     "rating": 4.5
// },
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // $table->string('slug')->unique();
            $table->string('title');
            $table->string('url');
            $table->text('description');
            $table->boolean('is_veg');
            $table->integer('price');
            $table->unsignedDecimal('rating', 2, 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
