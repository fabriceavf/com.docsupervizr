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


use App\Models\Contratsclient;


use App\Models\Prestation;


use App\Models\Site;


use App\Models\Contratsposte;


class Contratssite extends Model
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
        'contratsclient_id',
        'site_id',
        'prestation_id',
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


        'contratsclient',


        'prestation',


        'site',


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
        $this->table = 'contratssites';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ContratssiteObservers') &&
                method_exists('\App\Observers\ContratssiteObservers', 'creating')
            ) {

                try {
                    \App\Observers\ContratssiteObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ContratssiteObservers') &&
                method_exists('\App\Observers\ContratssiteObservers', 'created')
            ) {

                try {
                    \App\Observers\ContratssiteObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ContratssiteObservers') &&
                method_exists('\App\Observers\ContratssiteObservers', 'updating')
            ) {

                try {
                    \App\Observers\ContratssiteObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ContratssiteObservers') &&
                method_exists('\App\Observers\ContratssiteObservers', 'updated')
            ) {

                try {
                    \App\Observers\ContratssiteObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ContratssiteObservers') &&
                method_exists('\App\Observers\ContratssiteObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ContratssiteObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ContratssiteObservers') &&
                method_exists('\App\Observers\ContratssiteObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ContratssiteObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function contratsclient()
    {
        return $this->belongsTo(Contratsclient::class, 'contratsclient_id', 'id');
    }

    public function prestation()
    {
        return $this->belongsTo(Prestation::class, 'prestation_id', 'id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function contratspostes()
    {
        return $this->hasMany(Contratsposte::class, 'contratssite_id', 'id');
    }

    public function getContratsclientIdAttribute($value)
    {
        return $value;
    }

    public function setContratsclientIdAttribute($value)
    {
        $this->attributes['contratsclient_id'] = $value ?? "";
    }

    public function getSiteIdAttribute($value)
    {
        return $value;
    }

    public function setSiteIdAttribute($value)
    {
        $this->attributes['site_id'] = $value ?? "";
    }

    public function getPrestationIdAttribute($value)
    {
        return $value;
    }

    public function setPrestationIdAttribute($value)
    {
        $this->attributes['prestation_id'] = $value ?? "";
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

