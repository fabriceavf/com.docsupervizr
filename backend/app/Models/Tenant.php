<?php

namespace App\Models;

use App\Observers\TenantObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Tenant extends Model
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
        'created_at',
        'updated_at',
        'data',
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
        $this->table = 'tenants';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TenantObservers') &&
                method_exists('\App\Observers\TenantObservers', 'creating')
            ) {

                try {
                    TenantObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TenantObservers') &&
                method_exists('\App\Observers\TenantObservers', 'created')
            ) {

                try {
                    TenantObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TenantObservers') &&
                method_exists('\App\Observers\TenantObservers', 'updating')
            ) {

                try {
                    TenantObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TenantObservers') &&
                method_exists('\App\Observers\TenantObservers', 'updated')
            ) {

                try {
                    TenantObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TenantObservers') &&
                method_exists('\App\Observers\TenantObservers', 'deleting')
            ) {

                try {
                    TenantObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TenantObservers') &&
                method_exists('\App\Observers\TenantObservers', 'deleted')
            ) {

                try {
                    TenantObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function domains()
    {
        return $this->hasMany(Domain::class, 'tenant_id', 'id');
    }

    public function getDataAttribute($value)
    {
        return $value;
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = $value ?? "";
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

