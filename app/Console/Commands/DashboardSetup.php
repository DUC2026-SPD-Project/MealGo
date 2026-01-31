<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\DashboardDemoSeeder;

class DashboardSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:setup {--fresh : Clear existing data and create fresh demo data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the super admin dashboard with demo data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Setting up Super Admin Dashboard...');
        $this->newLine();

        if ($this->option('fresh')) {
            $this->warn('⚠️  This will clear existing sales and attendance data!');
            if (!$this->confirm('Are you sure you want to continue?')) {
                $this->info('Operation cancelled.');
                return 0;
            }

            // Clear existing data
            $this->info('🗑️  Clearing existing data...');
            \App\Models\SaleItem::query()->delete();
            \App\Models\Sale::query()->delete();
            \App\Models\Attendance::query()->delete();
            $this->info('✅ Data cleared successfully.');
            $this->newLine();
        }

        // Run the seeder
        $this->info('📊 Creating demo data...');
        $seeder = new DashboardDemoSeeder();
        $seeder->setCommand($this);
        $seeder->run();

        $this->newLine();
        $this->info('🎉 Super Admin Dashboard setup completed!');
        $this->newLine();
        
        $this->info('✨ Features available:');
        $this->info('• 📈 Real-time sales analytics');
        $this->info('• 📊 Interactive charts (Sales trend, Top products, Categories)');
        $this->info('• 🔔 Live notifications system');
        $this->info('• 👥 Employee attendance tracking');
        $this->info('• 📦 Low stock alerts');
        $this->info('• 🕐 Recent activities timeline');
        $this->info('• 📱 Responsive design with glassmorphism effects');
        
        $this->newLine();
        $this->info('🌐 Access your dashboard at: /dashboard');
        $this->info('🔄 Dashboard updates automatically every 30 seconds');
        $this->info('🔔 Notifications refresh every minute');
        
        $this->newLine();
        $this->info('💡 Pro tip: The dashboard works best with admin or staff role users!');

        return 0;
    }
}
