<?php

namespace App\Models;

use App\Observers\AnalysespointeueObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Analysespointeue extends Model
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
        $this->table = 'analysespointeuse';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeueObservers') &&
                method_exists('\App\Observers\AnalysespointeueObservers', 'creating')
            ) {

                try {
                    AnalysespointeueObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeueObservers') &&
                method_exists('\App\Observers\AnalysespointeueObservers', 'created')
            ) {

                try {
                    AnalysespointeueObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeueObservers') &&
                method_exists('\App\Observers\AnalysespointeueObservers', 'updating')
            ) {

                try {
                    AnalysespointeueObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeueObservers') &&
                method_exists('\App\Observers\AnalysespointeueObservers', 'updated')
            ) {

                try {
                    AnalysespointeueObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeueObservers') &&
                method_exists('\App\Observers\AnalysespointeueObservers', 'deleting')
            ) {

                try {
                    AnalysespointeueObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\AnalysespointeueObservers') &&
                method_exists('\App\Observers\AnalysespointeueObservers', 'deleted')
            ) {

                try {
                    AnalysespointeueObservers::deleted($model);

                } catch (Throwable $e) {

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

    public function getSelectvalueAttribute()
    {
        $select = "";


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";


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

