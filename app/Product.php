<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'price',
        'qty',
        'unit',
        'waybillTitle',
        'contractTitle',
        'date',
        'warehouseTitle',
        'vendorCode',
        'usedQty',
        'writtenOffQty',
        'providerId',
        'snippedUserId',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'price' => 'decimal:3',
        'qty' => 'double',
        'date' => 'timestamp',
        'usedQty' => 'integer',
        'writtenOffQty' => 'integer',
        'providerId' => 'integer',
        'snippedUserId' => 'integer',
    ];
    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'snippedUserId')->withTrashed();
    }
    public function provider()
    {
        return $this->hasOne(\App\Provider::class, 'id', 'providerId')->withTrashed();
    }
    public function providerId()
    {
        return $this->belongsTo(\App\Provider::class);
    }
    public function snippedUserId()
    {
        return $this->belongsTo(\App\User::class);
    }
}
