<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubActivity extends Model
{
    use HasFactory;

    protected $table = 'sub_activities';
    public $primaryKey = 'id';

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function realization()
    {
        return $this->hasMany(Realization::class);
    }
}
