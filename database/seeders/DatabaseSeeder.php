<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Checkout;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Faq;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Review;
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
        Cart::factory(1)->create();
        Category::factory(1)->create();
        Checkout::factory(1)->create();
        Contact::factory(1)->create();
        Coupon::factory(1)->create();
        Faq::factory(1)->create();
        Offer::factory(1)->create();
        Product::factory(1)->create();
        Review::factory(1)->create();
        Subscriber::factory(1)->create();
        User::factory(1)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }


}
