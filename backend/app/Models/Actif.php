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


use App\Models\Listing;


use App\Models\Transaction;


use App\Models\User;


class Actif extends Model
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
        'code',
        'remember_token',
        'extra_attributes',
        'created_at',
        'updated_at',
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
        $this->table = 'actifs';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ActifObservers') &&
                method_exists('\App\Observers\ActifObservers', 'creating')
            ) {

                try {
                    \App\Observers\ActifObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ActifObservers') &&
                method_exists('\App\Observers\ActifObservers', 'created')
            ) {

                try {
                    \App\Observers\ActifObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ActifObservers') &&
                method_exists('\App\Observers\ActifObservers', 'updating')
            ) {

                try {
                    \App\Observers\ActifObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ActifObservers') &&
                method_exists('\App\Observers\ActifObservers', 'updated')
            ) {

                try {
                    \App\Observers\ActifObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ActifObservers') &&
                method_exists('\App\Observers\ActifObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ActifObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ActifObservers') &&
                method_exists('\App\Observers\ActifObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ActifObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'actif_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'actif_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'actif_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getCodeAttribute($value)
    {
        return $value;
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = $value ?? "";
    }

    public function getRememberTokenAttribute($value)
    {
        return $value;
    }

    public function setRememberTokenAttribute($value)
    {
        $this->attributes['remember_token'] = $value ?? "";
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


        $select = " " . $this->code;


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

