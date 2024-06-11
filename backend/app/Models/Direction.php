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


use App\Models\Groupedirection;


use App\Models\Listing;


use App\Models\Service;


use App\Models\Transaction;


use App\Models\User;


class Direction extends Model
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
        'code',
        'extra_attributes',
        'created_at',
        'updated_at',
        'groupedirection_id',
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


        'groupedirection',


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
        $this->table = 'directions';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\DirectionObservers') &&
                method_exists('\App\Observers\DirectionObservers', 'creating')
            ) {

                try {
                    \App\Observers\DirectionObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\DirectionObservers') &&
                method_exists('\App\Observers\DirectionObservers', 'created')
            ) {

                try {
                    \App\Observers\DirectionObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\DirectionObservers') &&
                method_exists('\App\Observers\DirectionObservers', 'updating')
            ) {

                try {
                    \App\Observers\DirectionObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\DirectionObservers') &&
                method_exists('\App\Observers\DirectionObservers', 'updated')
            ) {

                try {
                    \App\Observers\DirectionObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\DirectionObservers') &&
                method_exists('\App\Observers\DirectionObservers', 'deleting')
            ) {

                try {
                    \App\Observers\DirectionObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\DirectionObservers') &&
                method_exists('\App\Observers\DirectionObservers', 'deleted')
            ) {

                try {
                    \App\Observers\DirectionObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function groupedirection()
    {
        return $this->belongsTo(Groupedirection::class, 'groupedirection_id', 'id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'direction_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'direction_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'direction_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'direction_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getCodeAttribute($value)
    {
        return $value;
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = $value ?? "";
    }

    public function getGroupedirectionIdAttribute($value)
    {
        return $value;
    }

    public function setGroupedirectionIdAttribute($value)
    {
        $this->attributes['groupedirection_id'] = $value ?? "";
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

