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
        $this->call([
            CartSeeder::class,
            CategorySeeder::class,
            CheckoutSeeder::class,
            ContactSeeder::class,
            CouponSeeder::class,
            FaqSeeder::class,
            OfferSeeder::class,
            ProductSeeder::class,
            ReviewSeeder::class,
            SubscriberSeeder::class,
        ]);
         User::factory(1)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }


}
