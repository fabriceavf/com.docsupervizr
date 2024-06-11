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


use App\Models\Projet;


use App\Models\Actionsprevisionelle;


class Besoin extends Model
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
        'descriptions',
        'debut_previsionnel',
        'fin_previsionnel',
        'debut_reel',
        'fin_reel',
        'projet_id',
        'evaluation',
        'creat_by',
        'valider',
        'created_at',
        'updated_at',
        'extra_attributes',
        'deleted_at',
        'Child',
        'ChildPrevu',
        'ChildImprevu',
        'ChildReussi',
        'ChildBloquer',
        'identifiants_sadge',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'projet',


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
        $this->table = 'besoins';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\BesoinObservers') &&
                method_exists('\App\Observers\BesoinObservers', 'creating')
            ) {

                try {
                    \App\Observers\BesoinObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\BesoinObservers') &&
                method_exists('\App\Observers\BesoinObservers', 'created')
            ) {

                try {
                    \App\Observers\BesoinObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\BesoinObservers') &&
                method_exists('\App\Observers\BesoinObservers', 'updating')
            ) {

                try {
                    \App\Observers\BesoinObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\BesoinObservers') &&
                method_exists('\App\Observers\BesoinObservers', 'updated')
            ) {

                try {
                    \App\Observers\BesoinObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\BesoinObservers') &&
                method_exists('\App\Observers\BesoinObservers', 'deleting')
            ) {

                try {
                    \App\Observers\BesoinObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\BesoinObservers') &&
                method_exists('\App\Observers\BesoinObservers', 'deleted')
            ) {

                try {
                    \App\Observers\BesoinObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id', 'id');
    }

    public function actionsprevisionelles()
    {
        return $this->hasMany(Actionsprevisionelle::class, 'besoin_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getDescriptionsAttribute($value)
    {
        return $value;
    }

    public function setDescriptionsAttribute($value)
    {
        $this->attributes['descriptions'] = $value ?? "";
    }

    public function getDebutPrevisionnelAttribute($value)
    {
        return $value;
    }

    public function setDebutPrevisionnelAttribute($value)
    {
        $this->attributes['debut_previsionnel'] = $value ?? "";
    }

    public function getFinPrevisionnelAttribute($value)
    {
        return $value;
    }

    public function setFinPrevisionnelAttribute($value)
    {
        $this->attributes['fin_previsionnel'] = $value ?? "";
    }

    public function getDebutReelAttribute($value)
    {
        return $value;
    }

    public function setDebutReelAttribute($value)
    {
        $this->attributes['debut_reel'] = $value ?? "";
    }

    public function getFinReelAttribute($value)
    {
        return $value;
    }

    public function setFinReelAttribute($value)
    {
        $this->attributes['fin_reel'] = $value ?? "";
    }

    public function getProjetIdAttribute($value)
    {
        return $value;
    }

    public function setProjetIdAttribute($value)
    {
        $this->attributes['projet_id'] = $value ?? "";
    }

    public function getEvaluationAttribute($value)
    {
        return $value;
    }

    public function setEvaluationAttribute($value)
    {
        $this->attributes['evaluation'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }

    public function getValiderAttribute($value)
    {
        return $value;
    }

    public function setValiderAttribute($value)
    {
        $this->attributes['valider'] = $value ?? "";
    }

    public function getChildAttribute($value)
    {
        return $value;
    }

    public function setChildAttribute($value)
    {
        $this->attributes['Child'] = $value ?? "";
    }

    public function getChildPrevuAttribute($value)
    {
        return $value;
    }

    public function setChildPrevuAttribute($value)
    {
        $this->attributes['ChildPrevu'] = $value ?? "";
    }

    public function getChildImprevuAttribute($value)
    {
        return $value;
    }

    public function setChildImprevuAttribute($value)
    {
        $this->attributes['ChildImprevu'] = $value ?? "";
    }

    public function getChildReussiAttribute($value)
    {
        return $value;
    }

    public function setChildReussiAttribute($value)
    {
        $this->attributes['ChildReussi'] = $value ?? "";
    }

    public function getChildBloquerAttribute($value)
    {
        return $value;
    }

    public function setChildBloquerAttribute($value)
    {
        $this->attributes['ChildBloquer'] = $value ?? "";
    }

    public function getIdentifiantsSadgeAttribute($value)
    {
        return $value;
    }

    public function setIdentifiantsSadgeAttribute($value)
    {
        $this->attributes['identifiants_sadge'] = $value ?? "";
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

