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


use App\Models\Service;


use App\Models\Listing;


use App\Models\Rapport;


use App\Models\Transaction;


use App\Models\User;


class Fonction extends Model
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
        'code',
        'libelle',
        'extra_attributes',
        'created_at',
        'updated_at',
        'service_id',
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


        'service',


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
        $this->table = 'fonctions';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\FonctionObservers') &&
                method_exists('\App\Observers\FonctionObservers', 'creating')
            ) {

                try {
                    \App\Observers\FonctionObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\FonctionObservers') &&
                method_exists('\App\Observers\FonctionObservers', 'created')
            ) {

                try {
                    \App\Observers\FonctionObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\FonctionObservers') &&
                method_exists('\App\Observers\FonctionObservers', 'updating')
            ) {

                try {
                    \App\Observers\FonctionObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\FonctionObservers') &&
                method_exists('\App\Observers\FonctionObservers', 'updated')
            ) {

                try {
                    \App\Observers\FonctionObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\FonctionObservers') &&
                method_exists('\App\Observers\FonctionObservers', 'deleting')
            ) {

                try {
                    \App\Observers\FonctionObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\FonctionObservers') &&
                method_exists('\App\Observers\FonctionObservers', 'deleted')
            ) {

                try {
                    \App\Observers\FonctionObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'fonction_id', 'id');
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class, 'fonction_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'fonction_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'fonction_id', 'id');
    }

    public function getCodeAttribute($value)
    {
        return $value;
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = $value ?? "";
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getServiceIdAttribute($value)
    {
        return $value;
    }

    public function setServiceIdAttribute($value)
    {
        $this->attributes['service_id'] = $value ?? "";
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

