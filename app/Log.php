<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userId',
        'oldValue',
        'newValue',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'userId' => 'integer',
    ];
    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'userId');
    }
    public function userId()
    {
        return $this->belongsTo(\App\User::class);
    }
}
