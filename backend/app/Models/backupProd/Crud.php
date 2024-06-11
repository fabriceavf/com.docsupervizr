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


use App\Models\User;


class Crud extends Model
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
        'action',
        'entite',
        'entite_cle',
        'ancien',
        'nouveau',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'extra_attributes',
        'Detail',
        'identifiants_sadge',
        'creat_by',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


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
        $this->table = 'cruds';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\CrudObservers') &&
                method_exists('\App\Observers\CrudObservers', 'creating')
            ) {

                try {
                    \App\Observers\CrudObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\CrudObservers') &&
                method_exists('\App\Observers\CrudObservers', 'created')
            ) {

                try {
                    \App\Observers\CrudObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\CrudObservers') &&
                method_exists('\App\Observers\CrudObservers', 'updating')
            ) {

                try {
                    \App\Observers\CrudObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\CrudObservers') &&
                method_exists('\App\Observers\CrudObservers', 'updated')
            ) {

                try {
                    \App\Observers\CrudObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\CrudObservers') &&
                method_exists('\App\Observers\CrudObservers', 'deleting')
            ) {

                try {
                    \App\Observers\CrudObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\CrudObservers') &&
                method_exists('\App\Observers\CrudObservers', 'deleted')
            ) {

                try {
                    \App\Observers\CrudObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getActionAttribute($value)
    {
        return $value;
    }

    public function setActionAttribute($value)
    {
        $this->attributes['action'] = $value ?? "";
    }

    public function getEntiteAttribute($value)
    {
        return $value;
    }

    public function setEntiteAttribute($value)
    {
        $this->attributes['entite'] = $value ?? "";
    }

    public function getEntiteCleAttribute($value)
    {
        return $value;
    }

    public function setEntiteCleAttribute($value)
    {
        $this->attributes['entite_cle'] = $value ?? "";
    }

    public function getAncienAttribute($value)
    {
        return $value;
    }

    public function setAncienAttribute($value)
    {
        $this->attributes['ancien'] = $value ?? "";
    }

    public function getNouveauAttribute($value)
    {
        return $value;
    }

    public function setNouveauAttribute($value)
    {
        $this->attributes['nouveau'] = $value ?? "";
    }

    public function getDetailAttribute($value)
    {
        return $value;
    }

    public function setDetailAttribute($value)
    {
        $this->attributes['Detail'] = $value ?? "";
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


        $select .= "" . $this->action . " ";


        $select .= "" . $this->entite . " ";


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

