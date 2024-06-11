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


use App\Models\Client;


use App\Models\Pointeuse;


use App\Models\Typessite;


use App\Models\Zone;


use App\Models\Carte;


use App\Models\Contratssite;


use App\Models\Controlleursacce;


use App\Models\Intervention;


use App\Models\Listing;


use App\Models\Passagesronde;


use App\Models\Pastille;


use App\Models\Poste;


use App\Models\Rapport;


use App\Models\Sitespointeuse;


use App\Models\Sitessdeplacement;


use App\Models\Tache;


use App\Models\Trajet;


use App\Models\Transaction;


use App\Models\User;


class Site extends Model
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
        'libelle',
        'client_id',
        'zone_id',
        'created_at',
        'updated_at',
        'pointeuse_id',
        'NbrsJours',
        'NbrsNuits',
        'type',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',
        'pastille',
        'typessite_id',
        'date_debut',
        'date_fin',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'client',


        'pointeuse',


        'typessite',


        'zone',


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
        $this->table = 'sites';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\SiteObservers') &&
                method_exists('\App\Observers\SiteObservers', 'creating')
            ) {

                try {
                    \App\Observers\SiteObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\SiteObservers') &&
                method_exists('\App\Observers\SiteObservers', 'created')
            ) {

                try {
                    \App\Observers\SiteObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\SiteObservers') &&
                method_exists('\App\Observers\SiteObservers', 'updating')
            ) {

                try {
                    \App\Observers\SiteObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\SiteObservers') &&
                method_exists('\App\Observers\SiteObservers', 'updated')
            ) {

                try {
                    \App\Observers\SiteObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\SiteObservers') &&
                method_exists('\App\Observers\SiteObservers', 'deleting')
            ) {

                try {
                    \App\Observers\SiteObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\SiteObservers') &&
                method_exists('\App\Observers\SiteObservers', 'deleted')
            ) {

                try {
                    \App\Observers\SiteObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function pointeuse()
    {
        return $this->belongsTo(Pointeuse::class, 'pointeuse_id', 'id');
    }

    public function typessite()
    {
        return $this->belongsTo(Typessite::class, 'typessite_id', 'id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }

    public function cartes()
    {
        return $this->hasMany(Carte::class, 'site_id', 'id');
    }

    public function contratssites()
    {
        return $this->hasMany(Contratssite::class, 'site_id', 'id');
    }

    public function controlleursacces()
    {
        return $this->hasMany(Controlleursacce::class, 'site_id', 'id');
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class, 'site_id', 'id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'site_id', 'id');
    }

    public function passagesrondes()
    {
        return $this->hasMany(Passagesronde::class, 'site_id', 'id');
    }

    public function pastilles()
    {
        return $this->hasMany(Pastille::class, 'site_id', 'id');
    }

    public function pointeuses()
    {
        return $this->hasMany(Pointeuse::class, 'site_id', 'id');
    }

    public function postes()
    {
        return $this->hasMany(Poste::class, 'site_id', 'id');
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class, 'site_id', 'id');
    }

    public function sitespointeuses()
    {
        return $this->hasMany(Sitespointeuse::class, 'site_id', 'id');
    }

    public function sitessdeplacements()
    {
        return $this->hasMany(Sitessdeplacement::class, 'site_id', 'id');
    }

    public function taches()
    {
        return $this->hasMany(Tache::class, 'site_id', 'id');
    }

    public function trajets()
    {
        return $this->hasMany(Trajet::class, 'site_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'site_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'site_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getClientIdAttribute($value)
    {
        return $value;
    }

    public function setClientIdAttribute($value)
    {
        $this->attributes['client_id'] = $value ?? "";
    }

    public function getZoneIdAttribute($value)
    {
        return $value;
    }

    public function setZoneIdAttribute($value)
    {
        $this->attributes['zone_id'] = $value ?? "";
    }

    public function getPointeuseIdAttribute($value)
    {
        return $value;
    }

    public function setPointeuseIdAttribute($value)
    {
        $this->attributes['pointeuse_id'] = $value ?? "";
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

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
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

    public function getPastilleAttribute($value)
    {
        return $value;
    }

    public function setPastilleAttribute($value)
    {
        $this->attributes['pastille'] = $value ?? "";
    }

    public function getTypessiteIdAttribute($value)
    {
        return $value;
    }

    public function setTypessiteIdAttribute($value)
    {
        $this->attributes['typessite_id'] = $value ?? "";
    }

    public function getDateDebutAttribute($value)
    {
        return $value;
    }

    public function setDateDebutAttribute($value)
    {
        $this->attributes['date_debut'] = $value ?? "";
    }

    public function getDateFinAttribute($value)
    {
        return $value;
    }

    public function setDateFinAttribute($value)
    {
        $this->attributes['date_fin'] = $value ?? "";
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

