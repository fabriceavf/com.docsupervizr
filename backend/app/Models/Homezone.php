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


use App\Models\Modelslisting;


use App\Models\Zone;


class Homezone extends Model
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
        'type',
        'zone_id',
        'modelslisting_id',
        'creat_by',
        'extra_attributes',
        'created_at',
        'updated_at',
        'deleted_at',
        'modelslisting',
        'effectifsjour',
        'presentsjour',
        'effectifsnuit',
        'presentsnuit',
        'identifiants_sadge',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'modelslisting',


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
        $this->table = 'homezones';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\HomezoneObservers') &&
                method_exists('\App\Observers\HomezoneObservers', 'creating')
            ) {

                try {
                    \App\Observers\HomezoneObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\HomezoneObservers') &&
                method_exists('\App\Observers\HomezoneObservers', 'created')
            ) {

                try {
                    \App\Observers\HomezoneObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\HomezoneObservers') &&
                method_exists('\App\Observers\HomezoneObservers', 'updating')
            ) {

                try {
                    \App\Observers\HomezoneObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\HomezoneObservers') &&
                method_exists('\App\Observers\HomezoneObservers', 'updated')
            ) {

                try {
                    \App\Observers\HomezoneObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\HomezoneObservers') &&
                method_exists('\App\Observers\HomezoneObservers', 'deleting')
            ) {

                try {
                    \App\Observers\HomezoneObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\HomezoneObservers') &&
                method_exists('\App\Observers\HomezoneObservers', 'deleted')
            ) {

                try {
                    \App\Observers\HomezoneObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function modelslisting()
    {
        return $this->belongsTo(Modelslisting::class, 'modelslisting_id', 'id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
    }

    public function getZoneIdAttribute($value)
    {
        return $value;
    }

    public function setZoneIdAttribute($value)
    {
        $this->attributes['zone_id'] = $value ?? "";
    }

    public function getModelslistingIdAttribute($value)
    {
        return $value;
    }

    public function setModelslistingIdAttribute($value)
    {
        $this->attributes['modelslisting_id'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }

    public function getModelslistingAttribute($value)
    {
        return $value;
    }

    public function setModelslistingAttribute($value)
    {
        $this->attributes['modelslisting'] = $value ?? "";
    }

    public function getEffectifsjourAttribute($value)
    {
        return $value;
    }

    public function setEffectifsjourAttribute($value)
    {
        $this->attributes['effectifsjour'] = $value ?? "";
    }

    public function getPresentsjourAttribute($value)
    {
        return $value;
    }

    public function setPresentsjourAttribute($value)
    {
        $this->attributes['presentsjour'] = $value ?? "";
    }

    public function getEffectifsnuitAttribute($value)
    {
        return $value;
    }

    public function setEffectifsnuitAttribute($value)
    {
        $this->attributes['effectifsnuit'] = $value ?? "";
    }

    public function getPresentsnuitAttribute($value)
    {
        return $value;
    }

    public function setPresentsnuitAttribute($value)
    {
        $this->attributes['presentsnuit'] = $value ?? "";
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

