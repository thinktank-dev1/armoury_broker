<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\DeliverOption;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PersistentTestSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure User 1 (Seller) and Vendor 1 exist
        $seller = User::find(1);
        if (!$seller) {
            $this->command->error("User ID 1 not found. Please run existing seeders first.");
            return;
        }
        $vendor1 = Vendor::find(1);

        // 2. Ensure User 2 (Buyer) and Vendor 2 exist
        $buyer = User::find(2);
        if (!$buyer) {
            $this->command->error("User ID 2 not found. Please run existing seeders first.");
            return;
        }
        $vendor2 = Vendor::find(2);

        // 3. Create/Find a Product for Seller
        $cat = Category::first();
        $sub = SubCategory::where('category_id', $cat->id)->first();
        $brand = Brand::first();

        $product = Product::updateOrCreate(
            ['item_name' => 'Persistent Test Product'],
            [
                'featured' => 1,
                'vendor_id' => $vendor1->id,
                'user_id' => $seller->id,
                'brand_id' => $brand->id,
                'category_id' => $cat->id,
                'sub_category_id' => $sub->id,
                'listing_type' => 'For Sale',
                'item_description' => 'A test product that persists in the database for testing transactions.',
                'condition' => 'New',
                'quantity' => 10,
                'service_fee_payer' => 'buyer',
                'item_price' => 1000,
                'status' => 1,
            ]
        );

        // 4. Ensure a delivery option exists for the product
        $delivery = DeliverOption::updateOrCreate(
            ['product_id' => $product->id, 'type' => 'Standard Courier'],
            ['price' => 150]
        );

        // 5. Create a persistent successful Order
        $uuid = (string) Str::uuid();
        $order = Order::updateOrCreate(
            ['uuid' => 'persistent-test-order-uuid'],
            [
                'user_id' => $buyer->id,
                'vendor_id' => $vendor1->id, // Seller's Vendor
                'cart_total' => 1000,
                'fee' => 50,
                'total_shipping_fee' => 150,
                'amount_paid' => 1200, // Price + Fee + Shipping
                'status' => 'Paid',
                'shipping_status' => 0,
                'receipt_status' => 0,
                'g_payment_id' => 'PAYGATE-12345',
                'short_reference' => 'TEST-REF',
            ]
        );

        // 6. Create Order Item
        OrderItem::updateOrCreate(
            ['order_id' => $order->id, 'product_id' => $product->id],
            [
                'user_id' => $buyer->id,
                'vendor_id' => $vendor1->id,
                'price' => 1000,
                'unit_price' => 1000,
                'total_paid' => 1200,
                'quantity' => 1,
                'shipping_price' => 150,
                'service_fee' => 50,
                'vendor_status' => 'Pending',
                'buyer_status' => 'Pending',
            ]
        );

        // 7. Create successful Transaction
        Transaction::updateOrCreate(
            ['order_id' => $order->id, 'transaction_type' => 'order_payment'],
            [
                'name' => 'Order Payment from ' . $buyer->name,
                'user_id' => $buyer->id,
                'vendor_id' => $vendor1->id,
                'direction' => 'in',
                'amount' => 1200,
                'code' => 'PAYGATE-12345',
                'payment_status' => 'Success',
                'release' => 1,
            ]
        );

        $this->command->info("Persistent test case set up successfully.");
    }
}
