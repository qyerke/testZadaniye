<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
            'user_id' => function() {
                return factory(App\User::class)->create()->id;
            },
            'title' => $faker->sentence(5),
            'status' => $faker->randomElement($array = array ('Не Выполненные','Ждет Выполненния','Выполненные')),
            'deadline' => $faker->dateTimeBetween('now', '+1 month'),

    ];
});
