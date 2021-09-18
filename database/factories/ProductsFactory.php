<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;


$factory->define(Product::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence(3),
        'price'=>2000,
        'image'=>'image/plan/elevage/5.png',
        'categorie'=>'agriculture',
        'type'=>'plan',
        'version'=>'francais',
    


    ];
});
