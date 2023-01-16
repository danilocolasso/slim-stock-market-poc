<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class StockMarket extends Model
{
    protected $table = 'stock_market';
    protected $fillable = [
        'symbol',
        'date',
        'time',
        'open',
        'high',
        'low',
        'close',
        'volume',
        'name',
    ];
    protected $casts = [
        'date' => 'date:Y-m-d',
    ];
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
}