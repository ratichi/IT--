<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'date_of_act',
        'number_of_act',
        'receive_date',
        'quantity',
        'guarantee_time',
    ];
}
