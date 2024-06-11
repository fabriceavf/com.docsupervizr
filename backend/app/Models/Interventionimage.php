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


use App\Models\Intervention;


class Interventionimage extends Model
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
        'intervention_id',
        'path',
        'type',
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


        'intervention',


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
        $this->table = 'interventionimages';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\InterventionimageObservers') &&
                method_exists('\App\Observers\InterventionimageObservers', 'creating')
            ) {

                try {
                    \App\Observers\InterventionimageObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\InterventionimageObservers') &&
                method_exists('\App\Observers\InterventionimageObservers', 'created')
            ) {

                try {
                    \App\Observers\InterventionimageObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\InterventionimageObservers') &&
                method_exists('\App\Observers\InterventionimageObservers', 'updating')
            ) {

                try {
                    \App\Observers\InterventionimageObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\InterventionimageObservers') &&
                method_exists('\App\Observers\InterventionimageObservers', 'updated')
            ) {

                try {
                    \App\Observers\InterventionimageObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\InterventionimageObservers') &&
                method_exists('\App\Observers\InterventionimageObservers', 'deleting')
            ) {

                try {
                    \App\Observers\InterventionimageObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\InterventionimageObservers') &&
                method_exists('\App\Observers\InterventionimageObservers', 'deleted')
            ) {

                try {
                    \App\Observers\InterventionimageObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function intervention()
    {
        return $this->belongsTo(Intervention::class, 'intervention_id', 'id');
    }

    public function getInterventionIdAttribute($value)
    {
        return $value;
    }

    public function setInterventionIdAttribute($value)
    {
        $this->attributes['intervention_id'] = $value ?? "";
    }

    public function getPathAttribute($value)
    {
        return $value;
    }

    public function setPathAttribute($value)
    {
        $this->attributes['path'] = $value ?? "";
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

