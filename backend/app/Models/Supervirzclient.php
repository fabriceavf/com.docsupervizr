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


use App\Models\Pointeuse;


use App\Models\Supervirzclientshide;


class Supervirzclient extends Model
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
        'nom',
        'domaine',
        'path',
        'created_at',
        'updated_at',
        'db_connection',
        'db_host',
        'db_port',
        'db_database',
        'db_username',
        'db_password',
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
        $this->table = 'supervirzclients';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientObservers') &&
                method_exists('\App\Observers\SupervirzclientObservers', 'creating')
            ) {

                try {
                    \App\Observers\SupervirzclientObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientObservers') &&
                method_exists('\App\Observers\SupervirzclientObservers', 'created')
            ) {

                try {
                    \App\Observers\SupervirzclientObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientObservers') &&
                method_exists('\App\Observers\SupervirzclientObservers', 'updating')
            ) {

                try {
                    \App\Observers\SupervirzclientObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientObservers') &&
                method_exists('\App\Observers\SupervirzclientObservers', 'updated')
            ) {

                try {
                    \App\Observers\SupervirzclientObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientObservers') &&
                method_exists('\App\Observers\SupervirzclientObservers', 'deleting')
            ) {

                try {
                    \App\Observers\SupervirzclientObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\SupervirzclientObservers') &&
                method_exists('\App\Observers\SupervirzclientObservers', 'deleted')
            ) {

                try {
                    \App\Observers\SupervirzclientObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function pointeuses()
    {
        return $this->hasMany(Pointeuse::class, 'supervirzclient_id', 'id');
    }

    public function supervirzclientshides()
    {
        return $this->hasMany(Supervirzclientshide::class, 'supervirzclient_id', 'id');
    }

    public function getNomAttribute($value)
    {
        return $value;
    }

    public function setNomAttribute($value)
    {
        $this->attributes['nom'] = $value ?? "";
    }

    public function getDomaineAttribute($value)
    {
        return $value;
    }

    public function setDomaineAttribute($value)
    {
        $this->attributes['domaine'] = $value ?? "";
    }

    public function getPathAttribute($value)
    {
        return $value;
    }

    public function setPathAttribute($value)
    {
        $this->attributes['path'] = $value ?? "";
    }

    public function getDbConnectionAttribute($value)
    {
        return $value;
    }

    public function setDbConnectionAttribute($value)
    {
        $this->attributes['db_connection'] = $value ?? "";
    }

    public function getDbHostAttribute($value)
    {
        return $value;
    }

    public function setDbHostAttribute($value)
    {
        $this->attributes['db_host'] = $value ?? "";
    }

    public function getDbPortAttribute($value)
    {
        return $value;
    }

    public function setDbPortAttribute($value)
    {
        $this->attributes['db_port'] = $value ?? "";
    }

    public function getDbDatabaseAttribute($value)
    {
        return $value;
    }

    public function setDbDatabaseAttribute($value)
    {
        $this->attributes['db_database'] = $value ?? "";
    }

    public function getDbUsernameAttribute($value)
    {
        return $value;
    }

    public function setDbUsernameAttribute($value)
    {
        $this->attributes['db_username'] = $value ?? "";
    }

    public function getDbPasswordAttribute($value)
    {
        return $value;
    }

    public function setDbPasswordAttribute($value)
    {
        $this->attributes['db_password'] = $value ?? "";
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

