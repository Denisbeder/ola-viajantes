<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Promotion;
use App\PromotionParticipant;
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

$factory->define(PromotionParticipant::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'ip' => $faker->ipv4,
        'device' => $faker->userAgent,
        'is_mobile' => rand(0, 1),
        'promotion_id' => Promotion::all()->shuffle()->pluck('id')->first(),
    ];
});
