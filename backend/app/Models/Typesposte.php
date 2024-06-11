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


use App\Models\Horairestypesposte;


use App\Models\Import;


use App\Models\Poste;


use App\Models\Userstypesposte;


class Typesposte extends Model
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
        'identifiants_sadge',
        'canCreate',
        'canUpdate',
        'canDelete',
        'maxagent',

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
        $this->table = 'typespostes';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TypesposteObservers') &&
                method_exists('\App\Observers\TypesposteObservers', 'creating')
            ) {

                try {
                    \App\Observers\TypesposteObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TypesposteObservers') &&
                method_exists('\App\Observers\TypesposteObservers', 'created')
            ) {

                try {
                    \App\Observers\TypesposteObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TypesposteObservers') &&
                method_exists('\App\Observers\TypesposteObservers', 'updating')
            ) {

                try {
                    \App\Observers\TypesposteObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TypesposteObservers') &&
                method_exists('\App\Observers\TypesposteObservers', 'updated')
            ) {

                try {
                    \App\Observers\TypesposteObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TypesposteObservers') &&
                method_exists('\App\Observers\TypesposteObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TypesposteObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TypesposteObservers') &&
                method_exists('\App\Observers\TypesposteObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TypesposteObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function horairestypespostes()
    {
        return $this->hasMany(Horairestypesposte::class, 'typesposte_id', 'id');
    }

    public function imports()
    {
        return $this->hasMany(Import::class, 'typesposte_id', 'id');
    }

    public function postes()
    {
        return $this->hasMany(Poste::class, 'typesposte_id', 'id');
    }

    public function userstypespostes()
    {
        return $this->hasMany(Userstypesposte::class, 'typesposte_id', 'id');
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

    public function getIdentifiantsSadgeAttribute($value)
    {
        return $value;
    }

    public function setIdentifiantsSadgeAttribute($value)
    {
        $this->attributes['identifiants_sadge'] = $value ?? "";
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

    public function getMaxagentAttribute($value)
    {
        return $value;
    }

    public function setMaxagentAttribute($value)
    {
        $this->attributes['maxagent'] = $value ?? "";
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

