<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandsProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'command_id',
        'product_id'
    ];
}
