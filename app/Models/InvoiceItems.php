<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'invoice_id',
        'qty',
        'price',
        'total',
        'stock_id',
        'status',
        'partial_qty'
    ];
}
