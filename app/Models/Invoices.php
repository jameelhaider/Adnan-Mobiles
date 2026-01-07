<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_items',
        'total_bill',
        'profit',
        'invoice_id',
        'invoice_to',
        'account_id',
        'prev_balance',
        'status',
    ];
}
