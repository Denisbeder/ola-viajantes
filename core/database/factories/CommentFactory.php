<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Comment;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'text' => $faker->text,
        'ip' => $faker->ipv4,
        'device' => $faker->userAgent,
        'is_mobile' => rand(0,1),
        'commentable_type' => 'App\Post',
        'commentable_id' => 17,
    ];
});
