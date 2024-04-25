<?php

namespace App\Http\Controllers;

use Database\Factories\PostFactory;
use Faker\Factory;
use Faker\Generator as Faker;

class IndexController extends Controller
{
    public function index()
    {
        $faker = Factory::create();
        return $faker->firstNameMale;
    }
}
