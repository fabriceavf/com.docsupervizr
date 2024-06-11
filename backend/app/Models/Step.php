<?php

namespace App\Models;

use App\Observers\StepObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Step extends Model
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
        'left',
        'right',
        'front',
        'trajet_id',
        'extra_attributes',
        'creat_by',
        'deleted_at',
        'created_at',
        'updated_at',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'trajet',


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
        $this->table = 'steps';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\StepObservers') &&
                method_exists('\App\Observers\StepObservers', 'creating')
            ) {

                try {
                    StepObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\StepObservers') &&
                method_exists('\App\Observers\StepObservers', 'created')
            ) {

                try {
                    StepObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\StepObservers') &&
                method_exists('\App\Observers\StepObservers', 'updating')
            ) {

                try {
                    StepObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\StepObservers') &&
                method_exists('\App\Observers\StepObservers', 'updated')
            ) {

                try {
                    StepObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\StepObservers') &&
                method_exists('\App\Observers\StepObservers', 'deleting')
            ) {

                try {
                    StepObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\StepObservers') &&
                method_exists('\App\Observers\StepObservers', 'deleted')
            ) {

                try {
                    StepObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function trajet()
    {
        return $this->belongsTo(Trajet::class, 'trajet_id', 'id');
    }

    public function destinations()
    {
        return $this->hasMany(Destination::class, 'step_id', 'id');
    }

    public function getLeftAttribute($value)
    {
        return $value;
    }

    public function setLeftAttribute($value)
    {
        $this->attributes['left'] = $value ?? "";
    }

    public function getRightAttribute($value)
    {
        return $value;
    }

    public function setRightAttribute($value)
    {
        $this->attributes['right'] = $value ?? "";
    }

    public function getFrontAttribute($value)
    {
        return $value;
    }

    public function setFrontAttribute($value)
    {
        $this->attributes['front'] = $value ?? "";
    }

    public function getTrajetIdAttribute($value)
    {
        return $value;
    }

    public function setTrajetIdAttribute($value)
    {
        $this->attributes['trajet_id'] = $value ?? "";
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


        $select .= " " . $this->id;


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

