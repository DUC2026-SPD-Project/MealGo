<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'invoice_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'city',
        'postal_code',
        'payment_method',
        'notes',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'total_price', // Keep for backward compatibility
        'status',
        'invoice_date',
        'due_date'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
        'total_price' => 'decimal:2',
        'invoice_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    // Relationship: One Sale has many Items
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Alias for saleItems (used in dashboard and checkout)
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
    
    // Relationship: Who sold it?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate invoice number
    public static function generateInvoiceNumber()
    {
        $prefix = 'INV-' . date('Y');
        $lastInvoice = self::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();
        
        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Get formatted invoice number
    public function getFormattedInvoiceNumberAttribute()
    {
        return $this->invoice_number ?: 'N/A';
    }

    // Get invoice status
    public function getInvoiceStatusAttribute()
    {
        if (!$this->invoice_date) {
            return 'Not Generated';
        }
        
        if ($this->status === 'completed') {
            return 'Paid';
        }
        
        if ($this->due_date && $this->due_date->isPast()) {
            return 'Overdue';
        }
        
        return 'Pending';
    }

    // Get days until due
    public function getDaysUntilDueAttribute()
    {
        if (!$this->due_date) {
            return null;
        }
        
        return now()->diffInDays($this->due_date, false);
    }
}