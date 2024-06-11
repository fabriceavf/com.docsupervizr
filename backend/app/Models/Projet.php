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


use App\Models\Besoin;


class Projet extends Model
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
        'descriptions',
        'debut_previsionnel',
        'fin_previsionnel',
        'debut_reel',
        'fin_reel',
        'creat_by',
        'created_at',
        'updated_at',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',

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
        $this->table = 'projets';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ProjetObservers') &&
                method_exists('\App\Observers\ProjetObservers', 'creating')
            ) {

                try {
                    \App\Observers\ProjetObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ProjetObservers') &&
                method_exists('\App\Observers\ProjetObservers', 'created')
            ) {

                try {
                    \App\Observers\ProjetObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ProjetObservers') &&
                method_exists('\App\Observers\ProjetObservers', 'updating')
            ) {

                try {
                    \App\Observers\ProjetObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ProjetObservers') &&
                method_exists('\App\Observers\ProjetObservers', 'updated')
            ) {

                try {
                    \App\Observers\ProjetObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ProjetObservers') &&
                method_exists('\App\Observers\ProjetObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ProjetObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ProjetObservers') &&
                method_exists('\App\Observers\ProjetObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ProjetObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function besoins()
    {
        return $this->hasMany(Besoin::class, 'projet_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getDescriptionsAttribute($value)
    {
        return $value;
    }

    public function setDescriptionsAttribute($value)
    {
        $this->attributes['descriptions'] = $value ?? "";
    }

    public function getDebutPrevisionnelAttribute($value)
    {
        return $value;
    }

    public function setDebutPrevisionnelAttribute($value)
    {
        $this->attributes['debut_previsionnel'] = $value ?? "";
    }

    public function getFinPrevisionnelAttribute($value)
    {
        return $value;
    }

    public function setFinPrevisionnelAttribute($value)
    {
        $this->attributes['fin_previsionnel'] = $value ?? "";
    }

    public function getDebutReelAttribute($value)
    {
        return $value;
    }

    public function setDebutReelAttribute($value)
    {
        $this->attributes['debut_reel'] = $value ?? "";
    }

    public function getFinReelAttribute($value)
    {
        return $value;
    }

    public function setFinReelAttribute($value)
    {
        $this->attributes['fin_reel'] = $value ?? "";
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

    public function getSelectvalueAttribute()
    {
        $select = "";
        try {
            $select = $this->id;
        } catch (\Throwable $e) {

        }


        $select = " " . $this->id;


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

