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


use App\Models\Supervirzclient;


class Supervirzclientshide extends Model
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
        'supervirzclient_id',
        'extra_attributes',
        'deleted_at',
        'created_at',
        'updated_at',
        'identifiants_sadge',
        'creat_by',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'supervirzclient',


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
        $this->table = 'supervirzclientshides';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientshideObservers') &&
                method_exists('\App\Observers\SupervirzclientshideObservers', 'creating')
            ) {

                try {
                    \App\Observers\SupervirzclientshideObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientshideObservers') &&
                method_exists('\App\Observers\SupervirzclientshideObservers', 'created')
            ) {

                try {
                    \App\Observers\SupervirzclientshideObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientshideObservers') &&
                method_exists('\App\Observers\SupervirzclientshideObservers', 'updating')
            ) {

                try {
                    \App\Observers\SupervirzclientshideObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientshideObservers') &&
                method_exists('\App\Observers\SupervirzclientshideObservers', 'updated')
            ) {

                try {
                    \App\Observers\SupervirzclientshideObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientshideObservers') &&
                method_exists('\App\Observers\SupervirzclientshideObservers', 'deleting')
            ) {

                try {
                    \App\Observers\SupervirzclientshideObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientshideObservers') &&
                method_exists('\App\Observers\SupervirzclientshideObservers', 'deleted')
            ) {

                try {
                    \App\Observers\SupervirzclientshideObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function supervirzclient()
    {
        return $this->belongsTo(Supervirzclient::class, 'supervirzclient_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getSupervirzclientIdAttribute($value)
    {
        return $value;
    }

    public function setSupervirzclientIdAttribute($value)
    {
        $this->attributes['supervirzclient_id'] = $value ?? "";
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

