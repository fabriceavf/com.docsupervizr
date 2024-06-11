<?php

namespace App\Models;

use App\Observers\NationObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Nation extends Model
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
        $this->table = 'nations';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\NationObservers') &&
                method_exists('\App\Observers\NationObservers', 'creating')
            ) {

                try {
                    NationObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\NationObservers') &&
                method_exists('\App\Observers\NationObservers', 'created')
            ) {

                try {
                    NationObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\NationObservers') &&
                method_exists('\App\Observers\NationObservers', 'updating')
            ) {

                try {
                    NationObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\NationObservers') &&
                method_exists('\App\Observers\NationObservers', 'updated')
            ) {

                try {
                    NationObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\NationObservers') &&
                method_exists('\App\Observers\NationObservers', 'deleting')
            ) {

                try {
                    NationObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\NationObservers') &&
                method_exists('\App\Observers\NationObservers', 'deleted')
            ) {

                try {
                    NationObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        $select = "";


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";


        $select .= "" . $this->libelle . " ";


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

