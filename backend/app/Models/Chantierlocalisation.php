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


use App\Models\Chantier;


class Chantierlocalisation extends Model
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
        'chantier_id',
        'latitude',
        'longitude',
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


        'chantier',


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
        $this->table = 'chantierlocalisations';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ChantierlocalisationObservers') &&
                method_exists('\App\Observers\ChantierlocalisationObservers', 'creating')
            ) {

                try {
                    \App\Observers\ChantierlocalisationObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ChantierlocalisationObservers') &&
                method_exists('\App\Observers\ChantierlocalisationObservers', 'created')
            ) {

                try {
                    \App\Observers\ChantierlocalisationObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ChantierlocalisationObservers') &&
                method_exists('\App\Observers\ChantierlocalisationObservers', 'updating')
            ) {

                try {
                    \App\Observers\ChantierlocalisationObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ChantierlocalisationObservers') &&
                method_exists('\App\Observers\ChantierlocalisationObservers', 'updated')
            ) {

                try {
                    \App\Observers\ChantierlocalisationObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ChantierlocalisationObservers') &&
                method_exists('\App\Observers\ChantierlocalisationObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ChantierlocalisationObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ChantierlocalisationObservers') &&
                method_exists('\App\Observers\ChantierlocalisationObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ChantierlocalisationObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function chantier()
    {
        return $this->belongsTo(Chantier::class, 'chantier_id', 'id');
    }

    public function getChantierIdAttribute($value)
    {
        return $value;
    }

    public function setChantierIdAttribute($value)
    {
        $this->attributes['chantier_id'] = $value ?? "";
    }

    public function getLatitudeAttribute($value)
    {
        return $value;
    }

    public function setLatitudeAttribute($value)
    {
        $this->attributes['latitude'] = $value ?? "";
    }

    public function getLongitudeAttribute($value)
    {
        return $value;
    }

    public function setLongitudeAttribute($value)
    {
        $this->attributes['longitude'] = $value ?? "";
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

