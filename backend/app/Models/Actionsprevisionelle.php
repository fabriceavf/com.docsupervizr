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


use App\Models\Besoin;


use App\Models\Actionsrealise;


class Actionsprevisionelle extends Model
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
        'besoin_id',
        'creat_by',
        'evaluation',
        'valider',
        'type',
        'created_at',
        'updated_at',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'besoin',


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
        $this->table = 'actionsprevisionelles';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ActionsprevisionelleObservers') &&
                method_exists('\App\Observers\ActionsprevisionelleObservers', 'creating')
            ) {

                try {
                    \App\Observers\ActionsprevisionelleObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ActionsprevisionelleObservers') &&
                method_exists('\App\Observers\ActionsprevisionelleObservers', 'created')
            ) {

                try {
                    \App\Observers\ActionsprevisionelleObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ActionsprevisionelleObservers') &&
                method_exists('\App\Observers\ActionsprevisionelleObservers', 'updating')
            ) {

                try {
                    \App\Observers\ActionsprevisionelleObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ActionsprevisionelleObservers') &&
                method_exists('\App\Observers\ActionsprevisionelleObservers', 'updated')
            ) {

                try {
                    \App\Observers\ActionsprevisionelleObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ActionsprevisionelleObservers') &&
                method_exists('\App\Observers\ActionsprevisionelleObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ActionsprevisionelleObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ActionsprevisionelleObservers') &&
                method_exists('\App\Observers\ActionsprevisionelleObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ActionsprevisionelleObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function besoin()
    {
        return $this->belongsTo(Besoin::class, 'besoin_id', 'id');
    }

    public function actionsrealises()
    {
        return $this->hasMany(Actionsrealise::class, 'actionsprevisionelle_id', 'id');
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

    public function getBesoinIdAttribute($value)
    {
        return $value;
    }

    public function setBesoinIdAttribute($value)
    {
        $this->attributes['besoin_id'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }

    public function getEvaluationAttribute($value)
    {
        return $value;
    }

    public function setEvaluationAttribute($value)
    {
        $this->attributes['evaluation'] = $value ?? "";
    }

    public function getValiderAttribute($value)
    {
        return $value;
    }

    public function setValiderAttribute($value)
    {
        $this->attributes['valider'] = $value ?? "";
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

