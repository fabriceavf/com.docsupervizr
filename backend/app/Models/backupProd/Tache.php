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


use App\Models\Site;


use App\Models\Typestache;


use App\Models\Ville;


use App\Models\Programmation;


use App\Models\Tachespointeuse;


use App\Models\Travailleur;


class Tache extends Model
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
        'typestache_id',
        'libelle',
        'extra_attributes',
        'created_at',
        'updated_at',
        'pastille',
        'Pointeuses',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',
        'site_id',
        'ville_id',
        'jours',
        'code',
        'maxjours',
        'maxnuits',
        'NbrsJours',
        'NbrsNuits',
        'IsCouvert',
        'Agentjour',
        'Agentnuit',
        'couvertAgentjour',
        'couvertAgentnuit',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'site',


        'typestache',


        'ville',


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
        $this->table = 'taches';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TacheObservers') &&
                method_exists('\App\Observers\TacheObservers', 'creating')
            ) {

                try {
                    \App\Observers\TacheObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TacheObservers') &&
                method_exists('\App\Observers\TacheObservers', 'created')
            ) {

                try {
                    \App\Observers\TacheObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TacheObservers') &&
                method_exists('\App\Observers\TacheObservers', 'updating')
            ) {

                try {
                    \App\Observers\TacheObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TacheObservers') &&
                method_exists('\App\Observers\TacheObservers', 'updated')
            ) {

                try {
                    \App\Observers\TacheObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TacheObservers') &&
                method_exists('\App\Observers\TacheObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TacheObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TacheObservers') &&
                method_exists('\App\Observers\TacheObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TacheObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function typestache()
    {
        return $this->belongsTo(Typestache::class, 'typestache_id', 'id');
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id', 'id');
    }

    public function programmations()
    {
        return $this->hasMany(Programmation::class, 'tache_id', 'id');
    }

    public function tachespointeuses()
    {
        return $this->hasMany(Tachespointeuse::class, 'tache_id', 'id');
    }

    public function travailleurs()
    {
        return $this->hasMany(Travailleur::class, 'tache_id', 'id');
    }

    public function getTypestacheIdAttribute($value)
    {
        return $value;
    }

    public function setTypestacheIdAttribute($value)
    {
        $this->attributes['typestache_id'] = $value ?? "";
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getPastilleAttribute($value)
    {
        return $value;
    }

    public function setPastilleAttribute($value)
    {
        $this->attributes['pastille'] = $value ?? "";
    }

    public function getPointeusesAttribute($value)
    {
        return $value;
    }

    public function setPointeusesAttribute($value)
    {
        $this->attributes['Pointeuses'] = $value ?? "";
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

    public function getSiteIdAttribute($value)
    {
        return $value;
    }

    public function setSiteIdAttribute($value)
    {
        $this->attributes['site_id'] = $value ?? "";
    }

    public function getVilleIdAttribute($value)
    {
        return $value;
    }

    public function setVilleIdAttribute($value)
    {
        $this->attributes['ville_id'] = $value ?? "";
    }

    public function getJoursAttribute($value)
    {
        return $value;
    }

    public function setJoursAttribute($value)
    {
        $this->attributes['jours'] = $value ?? "";
    }

    public function getCodeAttribute($value)
    {
        return $value;
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = $value ?? "";
    }

    public function getMaxjoursAttribute($value)
    {
        return $value;
    }

    public function setMaxjoursAttribute($value)
    {
        $this->attributes['maxjours'] = $value ?? "";
    }

    public function getMaxnuitsAttribute($value)
    {
        return $value;
    }

    public function setMaxnuitsAttribute($value)
    {
        $this->attributes['maxnuits'] = $value ?? "";
    }

    public function getNbrsJoursAttribute($value)
    {
        return $value;
    }

    public function setNbrsJoursAttribute($value)
    {
        $this->attributes['NbrsJours'] = $value ?? "";
    }

    public function getNbrsNuitsAttribute($value)
    {
        return $value;
    }

    public function setNbrsNuitsAttribute($value)
    {
        $this->attributes['NbrsNuits'] = $value ?? "";
    }

    public function getIsCouvertAttribute($value)
    {
        return $value;
    }

    public function setIsCouvertAttribute($value)
    {
        $this->attributes['IsCouvert'] = $value ?? "";
    }

    public function getAgentjourAttribute($value)
    {
        return $value;
    }

    public function setAgentjourAttribute($value)
    {
        $this->attributes['Agentjour'] = $value ?? "";
    }

    public function getAgentnuitAttribute($value)
    {
        return $value;
    }

    public function setAgentnuitAttribute($value)
    {
        $this->attributes['Agentnuit'] = $value ?? "";
    }

    public function getCouvertAgentjourAttribute($value)
    {
        return $value;
    }

    public function setCouvertAgentjourAttribute($value)
    {
        $this->attributes['couvertAgentjour'] = $value ?? "";
    }

    public function getCouvertAgentnuitAttribute($value)
    {
        return $value;
    }

    public function setCouvertAgentnuitAttribute($value)
    {
        $this->attributes['couvertAgentnuit'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        $select = "";
        try {
            $select = $this->id;
        } catch (\Throwable $e) {

        }


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

