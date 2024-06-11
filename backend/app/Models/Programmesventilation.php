<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;


class Programmesventilation extends Model
{


    use SchemalessAttributesTrait;
    use SoftDeletes;


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'dimanche',
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'statut',
        'actif',
        'programmation_id',
        'user_id',
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


        'programmation',


        'user',


    ];
    protected $appends = [

    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'programmesventilations';
    }

    public function programmation()
    {
        return $this->belongsTo(Programmation::class, 'programmation_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

    public function getStatutAttribute($value)
    {
        return $value;
    }

    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = $value ?? "";
    }

    public function getActifAttribute($value)
    {
        return $value;
    }

    public function setActifAttribute($value)
    {
        $this->attributes['actif'] = $value ?? "";
    }

    public function getProgrammationIdAttribute($value)
    {
        return $value;
    }

    public function setProgrammationIdAttribute($value)
    {
        $this->attributes['programmation_id'] = $value ?? "";
    }

    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }

    public function scopeWithOtherExtraAttributes(): Builder
    {
        return $this->other_extra_attributes->modelScope();
    }


}

