<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Role;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed necessary settings
        Setting::create(['name' => 'service_fee', 'value' => 5]);
        Setting::create(['name' => 'min_fee_amount', 'value' => 25]);

        // Create Roles with description
        Role::create(['id' => 1, 'name' => 'Admin', 'description' => 'Admin User']);
        Role::create(['id' => 2, 'name' => 'Vendor', 'description' => 'Vendor User']);
    }

    public function test_user_a_purchases_product_from_user_b()
    {
        Mail::fake();

        // Unguard models to allow setting IDs and other non-fillable fields
        User::unguard();
        Vendor::unguard();
        Product::unguard();
        OrderItem::unguard();
        Order::unguard();
        Transaction::unguard();
        Category::unguard();
        SubCategory::unguard();
        Brand::unguard();

        // Create User B (Seller) with ID 3
        $vendorB = Vendor::create([
            'id' => 3,
            'name' => 'Vendor B',
            'url_name' => 'vendor-b',
            'status' => 1,
            'suburb' => 'Suburb B',
            'city' => 'City B',
        ]);
        $userB = User::create([
            'id' => 3,
            'role_id' => 2,
            'vendor_id' => $vendorB->id,
            'name' => 'User B',
            'surname' => 'Seller',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
            'status' => 1,
            'email_verified_at' => now(),
        ]);

        // Create User A (Buyer) with ID 2
        $vendorA = Vendor::create([
            'id' => 2,
            'name' => 'Vendor A',
            'url_name' => 'vendor-a',
            'status' => 1,
            'suburb' => 'Suburb A',
            'city' => 'City A',
        ]);
        $userA = User::create([
            'id' => 2,
            'role_id' => 2,
            'vendor_id' => $vendorA->id,
            'name' => 'User A',
            'surname' => 'Buyer',
            'email' => 'buyer@example.com',
            'password' => bcrypt('password'),
            'status' => 1,
            'email_verified_at' => now(),
        ]);

        // Create Category, SubCategory, Brand
        $category = Category::create(['id' => 1, 'category_name' => 'Firearms', 'slug' => 'firearms']);
        $subCategory = SubCategory::create(['id' => 1, 'category_id' => $category->id, 'sub_category_name' => 'Handguns', 'slug' => 'handguns']);
        $brand = Brand::create(['id' => 1, 'brand_name' => 'Glock', 'slug' => 'glock']);

        // Create Product for User B/Vendor B
        $product = Product::create([
            'id' => 1,
            'vendor_id' => $vendorB->id,
            'user_id' => $userB->id,
            'brand_id' => $brand->id,
            'category_id' => $category->id,
            'sub_category_id' => $subCategory->id,
            'item_name' => 'Glock 17',
            'item_description' => 'A reliable handgun',
            'listing_type' => 'For Sale',
            'condition' => 'New',
            'item_price' => 1000,
            'quantity' => 1,
            'status' => 1,
            'service_fee_payer' => 'buyer',
        ]);

        // User A adds product to cart (OrderItem with order_id = null)
        $orderItem = OrderItem::create([
            'id' => 1,
            'user_id' => $userA->id,
            'vendor_id' => $vendorB->id,
            'product_id' => $product->id,
            'price' => $product->item_price,
            'quantity' => 1,
            'service_fee' => 50, // 5% of 1000
            'total_paid' => 1050, // 1000 + 50
        ]);

        // Simulate creating the order
        $order = Order::create([
            'id' => 1,
            'user_id' => $userA->id,
            'vendor_id' => $vendorB->id,
            'cart_total' => 1050,
            'fee' => 50,
            'status' => 'PENDING',
        ]);

        $orderItem->update(['order_id' => $order->id]);

        // Act: Simulate PayFast notification callback
        $response = $this->post("/pf-notify-payment/{$order->id}", [
            'payment_status' => 'COMPLETE',
            'pf_payment_id' => '123456',
            'amount_gross' => 1050,
        ]);

        // Assertions
        $order->refresh();
        $this->assertEquals('COMPLETE', $order->status);
        $this->assertEquals('123456', $order->g_payment_id);
        $this->assertEquals(1050, $order->amount_paid);

        // Verify transactions
        // Transaction for service fee from User A
        $this->assertDatabaseHas('transactions', [
            'name' => 'service_fee',
            'transaction_type' => 'service_fee',
            'user_id' => $userA->id,
            'direction' => 'out',
            'amount' => 50,
            'order_id' => $order->id,
            'order_item_id' => $orderItem->id,
            'payment_status' => 'COMPLETE',
        ]);

        // Transaction for payment to User B
        $this->assertDatabaseHas('transactions', [
            'name' => 'order_payment',
            'transaction_type' => 'payfast_payment',
            'user_id' => $userB->id,
            'direction' => 'in',
            'amount' => 1000, // 1050 - 50 fee
            'order_id' => $order->id,
            'order_item_id' => $orderItem->id,
            'payment_status' => 'COMPLETE',
        ]);
    }
}
