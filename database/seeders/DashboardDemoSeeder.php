<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Customer;
use Carbon\Carbon;

class DashboardDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Creating dashboard demo data...');

        // Get existing data
        $products = Product::take(10)->get();
        $users = User::role(['admin', 'staff'])->take(3)->get();

        if ($products->isEmpty()) {
            $this->command->warn('⚠️  No products found. Please run ProductSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->warn('⚠️  No admin/staff users found. Please create some users with roles first.');
            return;
        }

        // Create customers if they don't exist
        $customers = Customer::count();
        if ($customers < 10) {
            $this->command->info('📝 Creating customers...');
            for ($i = 0; $i < 15; $i++) {
                Customer::create([
                    'name' => fake()->name(),
                    'phone' => fake()->phoneNumber(),
                    'address' => fake()->address(),
                ]);
            }
        }

        // Generate sales for the last 30 days
        $this->command->info('💰 Creating sales data...');
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $salesCount = rand(2, 8); // 2-8 sales per day

            for ($j = 0; $j < $salesCount; $j++) {
                $customer = Customer::inRandomOrder()->first();
                
                $sale = Sale::create([
                    'user_id' => $users->random()->id,
                    'order_number' => 'ORD-' . $date->format('Ymd') . '-' . str_pad(($i * 10 + $j + 1), 3, '0', STR_PAD_LEFT),
                    'customer_name' => $customer ? $customer->name : fake()->name(),
                    'customer_email' => fake()->email(),
                    'customer_phone' => fake()->phoneNumber(),
                    'payment_method' => fake()->randomElement(['cash', 'card', 'mobile_payment']),
                    'subtotal' => 0,
                    'tax' => 0,
                    'shipping' => 0,
                    'total' => 0,
                    'total_price' => 0, // Add this field
                    'status' => fake()->randomElement(['completed', 'pending', 'processing', 'cancelled']),
                    'created_at' => $date->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                    'updated_at' => $date->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                ]);

                // Add 1-5 items to each sale
                $itemCount = rand(1, 5);
                $subtotal = 0;

                for ($k = 0; $k < $itemCount; $k++) {
                    $product = $products->random();
                    $quantity = rand(1, 3);
                    $price = $product->sale_price;
                    $itemTotal = $quantity * $price;
                    $subtotal += $itemTotal;

                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name_en,
                        'quantity' => $quantity,
                        'qty' => $quantity, // For backward compatibility
                        'price' => $price,
                    ]);
                }

                // Update sale totals
                $tax = $subtotal * 0.1; // 10% tax
                $shipping = $subtotal > 100 ? 0 : 10; // Free shipping over $100
                $total = $subtotal + $tax + $shipping;

                $sale->update([
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping' => $shipping,
                    'total' => $total,
                    'total_price' => $total, // Update both fields
                ]);
            }
        }

        // Create attendance records for the last 7 days
        $this->command->info('⏰ Creating attendance data...');
        foreach ($users as $user) {
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                
                // 85% chance of attendance
                if (rand(1, 100) <= 85) {
                    $clockIn = $date->copy()->setHour(rand(7, 9))->setMinute(rand(0, 59));
                    $clockOut = null;
                    
                    // 90% chance of clocking out (some might still be working today)
                    if (rand(1, 100) <= 90 || $i > 0) {
                        $clockOut = $clockIn->copy()->addHours(rand(7, 9))->addMinutes(rand(0, 59));
                    }

                    Attendance::create([
                        'user_id' => $user->id,
                        'date' => $date->toDateString(),
                        'clock_in' => $clockIn->format('H:i:s'),
                        'clock_out' => $clockOut ? $clockOut->format('H:i:s') : null,
                        'status' => 'present',
                        'created_at' => $clockIn,
                        'updated_at' => $clockOut ?: $clockIn,
                    ]);
                }
            }
        }

        // Set some products to low stock for alerts
        $this->command->info('📦 Setting up low stock alerts...');
        $lowStockProducts = Product::inRandomOrder()->take(4)->get();
        foreach ($lowStockProducts as $product) {
            $product->update([
                'qty' => rand(1, $product->alert_qty),
            ]);
        }

        // Create some recent high-value sales for notifications
        $this->command->info('🔔 Creating recent high-value sales...');
        for ($i = 0; $i < 3; $i++) {
            $customer = Customer::inRandomOrder()->first();
            $sale = Sale::create([
                'user_id' => $users->random()->id,
                'order_number' => 'ORD-' . now()->format('Ymd') . '-' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT),
                'customer_name' => $customer ? $customer->name : fake()->name(),
                'customer_email' => fake()->email(),
                'customer_phone' => fake()->phoneNumber(),
                'payment_method' => 'card',
                'subtotal' => 0,
                'tax' => 0,
                'shipping' => 0,
                'total' => 0,
                'total_price' => 0, // Add this field
                'status' => 'completed',
                'created_at' => now()->subMinutes(rand(5, 30)),
            ]);

            // Add high-value items
            $subtotal = 0;
            for ($j = 0; $j < rand(2, 4); $j++) {
                $product = $products->random();
                $quantity = rand(2, 5);
                $price = $product->sale_price;
                $itemTotal = $quantity * $price;
                $subtotal += $itemTotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name_en,
                    'quantity' => $quantity,
                    'qty' => $quantity, // For backward compatibility
                    'price' => $price,
                ]);
            }

            $tax = $subtotal * 0.1;
            $total = $subtotal + $tax;

            $sale->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'total_price' => $total, // Update both fields
            ]);
        }

        $this->command->info('✅ Dashboard demo data created successfully!');
        $this->command->newLine();
        $this->command->info('📊 Created:');
        $this->command->info('• Sales data for the last 30 days');
        $this->command->info('• Employee attendance records');
        $this->command->info('• Low stock alerts');
        $this->command->info('• Recent high-value sales');
        $this->command->info('• Customer records');
        $this->command->newLine();
        $this->command->info('🎯 You can now visit /dashboard to see the super admin dashboard!');
    }
}
