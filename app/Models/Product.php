<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'name',
        'image',
        'description',
        'price'
    ];

    protected $hidden = ['id'];

    public function commands() {
        return $this->belongsToMany(Command::class, 'commands_products');
    }
}
