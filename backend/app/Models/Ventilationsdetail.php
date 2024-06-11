<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ventilationsdetail extends Model
{


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'ventilation_id',
        'user_id',
        'semaine',
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'hn',
        'hs15',
        'hs26',
        'hs55',
        'hs30',
        'hs60',
        'hs115',
        'hs130',
        'total',
        'extra_attributes',
        'created_at',
        'updated_at',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'user',


        'ventilation',


    ];
    protected $appends = [

    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'ventilationsdetails';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ventilation()
    {
        return $this->belongsTo(Ventilation::class, 'ventilation_id', 'id');
    }

    public function getVentilationIdAttribute($value)
    {
        return $value;
    }

    public function setVentilationIdAttribute($value)
    {
        $this->attributes['ventilation_id'] = $value ?? "";
    }

    public function getSemaineAttribute($value)
    {
        return $value;
    }

    public function setSemaineAttribute($value)
    {
        $this->attributes['semaine'] = $value ?? "";
    }

    public function getDimancheAttribute($value)
    {
        return $value;
    }

    public function setDimancheAttribute($value)
    {
        $this->attributes['dimanche'] = $value ?? "";
    }

    public function getLundiAttribute($value)
    {
        return $value;
    }

    public function setLundiAttribute($value)
    {
        $this->attributes['lundi'] = $value ?? "";
    }

    public function getMardiAttribute($value)
    {
        return $value;
    }

    public function setMardiAttribute($value)
    {
        $this->attributes['mardi'] = $value ?? "";
    }

    public function getMercrediAttribute($value)
    {
        return $value;
    }

    public function setMercrediAttribute($value)
    {
        $this->attributes['mercredi'] = $value ?? "";
    }

    public function getJeudiAttribute($value)
    {
        return $value;
    }

    public function setJeudiAttribute($value)
    {
        $this->attributes['jeudi'] = $value ?? "";
    }

    public function getVendrediAttribute($value)
    {
        return $value;
    }

    public function setVendrediAttribute($value)
    {
        $this->attributes['vendredi'] = $value ?? "";
    }

    public function getSamediAttribute($value)
    {
        return $value;
    }

    public function setSamediAttribute($value)
    {
        $this->attributes['samedi'] = $value ?? "";
    }

    public function getHnAttribute($value)
    {
        return $value;
    }

    public function setHnAttribute($value)
    {
        $this->attributes['hn'] = $value ?? "";
    }

    public function getHs15Attribute($value)
    {
        return $value;
    }

    public function setHs15Attribute($value)
    {
        $this->attributes['hs15'] = $value ?? "";
    }

    public function getHs26Attribute($value)
    {
        return $value;
    }

    public function setHs26Attribute($value)
    {
        $this->attributes['hs26'] = $value ?? "";
    }

    public function getHs55Attribute($value)
    {
        return $value;
    }

    public function setHs55Attribute($value)
    {
        $this->attributes['hs55'] = $value ?? "";
    }

    public function getHs30Attribute($value)
    {
        return $value;
    }

    public function setHs30Attribute($value)
    {
        $this->attributes['hs30'] = $value ?? "";
    }

    public function getHs60Attribute($value)
    {
        return $value;
    }

    public function setHs60Attribute($value)
    {
        $this->attributes['hs60'] = $value ?? "";
    }

    public function getHs115Attribute($value)
    {
        return $value;
    }

    public function setHs115Attribute($value)
    {
        $this->attributes['hs115'] = $value ?? "";
    }

    public function getHs130Attribute($value)
    {
        return $value;
    }

    public function setHs130Attribute($value)
    {
        $this->attributes['hs130'] = $value ?? "";
    }

    public function getTotalAttribute($value)
    {
        return $value;
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = $value ?? "";
    }


}

