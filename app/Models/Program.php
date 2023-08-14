<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';
    public $primaryKey = 'id';

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
