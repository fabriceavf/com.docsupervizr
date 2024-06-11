<?php

namespace App\Models;

use App\Observers\TrajetstepObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Trajetstep extends Model
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
        'deplacement_type',
        'type_deplacement',
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
        $this->table = 'trajetsteps';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TrajetstepObservers') &&
                method_exists('\App\Observers\TrajetstepObservers', 'creating')
            ) {

                try {
                    TrajetstepObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TrajetstepObservers') &&
                method_exists('\App\Observers\TrajetstepObservers', 'created')
            ) {

                try {
                    TrajetstepObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TrajetstepObservers') &&
                method_exists('\App\Observers\TrajetstepObservers', 'updating')
            ) {

                try {
                    TrajetstepObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TrajetstepObservers') &&
                method_exists('\App\Observers\TrajetstepObservers', 'updated')
            ) {

                try {
                    TrajetstepObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TrajetstepObservers') &&
                method_exists('\App\Observers\TrajetstepObservers', 'deleting')
            ) {

                try {
                    TrajetstepObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TrajetstepObservers') &&
                method_exists('\App\Observers\TrajetstepObservers', 'deleted')
            ) {

                try {
                    TrajetstepObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function trajet()
    {
        return $this->belongsTo(Trajet::class, 'trajet_id', 'id');
    }

    public function trajetdestinations()
    {
        return $this->hasMany(Trajetdestination::class, 'trajetstep_id', 'id');
    }

    public function getDeplacementTypeAttribute($value)
    {
        return $value;
    }

    public function setDeplacementTypeAttribute($value)
    {
        $this->attributes['deplacement_type'] = $value ?? "";
    }

    public function getTypeDeplacementAttribute($value)
    {
        return $value;
    }

    public function setTypeDeplacementAttribute($value)
    {
        $this->attributes['type_deplacement'] = $value ?? "";
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

