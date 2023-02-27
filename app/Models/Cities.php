<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'id',
        'city',
        'latitude',
        'longitude',
        'region_id',
        'created_at',
        'updated_at'
    ];    

    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'region_id');
    }
}
