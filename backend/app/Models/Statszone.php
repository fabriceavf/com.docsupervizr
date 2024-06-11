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


class Statszone extends Model
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
        'nom1',
        'modelslistingnuit1_id',
        'modelslistingjour1_id',
        'nom2',
        'modelslistingnuit2_id',
        'modelslistingjour2_id',
        'nom3',
        'modelslistingnuit3_id',
        'modelslistingjour3_id',
        'creat_by',
        'extra_attributes',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
        'modelslistingnuit1',
        'modelslistingnuit2',
        'modelslistingnuit3',
        'modelslistingjour1',
        'modelslistingjour2',
        'modelslistingjour3',
        'identifiants_sadge',

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
        $this->table = 'statszones';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\StatszoneObservers') &&
                method_exists('\App\Observers\StatszoneObservers', 'creating')
            ) {

                try {
                    \App\Observers\StatszoneObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\StatszoneObservers') &&
                method_exists('\App\Observers\StatszoneObservers', 'created')
            ) {

                try {
                    \App\Observers\StatszoneObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\StatszoneObservers') &&
                method_exists('\App\Observers\StatszoneObservers', 'updating')
            ) {

                try {
                    \App\Observers\StatszoneObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\StatszoneObservers') &&
                method_exists('\App\Observers\StatszoneObservers', 'updated')
            ) {

                try {
                    \App\Observers\StatszoneObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\StatszoneObservers') &&
                method_exists('\App\Observers\StatszoneObservers', 'deleting')
            ) {

                try {
                    \App\Observers\StatszoneObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\StatszoneObservers') &&
                method_exists('\App\Observers\StatszoneObservers', 'deleted')
            ) {

                try {
                    \App\Observers\StatszoneObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getNom1Attribute($value)
    {
        return $value;
    }

    public function setNom1Attribute($value)
    {
        $this->attributes['nom1'] = $value ?? "";
    }

    public function getModelslistingnuit1IdAttribute($value)
    {
        return $value;
    }

    public function setModelslistingnuit1IdAttribute($value)
    {
        $this->attributes['modelslistingnuit1_id'] = $value ?? "";
    }

    public function getModelslistingjour1IdAttribute($value)
    {
        return $value;
    }

    public function setModelslistingjour1IdAttribute($value)
    {
        $this->attributes['modelslistingjour1_id'] = $value ?? "";
    }

    public function getNom2Attribute($value)
    {
        return $value;
    }

    public function setNom2Attribute($value)
    {
        $this->attributes['nom2'] = $value ?? "";
    }

    public function getModelslistingnuit2IdAttribute($value)
    {
        return $value;
    }

    public function setModelslistingnuit2IdAttribute($value)
    {
        $this->attributes['modelslistingnuit2_id'] = $value ?? "";
    }

    public function getModelslistingjour2IdAttribute($value)
    {
        return $value;
    }

    public function setModelslistingjour2IdAttribute($value)
    {
        $this->attributes['modelslistingjour2_id'] = $value ?? "";
    }

    public function getNom3Attribute($value)
    {
        return $value;
    }

    public function setNom3Attribute($value)
    {
        $this->attributes['nom3'] = $value ?? "";
    }

    public function getModelslistingnuit3IdAttribute($value)
    {
        return $value;
    }

    public function setModelslistingnuit3IdAttribute($value)
    {
        $this->attributes['modelslistingnuit3_id'] = $value ?? "";
    }

    public function getModelslistingjour3IdAttribute($value)
    {
        return $value;
    }

    public function setModelslistingjour3IdAttribute($value)
    {
        $this->attributes['modelslistingjour3_id'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }

    public function getModelslistingnuit1Attribute($value)
    {
        return $value;
    }

    public function setModelslistingnuit1Attribute($value)
    {
        $this->attributes['modelslistingnuit1'] = $value ?? "";
    }

    public function getModelslistingnuit2Attribute($value)
    {
        return $value;
    }

    public function setModelslistingnuit2Attribute($value)
    {
        $this->attributes['modelslistingnuit2'] = $value ?? "";
    }

    public function getModelslistingnuit3Attribute($value)
    {
        return $value;
    }

    public function setModelslistingnuit3Attribute($value)
    {
        $this->attributes['modelslistingnuit3'] = $value ?? "";
    }

    public function getModelslistingjour1Attribute($value)
    {
        return $value;
    }

    public function setModelslistingjour1Attribute($value)
    {
        $this->attributes['modelslistingjour1'] = $value ?? "";
    }

    public function getModelslistingjour2Attribute($value)
    {
        return $value;
    }

    public function setModelslistingjour2Attribute($value)
    {
        $this->attributes['modelslistingjour2'] = $value ?? "";
    }

    public function getModelslistingjour3Attribute($value)
    {
        return $value;
    }

    public function setModelslistingjour3Attribute($value)
    {
        $this->attributes['modelslistingjour3'] = $value ?? "";
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

