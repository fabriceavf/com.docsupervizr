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


use App\Models\Materielintervention;


use App\Models\Materiel;


class Materielinterventiondetail extends Model
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
        'materiel_id',
        'materielintervention_id',
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


        'materielintervention',


        'materiel',


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
        $this->table = 'materielinterventiondetails';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\MaterielinterventiondetailObservers') &&
                method_exists('\App\Observers\MaterielinterventiondetailObservers', 'creating')
            ) {

                try {
                    \App\Observers\MaterielinterventiondetailObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\MaterielinterventiondetailObservers') &&
                method_exists('\App\Observers\MaterielinterventiondetailObservers', 'created')
            ) {

                try {
                    \App\Observers\MaterielinterventiondetailObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\MaterielinterventiondetailObservers') &&
                method_exists('\App\Observers\MaterielinterventiondetailObservers', 'updating')
            ) {

                try {
                    \App\Observers\MaterielinterventiondetailObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\MaterielinterventiondetailObservers') &&
                method_exists('\App\Observers\MaterielinterventiondetailObservers', 'updated')
            ) {

                try {
                    \App\Observers\MaterielinterventiondetailObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\MaterielinterventiondetailObservers') &&
                method_exists('\App\Observers\MaterielinterventiondetailObservers', 'deleting')
            ) {

                try {
                    \App\Observers\MaterielinterventiondetailObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\MaterielinterventiondetailObservers') &&
                method_exists('\App\Observers\MaterielinterventiondetailObservers', 'deleted')
            ) {

                try {
                    \App\Observers\MaterielinterventiondetailObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function materielintervention()
    {
        return $this->belongsTo(Materielintervention::class, 'materielintervention_id', 'id');
    }

    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id', 'id');
    }

    public function getMaterielIdAttribute($value)
    {
        return $value;
    }

    public function setMaterielIdAttribute($value)
    {
        $this->attributes['materiel_id'] = $value ?? "";
    }

    public function getMaterielinterventionIdAttribute($value)
    {
        return $value;
    }

    public function setMaterielinterventionIdAttribute($value)
    {
        $this->attributes['materielintervention_id'] = $value ?? "";
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

