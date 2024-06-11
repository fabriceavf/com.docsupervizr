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


class Analysespointeuse extends Model
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
        'pointeuses',
        'semaine',
        'lun',
        'mar',
        'mer',
        'jeu',
        'ven',
        'sam',
        'dim',
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
        $this->table = 'analysespointeuses';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeuseObservers') &&
                method_exists('\App\Observers\AnalysespointeuseObservers', 'creating')
            ) {

                try {
                    \App\Observers\AnalysespointeuseObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeuseObservers') &&
                method_exists('\App\Observers\AnalysespointeuseObservers', 'created')
            ) {

                try {
                    \App\Observers\AnalysespointeuseObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeuseObservers') &&
                method_exists('\App\Observers\AnalysespointeuseObservers', 'updating')
            ) {

                try {
                    \App\Observers\AnalysespointeuseObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeuseObservers') &&
                method_exists('\App\Observers\AnalysespointeuseObservers', 'updated')
            ) {

                try {
                    \App\Observers\AnalysespointeuseObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeuseObservers') &&
                method_exists('\App\Observers\AnalysespointeuseObservers', 'deleting')
            ) {

                try {
                    \App\Observers\AnalysespointeuseObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeuseObservers') &&
                method_exists('\App\Observers\AnalysespointeuseObservers', 'deleted')
            ) {

                try {
                    \App\Observers\AnalysespointeuseObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function getPointeusesAttribute($value)
    {
        return $value;
    }

    public function setPointeusesAttribute($value)
    {
        $this->attributes['pointeuses'] = $value ?? "";
    }

    public function getSemaineAttribute($value)
    {
        return $value;
    }

    public function setSemaineAttribute($value)
    {
        $this->attributes['semaine'] = $value ?? "";
    }

    public function getLunAttribute($value)
    {
        return $value;
    }

    public function setLunAttribute($value)
    {
        $this->attributes['lun'] = $value ?? "";
    }

    public function getMarAttribute($value)
    {
        return $value;
    }

    public function setMarAttribute($value)
    {
        $this->attributes['mar'] = $value ?? "";
    }

    public function getMerAttribute($value)
    {
        return $value;
    }

    public function setMerAttribute($value)
    {
        $this->attributes['mer'] = $value ?? "";
    }

    public function getJeuAttribute($value)
    {
        return $value;
    }

    public function setJeuAttribute($value)
    {
        $this->attributes['jeu'] = $value ?? "";
    }

    public function getVenAttribute($value)
    {
        return $value;
    }

    public function setVenAttribute($value)
    {
        $this->attributes['ven'] = $value ?? "";
    }

    public function getSamAttribute($value)
    {
        return $value;
    }

    public function setSamAttribute($value)
    {
        $this->attributes['sam'] = $value ?? "";
    }

    public function getDimAttribute($value)
    {
        return $value;
    }

    public function setDimAttribute($value)
    {
        $this->attributes['dim'] = $value ?? "";
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

