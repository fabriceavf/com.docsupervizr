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


class Nationalite extends Model
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
        $this->table = 'nationalites';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\NationaliteObservers') &&
                method_exists('\App\Observers\NationaliteObservers', 'creating')
            ) {

                try {
                    \App\Observers\NationaliteObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\NationaliteObservers') &&
                method_exists('\App\Observers\NationaliteObservers', 'created')
            ) {

                try {
                    \App\Observers\NationaliteObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\NationaliteObservers') &&
                method_exists('\App\Observers\NationaliteObservers', 'updating')
            ) {

                try {
                    \App\Observers\NationaliteObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\NationaliteObservers') &&
                method_exists('\App\Observers\NationaliteObservers', 'updated')
            ) {

                try {
                    \App\Observers\NationaliteObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\NationaliteObservers') &&
                method_exists('\App\Observers\NationaliteObservers', 'deleting')
            ) {

                try {
                    \App\Observers\NationaliteObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\NationaliteObservers') &&
                method_exists('\App\Observers\NationaliteObservers', 'deleted')
            ) {

                try {
                    \App\Observers\NationaliteObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'nationalite_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'nationalite_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'nationalite_id', 'id');
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

