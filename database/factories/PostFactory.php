<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title'=>$faker->sentence(3),
        'slug'=>$faker->slug(4),
        'description'=>$faker->sentence(20),
        'image'=>'https:://placeholder.com/400',
        'categorie'=>'agriculture',
        'user_id'=>1,
    ];
});
