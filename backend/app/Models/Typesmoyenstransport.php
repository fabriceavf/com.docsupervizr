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


use App\Models\Moyenstransport;


class Typesmoyenstransport extends Model
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
        'canCreate',
        'canUpdate',
        'canDelete',
        'creat_by',
        'extra_attributes',
        'created_at',
        'updated_at',
        'deleted_at',

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
        $this->table = 'typesmoyenstransports';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TypesmoyenstransportObservers') &&
                method_exists('\App\Observers\TypesmoyenstransportObservers', 'creating')
            ) {

                try {
                    \App\Observers\TypesmoyenstransportObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TypesmoyenstransportObservers') &&
                method_exists('\App\Observers\TypesmoyenstransportObservers', 'created')
            ) {

                try {
                    \App\Observers\TypesmoyenstransportObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TypesmoyenstransportObservers') &&
                method_exists('\App\Observers\TypesmoyenstransportObservers', 'updating')
            ) {

                try {
                    \App\Observers\TypesmoyenstransportObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TypesmoyenstransportObservers') &&
                method_exists('\App\Observers\TypesmoyenstransportObservers', 'updated')
            ) {

                try {
                    \App\Observers\TypesmoyenstransportObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TypesmoyenstransportObservers') &&
                method_exists('\App\Observers\TypesmoyenstransportObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TypesmoyenstransportObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TypesmoyenstransportObservers') &&
                method_exists('\App\Observers\TypesmoyenstransportObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TypesmoyenstransportObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function moyenstransports()
    {
        return $this->hasMany(Moyenstransport::class, 'typesmoyenstransport_id', 'id');
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

