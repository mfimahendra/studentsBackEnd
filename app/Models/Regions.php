<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    use HasFactory;

    protected $table = 'regions';

    protected $fillable = [
        'id',
        'region',
        'created_at',
        'updated_at'
    ];

    public function cities()
    {
        return $this->hasMany('App\Models\Cities', 'region_id');
    }
}
