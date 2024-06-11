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


use App\Models\Tache;


class Tachespointeuse extends Model
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
        'tache_id',
        'pointeuse_id',
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


        'pointeuse',


        'tache',


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
        $this->table = 'tachespointeuses';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TachespointeuseObservers') &&
                method_exists('\App\Observers\TachespointeuseObservers', 'creating')
            ) {

                try {
                    \App\Observers\TachespointeuseObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TachespointeuseObservers') &&
                method_exists('\App\Observers\TachespointeuseObservers', 'created')
            ) {

                try {
                    \App\Observers\TachespointeuseObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TachespointeuseObservers') &&
                method_exists('\App\Observers\TachespointeuseObservers', 'updating')
            ) {

                try {
                    \App\Observers\TachespointeuseObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TachespointeuseObservers') &&
                method_exists('\App\Observers\TachespointeuseObservers', 'updated')
            ) {

                try {
                    \App\Observers\TachespointeuseObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TachespointeuseObservers') &&
                method_exists('\App\Observers\TachespointeuseObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TachespointeuseObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TachespointeuseObservers') &&
                method_exists('\App\Observers\TachespointeuseObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TachespointeuseObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function pointeuse()
    {
        return $this->belongsTo(Pointeuse::class, 'pointeuse_id', 'id');
    }

    public function tache()
    {
        return $this->belongsTo(Tache::class, 'tache_id', 'id');
    }

    public function getTacheIdAttribute($value)
    {
        return $value;
    }

    public function setTacheIdAttribute($value)
    {
        $this->attributes['tache_id'] = $value ?? "";
    }

    public function getPointeuseIdAttribute($value)
    {
        return $value;
    }

    public function setPointeuseIdAttribute($value)
    {
        $this->attributes['pointeuse_id'] = $value ?? "";
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

