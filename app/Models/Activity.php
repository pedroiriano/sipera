<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';
    public $primaryKey = 'id';

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
