<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailsCard extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'document',
        'qty',
        'unit',
        'productId',
        'transportId',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'timestamp',
        'qty' => 'double',
        'productId' => 'integer',
        'transportId' => 'integer',
    ];

    public function product()
    {
        return $this->hasOne(\App\Product::class, 'id', 'productId');
    }
    public function transport()
    {
        return $this->hasOne(\App\Transport::class, 'id', 'transportId');
    }

    public function productId()
    {
        return $this->belongsTo(\App\Product::class);
    }

    public function transportId()
    {
        return $this->belongsTo(\App\Transport::class);
    }
}
