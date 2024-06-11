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


use App\Models\Chantierlocalisation;


use App\Models\Materielprevisionnel;


class Chantier extends Model
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
        'couleur',
        'debut_prevus',
        'fin_prevus',
        'debut_effectif',
        'fin_effectif',
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
        $this->table = 'chantiers';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ChantierObservers') &&
                method_exists('\App\Observers\ChantierObservers', 'creating')
            ) {

                try {
                    \App\Observers\ChantierObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ChantierObservers') &&
                method_exists('\App\Observers\ChantierObservers', 'created')
            ) {

                try {
                    \App\Observers\ChantierObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ChantierObservers') &&
                method_exists('\App\Observers\ChantierObservers', 'updating')
            ) {

                try {
                    \App\Observers\ChantierObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ChantierObservers') &&
                method_exists('\App\Observers\ChantierObservers', 'updated')
            ) {

                try {
                    \App\Observers\ChantierObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ChantierObservers') &&
                method_exists('\App\Observers\ChantierObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ChantierObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ChantierObservers') &&
                method_exists('\App\Observers\ChantierObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ChantierObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function chantierlocalisations()
    {
        return $this->hasMany(Chantierlocalisation::class, 'chantier_id', 'id');
    }

    public function materielprevisionnels()
    {
        return $this->hasMany(Materielprevisionnel::class, 'chantier_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getCouleurAttribute($value)
    {
        return $value;
    }

    public function setCouleurAttribute($value)
    {
        $this->attributes['couleur'] = $value ?? "";
    }

    public function getDebutPrevusAttribute($value)
    {
        return $value;
    }

    public function setDebutPrevusAttribute($value)
    {
        $this->attributes['debut_prevus'] = $value ?? "";
    }

    public function getFinPrevusAttribute($value)
    {
        return $value;
    }

    public function setFinPrevusAttribute($value)
    {
        $this->attributes['fin_prevus'] = $value ?? "";
    }

    public function getDebutEffectifAttribute($value)
    {
        return $value;
    }

    public function setDebutEffectifAttribute($value)
    {
        $this->attributes['debut_effectif'] = $value ?? "";
    }

    public function getFinEffectifAttribute($value)
    {
        return $value;
    }

    public function setFinEffectifAttribute($value)
    {
        $this->attributes['fin_effectif'] = $value ?? "";
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

