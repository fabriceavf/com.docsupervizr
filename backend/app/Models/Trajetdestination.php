<?php

namespace App\Models;

use App\Observers\TrajetdestinationObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Trajetdestination extends Model
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
        'trajetstep_id',
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


        'trajetstep',


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
        $this->table = 'trajetdestinations';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TrajetdestinationObservers') &&
                method_exists('\App\Observers\TrajetdestinationObservers', 'creating')
            ) {

                try {
                    TrajetdestinationObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TrajetdestinationObservers') &&
                method_exists('\App\Observers\TrajetdestinationObservers', 'created')
            ) {

                try {
                    TrajetdestinationObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TrajetdestinationObservers') &&
                method_exists('\App\Observers\TrajetdestinationObservers', 'updating')
            ) {

                try {
                    TrajetdestinationObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TrajetdestinationObservers') &&
                method_exists('\App\Observers\TrajetdestinationObservers', 'updated')
            ) {

                try {
                    TrajetdestinationObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TrajetdestinationObservers') &&
                method_exists('\App\Observers\TrajetdestinationObservers', 'deleting')
            ) {

                try {
                    TrajetdestinationObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TrajetdestinationObservers') &&
                method_exists('\App\Observers\TrajetdestinationObservers', 'deleted')
            ) {

                try {
                    TrajetdestinationObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function trajetstep()
    {
        return $this->belongsTo(Trajetstep::class, 'trajetstep_id', 'id');
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

    public function getTrajetstepIdAttribute($value)
    {
        return $value;
    }

    public function setTrajetstepIdAttribute($value)
    {
        $this->attributes['trajetstep_id'] = $value ?? "";
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

