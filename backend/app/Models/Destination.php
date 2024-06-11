<?php

namespace App\Models;

use App\Observers\DestinationObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Destination extends Model
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
        'direction',
        'type',
        'step_id',
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


        'step',


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
        $this->table = 'destinations';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\DestinationObservers') &&
                method_exists('\App\Observers\DestinationObservers', 'creating')
            ) {

                try {
                    DestinationObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\DestinationObservers') &&
                method_exists('\App\Observers\DestinationObservers', 'created')
            ) {

                try {
                    DestinationObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\DestinationObservers') &&
                method_exists('\App\Observers\DestinationObservers', 'updating')
            ) {

                try {
                    DestinationObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\DestinationObservers') &&
                method_exists('\App\Observers\DestinationObservers', 'updated')
            ) {

                try {
                    DestinationObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\DestinationObservers') &&
                method_exists('\App\Observers\DestinationObservers', 'deleting')
            ) {

                try {
                    DestinationObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\DestinationObservers') &&
                method_exists('\App\Observers\DestinationObservers', 'deleted')
            ) {

                try {
                    DestinationObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function step()
    {
        return $this->belongsTo(Step::class, 'step_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getDirectionAttribute($value)
    {
        return $value;
    }

    public function setDirectionAttribute($value)
    {
        $this->attributes['direction'] = $value ?? "";
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
    }

    public function getStepIdAttribute($value)
    {
        return $value;
    }

    public function setStepIdAttribute($value)
    {
        $this->attributes['step_id'] = $value ?? "";
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

