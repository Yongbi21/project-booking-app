<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceQuote extends Model
{
    use HasFactory;


    protected $fillable = [
        'project_request_id',
        'project_complexity',
        'estimate_time',
        'additional_services',
        'total_amount',

    ];
}
