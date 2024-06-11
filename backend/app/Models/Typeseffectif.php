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


use App\Models\Import;


use App\Models\User;


class Typeseffectif extends Model
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
        'creat_by',
        'extra_attributes',
        'created_at',
        'updated_at',
        'deleted_at',
        'canCreate',
        'canUpdate',
        'canDelete',
        'champHide',

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
        $this->table = 'typeseffectifs';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TypeseffectifObservers') &&
                method_exists('\App\Observers\TypeseffectifObservers', 'creating')
            ) {

                try {
                    \App\Observers\TypeseffectifObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TypeseffectifObservers') &&
                method_exists('\App\Observers\TypeseffectifObservers', 'created')
            ) {

                try {
                    \App\Observers\TypeseffectifObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TypeseffectifObservers') &&
                method_exists('\App\Observers\TypeseffectifObservers', 'updating')
            ) {

                try {
                    \App\Observers\TypeseffectifObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TypeseffectifObservers') &&
                method_exists('\App\Observers\TypeseffectifObservers', 'updated')
            ) {

                try {
                    \App\Observers\TypeseffectifObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TypeseffectifObservers') &&
                method_exists('\App\Observers\TypeseffectifObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TypeseffectifObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TypeseffectifObservers') &&
                method_exists('\App\Observers\TypeseffectifObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TypeseffectifObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function imports()
    {
        return $this->hasMany(Import::class, 'typeseffectif_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'typeseffectif_id', 'id');
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

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }

    public function getCanCreateAttribute($value)
    {
        return $value;
    }

    public function setCanCreateAttribute($value)
    {
        $this->attributes['canCreate'] = $value ?? "";
    }

    public function getCanUpdateAttribute($value)
    {
        return $value;
    }

    public function setCanUpdateAttribute($value)
    {
        $this->attributes['canUpdate'] = $value ?? "";
    }

    public function getCanDeleteAttribute($value)
    {
        return $value;
    }

    public function setCanDeleteAttribute($value)
    {
        $this->attributes['canDelete'] = $value ?? "";
    }

    public function getChampHideAttribute($value)
    {
        return $value;
    }

    public function setChampHideAttribute($value)
    {
        $this->attributes['champHide'] = $value ?? "";
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

