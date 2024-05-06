<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatistic extends Model
{
    use HasFactory;
    protected $table = 'order_statistics';

    protected $fillable = [
        'year',
        'month',
        'order_count',
    ];
}
