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


use App\Models\Materielinterventiondetail;


use App\Models\Materielprevisionnel;


class Materiel extends Model
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
        'reference',
        'description',
        'quantite',
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
        $this->table = 'materiels';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\MaterielObservers') &&
                method_exists('\App\Observers\MaterielObservers', 'creating')
            ) {

                try {
                    \App\Observers\MaterielObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\MaterielObservers') &&
                method_exists('\App\Observers\MaterielObservers', 'created')
            ) {

                try {
                    \App\Observers\MaterielObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\MaterielObservers') &&
                method_exists('\App\Observers\MaterielObservers', 'updating')
            ) {

                try {
                    \App\Observers\MaterielObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\MaterielObservers') &&
                method_exists('\App\Observers\MaterielObservers', 'updated')
            ) {

                try {
                    \App\Observers\MaterielObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\MaterielObservers') &&
                method_exists('\App\Observers\MaterielObservers', 'deleting')
            ) {

                try {
                    \App\Observers\MaterielObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\MaterielObservers') &&
                method_exists('\App\Observers\MaterielObservers', 'deleted')
            ) {

                try {
                    \App\Observers\MaterielObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function materielinterventiondetails()
    {
        return $this->hasMany(Materielinterventiondetail::class, 'materiel_id', 'id');
    }

    public function materielprevisionnels()
    {
        return $this->hasMany(Materielprevisionnel::class, 'materiel_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getReferenceAttribute($value)
    {
        return $value;
    }

    public function setReferenceAttribute($value)
    {
        $this->attributes['reference'] = $value ?? "";
    }

    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value ?? "";
    }

    public function getQuantiteAttribute($value)
    {
        return $value;
    }

    public function setQuantiteAttribute($value)
    {
        $this->attributes['quantite'] = $value ?? "";
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

