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


use App\Models\Site;


class Passagesronde extends Model
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
        'heure_debut',
        'heure_fin',
        'lun',
        'mar',
        'mer',
        'jeu',
        'ven',
        'sam',
        'dim',
        'site_id',
        'creat_by',
        'created_at',
        'updated_at',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',
        'libelle',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'site',


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
        $this->table = 'passagesrondes';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\PassagesrondeObservers') &&
                method_exists('\App\Observers\PassagesrondeObservers', 'creating')
            ) {

                try {
                    \App\Observers\PassagesrondeObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\PassagesrondeObservers') &&
                method_exists('\App\Observers\PassagesrondeObservers', 'created')
            ) {

                try {
                    \App\Observers\PassagesrondeObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\PassagesrondeObservers') &&
                method_exists('\App\Observers\PassagesrondeObservers', 'updating')
            ) {

                try {
                    \App\Observers\PassagesrondeObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\PassagesrondeObservers') &&
                method_exists('\App\Observers\PassagesrondeObservers', 'updated')
            ) {

                try {
                    \App\Observers\PassagesrondeObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\PassagesrondeObservers') &&
                method_exists('\App\Observers\PassagesrondeObservers', 'deleting')
            ) {

                try {
                    \App\Observers\PassagesrondeObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\PassagesrondeObservers') &&
                method_exists('\App\Observers\PassagesrondeObservers', 'deleted')
            ) {

                try {
                    \App\Observers\PassagesrondeObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function getHeureDebutAttribute($value)
    {
        return $value;
    }

    public function setHeureDebutAttribute($value)
    {
        $this->attributes['heure_debut'] = $value ?? "";
    }

    public function getHeureFinAttribute($value)
    {
        return $value;
    }

    public function setHeureFinAttribute($value)
    {
        $this->attributes['heure_fin'] = $value ?? "";
    }

    public function getLunAttribute($value)
    {
        return $value;
    }

    public function setLunAttribute($value)
    {
        $this->attributes['lun'] = $value ?? "";
    }

    public function getMarAttribute($value)
    {
        return $value;
    }

    public function setMarAttribute($value)
    {
        $this->attributes['mar'] = $value ?? "";
    }

    public function getMerAttribute($value)
    {
        return $value;
    }

    public function setMerAttribute($value)
    {
        $this->attributes['mer'] = $value ?? "";
    }

    public function getJeuAttribute($value)
    {
        return $value;
    }

    public function setJeuAttribute($value)
    {
        $this->attributes['jeu'] = $value ?? "";
    }

    public function getVenAttribute($value)
    {
        return $value;
    }

    public function setVenAttribute($value)
    {
        $this->attributes['ven'] = $value ?? "";
    }

    public function getSamAttribute($value)
    {
        return $value;
    }

    public function setSamAttribute($value)
    {
        $this->attributes['sam'] = $value ?? "";
    }

    public function getDimAttribute($value)
    {
        return $value;
    }

    public function setDimAttribute($value)
    {
        $this->attributes['dim'] = $value ?? "";
    }

    public function getSiteIdAttribute($value)
    {
        return $value;
    }

    public function setSiteIdAttribute($value)
    {
        $this->attributes['site_id'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }

    public function getIdentifiantsSadgeAttribute($value)
    {
        return $value;
    }

    public function setIdentifiantsSadgeAttribute($value)
    {
        $this->attributes['identifiants_sadge'] = $value ?? "";
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
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

