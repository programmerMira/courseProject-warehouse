<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailsDictionary extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'qty',
        'unit',
        'transportId',
        'productId',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'qty' => 'double',
        'transportId' => 'integer',
        'productId' => 'integer',
    ];
    public function product()
    {
        return $this->hasOne(\App\Product::class, 'id', 'productId');
    }
    public function transport()
    {
        return $this->hasOne(\App\Transport::class, 'id', 'transportId');
    }

    public function transportId()
    {
        return $this->belongsTo(\App\Transport::class);
    }

    public function productId()
    {
        return $this->belongsTo(\App\Product::class);
    }
}
