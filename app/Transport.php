<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transport extends Model
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
        'creationDate',
        'commissioningDate',
        'detailsUpdateDate',
        'number',
        'typeId',
        'brand',
        'model',
        'chassis_engine_number',
        'engine_volume',
        'weight',
        'color',
        'certificate',
        'factory_number',
        'rent'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'creationDate' => 'timestamp',
        'commissioningDate' => 'timestamp',
        'detailsUpdateDate' => 'timestamp',
        'typeId' => 'integer',
        'weight' => 'double',
        'engine_volume' => 'double',
    ];
    public function transport_type()
    {
        return $this->hasOne(\App\TransportType::class, 'id', 'typeId');
    }

    public function transportTypeId()
    {
        return $this->belongsTo(\App\TransportType::class);
    }
}
