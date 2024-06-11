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


use App\Models\Work;


use App\Models\Detail;


class Processu extends Model
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
        'description',
        'valide_one',
        'valide_two',
        'work_id',
        'created_at',
        'updated_at',
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


        'work',


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
        $this->table = 'processus';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ProcessuObservers') &&
                method_exists('\App\Observers\ProcessuObservers', 'creating')
            ) {

                try {
                    \App\Observers\ProcessuObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ProcessuObservers') &&
                method_exists('\App\Observers\ProcessuObservers', 'created')
            ) {

                try {
                    \App\Observers\ProcessuObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ProcessuObservers') &&
                method_exists('\App\Observers\ProcessuObservers', 'updating')
            ) {

                try {
                    \App\Observers\ProcessuObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ProcessuObservers') &&
                method_exists('\App\Observers\ProcessuObservers', 'updated')
            ) {

                try {
                    \App\Observers\ProcessuObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ProcessuObservers') &&
                method_exists('\App\Observers\ProcessuObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ProcessuObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ProcessuObservers') &&
                method_exists('\App\Observers\ProcessuObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ProcessuObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function work()
    {
        return $this->belongsTo(Work::class, 'work_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(Detail::class, 'processu_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value ?? "";
    }

    public function getValideOneAttribute($value)
    {
        return $value;
    }

    public function setValideOneAttribute($value)
    {
        $this->attributes['valide_one'] = $value ?? "";
    }

    public function getValideTwoAttribute($value)
    {
        return $value;
    }

    public function setValideTwoAttribute($value)
    {
        $this->attributes['valide_two'] = $value ?? "";
    }

    public function getWorkIdAttribute($value)
    {
        return $value;
    }

    public function setWorkIdAttribute($value)
    {
        $this->attributes['work_id'] = $value ?? "";
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

