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


class Switchsuser extends Model
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
        'old_type',
        'new_type',
        'action',
        'creat_by',
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
        $this->table = 'switchsusers';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\SwitchsuserObservers') &&
                method_exists('\App\Observers\SwitchsuserObservers', 'creating')
            ) {

                try {
                    \App\Observers\SwitchsuserObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\SwitchsuserObservers') &&
                method_exists('\App\Observers\SwitchsuserObservers', 'created')
            ) {

                try {
                    \App\Observers\SwitchsuserObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\SwitchsuserObservers') &&
                method_exists('\App\Observers\SwitchsuserObservers', 'updating')
            ) {

                try {
                    \App\Observers\SwitchsuserObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\SwitchsuserObservers') &&
                method_exists('\App\Observers\SwitchsuserObservers', 'updated')
            ) {

                try {
                    \App\Observers\SwitchsuserObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\SwitchsuserObservers') &&
                method_exists('\App\Observers\SwitchsuserObservers', 'deleting')
            ) {

                try {
                    \App\Observers\SwitchsuserObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\SwitchsuserObservers') &&
                method_exists('\App\Observers\SwitchsuserObservers', 'deleted')
            ) {

                try {
                    \App\Observers\SwitchsuserObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function getOldTypeAttribute($value)
    {
        return $value;
    }

    public function setOldTypeAttribute($value)
    {
        $this->attributes['old_type'] = $value ?? "";
    }

    public function getNewTypeAttribute($value)
    {
        return $value;
    }

    public function setNewTypeAttribute($value)
    {
        $this->attributes['new_type'] = $value ?? "";
    }

    public function getActionAttribute($value)
    {
        return $value;
    }

    public function setActionAttribute($value)
    {
        $this->attributes['action'] = $value ?? "";
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

