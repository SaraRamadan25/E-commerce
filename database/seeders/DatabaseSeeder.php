<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Checkout;
use App\Models\City;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Faq;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Review;
use App\Models\State;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory()->create();
        Checkout::factory()->create();
        Contact::factory()->create();
        Faq::factory()->create();
        Offer::factory()->create();
        Subscriber::factory()->create();
        User::factory()->create();
        Cart::factory()->create();
        Product::factory()->create();
        Review::factory()->create();
        Country::factory()->create();
        State::factory()->create();
        City::factory()->create();

Coupon::factory()->create([
            'code' => 'ABC123',
            'type' => 'fixed',
            'value' => 30,
        ]);

        Coupon::factory()->create([
            'code' => 'DEF456',
            'type' => 'percent',
            'percent_off' => 50,
        ]);



        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }


}
