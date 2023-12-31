<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Realization extends Model
{
    use HasFactory;

    protected $table = 'realizations';
    public $primaryKey = 'id';

    public function subactivity()
    {
        return $this->belongsTo(SubActivity::class, 'sub_activity_id');
    }
}
