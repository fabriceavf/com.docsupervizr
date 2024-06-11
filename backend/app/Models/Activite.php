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


use App\Models\User;


use App\Models\Objectif;


use App\Models\Ressource;


use App\Models\Work;


class Activite extends Model
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
        'created_at',
        'updated_at',
        'extra_attributes',
        'deleted_at',
        'duree',
        'parent',
        'user_id',
        'has_child',
        'description',
        'validate',
        'type',
        'etats_actuel',
        'description_actuel',
        'ParentElements',
        'AllEtats',
        'CanUpdate',
        'IsCreateByMe',
        'IsWorkForMe',
        'Status',
        'Createur',
        'identifiants_sadge',
        'creat_by',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'user',


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
        $this->table = 'activites';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'creating')
            ) {

                try {
                    \App\Observers\ActiviteObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'created')
            ) {

                try {
                    \App\Observers\ActiviteObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'updating')
            ) {

                try {
                    \App\Observers\ActiviteObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'updated')
            ) {

                try {
                    \App\Observers\ActiviteObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ActiviteObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ActiviteObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function objectifs()
    {
        return $this->hasMany(Objectif::class, 'activite_id', 'id');
    }

    public function ressources()
    {
        return $this->hasMany(Ressource::class, 'activite_id', 'id');
    }

    public function works()
    {
        return $this->hasMany(Work::class, 'activite_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getDureeAttribute($value)
    {
        return $value;
    }

    public function setDureeAttribute($value)
    {
        $this->attributes['duree'] = $value ?? "";
    }

    public function getParentAttribute($value)
    {
        return $value;
    }

    public function setParentAttribute($value)
    {
        $this->attributes['parent'] = $value ?? "";
    }

    public function getHasChildAttribute($value)
    {
        return $value;
    }

    public function setHasChildAttribute($value)
    {
        $this->attributes['has_child'] = $value ?? "";
    }

    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value ?? "";
    }

    public function getValidateAttribute($value)
    {
        return $value;
    }

    public function setValidateAttribute($value)
    {
        $this->attributes['validate'] = $value ?? "";
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
    }

    public function getEtatsActuelAttribute($value)
    {
        return $value;
    }

    public function setEtatsActuelAttribute($value)
    {
        $this->attributes['etats_actuel'] = $value ?? "";
    }

    public function getDescriptionActuelAttribute($value)
    {
        return $value;
    }

    public function setDescriptionActuelAttribute($value)
    {
        $this->attributes['description_actuel'] = $value ?? "";
    }

    public function getParentElementsAttribute($value)
    {
        return $value;
    }

    public function setParentElementsAttribute($value)
    {
        $this->attributes['ParentElements'] = $value ?? "";
    }

    public function getAllEtatsAttribute($value)
    {
        return $value;
    }

    public function setAllEtatsAttribute($value)
    {
        $this->attributes['AllEtats'] = $value ?? "";
    }

    public function getCanUpdateAttribute($value)
    {
        return $value;
    }

    public function setCanUpdateAttribute($value)
    {
        $this->attributes['CanUpdate'] = $value ?? "";
    }

    public function getIsCreateByMeAttribute($value)
    {
        return $value;
    }

    public function setIsCreateByMeAttribute($value)
    {
        $this->attributes['IsCreateByMe'] = $value ?? "";
    }

    public function getIsWorkForMeAttribute($value)
    {
        return $value;
    }

    public function setIsWorkForMeAttribute($value)
    {
        $this->attributes['IsWorkForMe'] = $value ?? "";
    }

    public function getStatusAttribute($value)
    {
        return $value;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['Status'] = $value ?? "";
    }

    public function getCreateurAttribute($value)
    {
        return $value;
    }

    public function setCreateurAttribute($value)
    {
        $this->attributes['Createur'] = $value ?? "";
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

