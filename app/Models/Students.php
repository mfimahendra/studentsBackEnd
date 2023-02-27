<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'passport',
        'name',
        'birthday',
        'birthplace',
        'sex',
        'origin',
        'major',
        'degree',
        'start_year',
        'finish_year',
        'wechat_id',
        'phone',
        'emergency_phone',
        'email',
        'scholarship',
        'scholarship_type',
        'agency',
        'university_id',
        'created_at',
        'updated_at'
    ];   

    public function university()
    {
        return $this->belongsTo('App\Models\Universities', 'university_id');
    }

}
