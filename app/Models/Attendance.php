<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // ✅ Allow mass assignment for these fields
    protected $fillable = ['employee_id', 'latitude', 'longitude', 'distance'];
}