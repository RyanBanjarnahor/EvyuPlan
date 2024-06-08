<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Event extends Model
{
    use HasFactory, SearchableTrait;

    protected $guarded = ['id'];

    protected $searchable = [
        'columns' => [
            'title' => 10,
            'description' => 5,
            'location' => 2,
            'category_types.name' => 8, // Corrected column name for categories
        ],
        'joins' => [
            'categories' => ['events.id', 'categories.event_id'],
            'category_types' => ['categories.category_type_id', 'category_types.id'],
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "applicant");
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function posters()
    {
        return $this->hasOne(Poster::class);
    }

    public function eventRequests()
    {
        return $this->hasMany(EventRequest::class);
    }   
}
