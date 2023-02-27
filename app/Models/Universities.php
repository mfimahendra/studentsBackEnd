<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universities extends Model
{
    use HasFactory;

    protected $table = 'universities';

    protected $fillable = [
        'id',
        'university_name',
        'city_id',
        'created_at',
        'updated_at'
    ];

    public function city()
    {
        return $this->belongsTo('App\Models\Cities', 'city_id');
    }
}
