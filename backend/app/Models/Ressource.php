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


use App\Models\Activite;


use App\Models\Attribution;


class Ressource extends Model
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
        'type',
        'cle',
        'valeur',
        'activite_id',
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


        'activite',


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
        $this->table = 'ressources';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\RessourceObservers') &&
                method_exists('\App\Observers\RessourceObservers', 'creating')
            ) {

                try {
                    \App\Observers\RessourceObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\RessourceObservers') &&
                method_exists('\App\Observers\RessourceObservers', 'created')
            ) {

                try {
                    \App\Observers\RessourceObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\RessourceObservers') &&
                method_exists('\App\Observers\RessourceObservers', 'updating')
            ) {

                try {
                    \App\Observers\RessourceObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\RessourceObservers') &&
                method_exists('\App\Observers\RessourceObservers', 'updated')
            ) {

                try {
                    \App\Observers\RessourceObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\RessourceObservers') &&
                method_exists('\App\Observers\RessourceObservers', 'deleting')
            ) {

                try {
                    \App\Observers\RessourceObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\RessourceObservers') &&
                method_exists('\App\Observers\RessourceObservers', 'deleted')
            ) {

                try {
                    \App\Observers\RessourceObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function activite()
    {
        return $this->belongsTo(Activite::class, 'activite_id', 'id');
    }

    public function attributions()
    {
        return $this->hasMany(Attribution::class, 'ressource_id', 'id');
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
    }

    public function getCleAttribute($value)
    {
        return $value;
    }

    public function setCleAttribute($value)
    {
        $this->attributes['cle'] = $value ?? "";
    }

    public function getValeurAttribute($value)
    {
        return $value;
    }

    public function setValeurAttribute($value)
    {
        $this->attributes['valeur'] = $value ?? "";
    }

    public function getActiviteIdAttribute($value)
    {
        return $value;
    }

    public function setActiviteIdAttribute($value)
    {
        $this->attributes['activite_id'] = $value ?? "";
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

