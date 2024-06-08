<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    use HasFactory;

    protected $searchable = [
        'columns' => [
            'name' => 10,
        ],
    ];

    protected $guarded = [];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
