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


use App\Models\Site;


use App\Models\Interventionimage;


use App\Models\Interventionuser;


use App\Models\Materielintervention;


class Intervention extends Model
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
        'ref',
        'agent',
        'debut_prevu',
        'debut_realise',
        'fin_prevu',
        'fin_realise',
        'etats',
        'extra_attributes',
        'created_at',
        'updated_at',
        'site_id',
        'site_libelle',
        'client_id',
        'client_libelle',
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


        'client',


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
        $this->table = 'interventions';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\InterventionObservers') &&
                method_exists('\App\Observers\InterventionObservers', 'creating')
            ) {

                try {
                    \App\Observers\InterventionObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\InterventionObservers') &&
                method_exists('\App\Observers\InterventionObservers', 'created')
            ) {

                try {
                    \App\Observers\InterventionObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\InterventionObservers') &&
                method_exists('\App\Observers\InterventionObservers', 'updating')
            ) {

                try {
                    \App\Observers\InterventionObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\InterventionObservers') &&
                method_exists('\App\Observers\InterventionObservers', 'updated')
            ) {

                try {
                    \App\Observers\InterventionObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\InterventionObservers') &&
                method_exists('\App\Observers\InterventionObservers', 'deleting')
            ) {

                try {
                    \App\Observers\InterventionObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\InterventionObservers') &&
                method_exists('\App\Observers\InterventionObservers', 'deleted')
            ) {

                try {
                    \App\Observers\InterventionObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function interventionimages()
    {
        return $this->hasMany(Interventionimage::class, 'intervention_id', 'id');
    }

    public function interventionusers()
    {
        return $this->hasMany(Interventionuser::class, 'intervention_id', 'id');
    }

    public function materielinterventions()
    {
        return $this->hasMany(Materielintervention::class, 'intervention_id', 'id');
    }

    public function getRefAttribute($value)
    {
        return $value;
    }

    public function setRefAttribute($value)
    {
        $this->attributes['ref'] = $value ?? "";
    }

    public function getAgentAttribute($value)
    {
        return $value;
    }

    public function setAgentAttribute($value)
    {
        $this->attributes['agent'] = $value ?? "";
    }

    public function getDebutPrevuAttribute($value)
    {
        return $value;
    }

    public function setDebutPrevuAttribute($value)
    {
        $this->attributes['debut_prevu'] = $value ?? "";
    }

    public function getDebutRealiseAttribute($value)
    {
        return $value;
    }

    public function setDebutRealiseAttribute($value)
    {
        $this->attributes['debut_realise'] = $value ?? "";
    }

    public function getFinPrevuAttribute($value)
    {
        return $value;
    }

    public function setFinPrevuAttribute($value)
    {
        $this->attributes['fin_prevu'] = $value ?? "";
    }

    public function getFinRealiseAttribute($value)
    {
        return $value;
    }

    public function setFinRealiseAttribute($value)
    {
        $this->attributes['fin_realise'] = $value ?? "";
    }

    public function getEtatsAttribute($value)
    {
        return $value;
    }

    public function setEtatsAttribute($value)
    {
        $this->attributes['etats'] = $value ?? "";
    }

    public function getSiteIdAttribute($value)
    {
        return $value;
    }

    public function setSiteIdAttribute($value)
    {
        $this->attributes['site_id'] = $value ?? "";
    }

    public function getSiteLibelleAttribute($value)
    {
        return $value;
    }

    public function setSiteLibelleAttribute($value)
    {
        $this->attributes['site_libelle'] = $value ?? "";
    }

    public function getClientIdAttribute($value)
    {
        return $value;
    }

    public function setClientIdAttribute($value)
    {
        $this->attributes['client_id'] = $value ?? "";
    }

    public function getClientLibelleAttribute($value)
    {
        return $value;
    }

    public function setClientLibelleAttribute($value)
    {
        $this->attributes['client_libelle'] = $value ?? "";
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

