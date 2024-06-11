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


use App\Models\Horaire;


use App\Models\Tache;


use App\Models\User;


class Travailleur extends Model
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
        'horaire_id',
        'user_id',
        'lun',
        'mar',
        'mer',
        'jeu',
        'ven',
        'sam',
        'dim',
        'created_at',
        'updated_at',
        'extra_attributes',
        'deleted_at',
        'tache_id',
        'identifiants_sadge',
        'creat_by',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'horaire',


        'tache',


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
        $this->table = 'travailleurs';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TravailleurObservers') &&
                method_exists('\App\Observers\TravailleurObservers', 'creating')
            ) {

                try {
                    \App\Observers\TravailleurObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TravailleurObservers') &&
                method_exists('\App\Observers\TravailleurObservers', 'created')
            ) {

                try {
                    \App\Observers\TravailleurObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TravailleurObservers') &&
                method_exists('\App\Observers\TravailleurObservers', 'updating')
            ) {

                try {
                    \App\Observers\TravailleurObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TravailleurObservers') &&
                method_exists('\App\Observers\TravailleurObservers', 'updated')
            ) {

                try {
                    \App\Observers\TravailleurObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TravailleurObservers') &&
                method_exists('\App\Observers\TravailleurObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TravailleurObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TravailleurObservers') &&
                method_exists('\App\Observers\TravailleurObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TravailleurObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function horaire()
    {
        return $this->belongsTo(Horaire::class, 'horaire_id', 'id');
    }

    public function tache()
    {
        return $this->belongsTo(Tache::class, 'tache_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getHoraireIdAttribute($value)
    {
        return $value;
    }

    public function setHoraireIdAttribute($value)
    {
        $this->attributes['horaire_id'] = $value ?? "";
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

    public function getTacheIdAttribute($value)
    {
        return $value;
    }

    public function setTacheIdAttribute($value)
    {
        $this->attributes['tache_id'] = $value ?? "";
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

