<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


use App\Models\Contratssite;


use App\Models\Poste;


use App\Models\Contratsagent;


class Contratsposte extends Model
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
        'contratssite_id',
        'poste_id',
        'jours',
        'agentsjour',
        'agentsnuit',
        'created_at',
        'updated_at',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'contratssite',


        'poste',


    ];
    protected $appends = [
        'Selectvalue', 'Selectlabel'
    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'contratspostes';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ContratsposteObservers') &&
                method_exists('\App\Observers\ContratsposteObservers', 'creating')
            ) {

                try {
                    \App\Observers\ContratsposteObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ContratsposteObservers') &&
                method_exists('\App\Observers\ContratsposteObservers', 'created')
            ) {

                try {
                    \App\Observers\ContratsposteObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ContratsposteObservers') &&
                method_exists('\App\Observers\ContratsposteObservers', 'updating')
            ) {

                try {
                    \App\Observers\ContratsposteObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ContratsposteObservers') &&
                method_exists('\App\Observers\ContratsposteObservers', 'updated')
            ) {

                try {
                    \App\Observers\ContratsposteObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ContratsposteObservers') &&
                method_exists('\App\Observers\ContratsposteObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ContratsposteObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ContratsposteObservers') &&
                method_exists('\App\Observers\ContratsposteObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ContratsposteObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function contratssite()
    {
        return $this->belongsTo(Contratssite::class, 'contratssite_id', 'id');
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id', 'id');
    }

    public function contratsagents()
    {
        return $this->hasMany(Contratsagent::class, 'contratsposte_id', 'id');
    }

    public function getContratssiteIdAttribute($value)
    {
        return $value;
    }

    public function setContratssiteIdAttribute($value)
    {
        $this->attributes['contratssite_id'] = $value ?? "";
    }

    public function getPosteIdAttribute($value)
    {
        return $value;
    }

    public function setPosteIdAttribute($value)
    {
        $this->attributes['poste_id'] = $value ?? "";
    }

    public function getJoursAttribute($value)
    {
        return $value;
    }

    public function setJoursAttribute($value)
    {
        $this->attributes['jours'] = $value ?? "";
    }

    public function getAgentsjourAttribute($value)
    {
        return $value;
    }

    public function setAgentsjourAttribute($value)
    {
        $this->attributes['agentsjour'] = $value ?? "";
    }

    public function getAgentsnuitAttribute($value)
    {
        return $value;
    }

    public function setAgentsnuitAttribute($value)
    {
        $this->attributes['agentsnuit'] = $value ?? "";
    }

    public function getIdentifiantsSadgeAttribute($value)
    {
        return $value;
    }

    public function setIdentifiantsSadgeAttribute($value)
    {
        $this->attributes['identifiants_sadge'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        $select = "";
        try {
            $select = $this->id;
        } catch (\Throwable $e) {

        }


        $select = " " . $this->id;


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";
        try {
            $select = $this->libelle;
        } catch (\Throwable $e) {

        }


        return trim($select);


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

