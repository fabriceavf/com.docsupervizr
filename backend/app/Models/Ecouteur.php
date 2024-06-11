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


use App\Models\User;


class Ecouteur extends Model
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
        'avant',
        'apres',
        'attribut',
        'created_at',
        'updated_at',
        'agent_id',
        'user_id',
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


        'user',


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
        $this->table = 'ecouteurs';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\EcouteurObservers') &&
                method_exists('\App\Observers\EcouteurObservers', 'creating')
            ) {

                try {
                    \App\Observers\EcouteurObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\EcouteurObservers') &&
                method_exists('\App\Observers\EcouteurObservers', 'created')
            ) {

                try {
                    \App\Observers\EcouteurObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\EcouteurObservers') &&
                method_exists('\App\Observers\EcouteurObservers', 'updating')
            ) {

                try {
                    \App\Observers\EcouteurObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\EcouteurObservers') &&
                method_exists('\App\Observers\EcouteurObservers', 'updated')
            ) {

                try {
                    \App\Observers\EcouteurObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\EcouteurObservers') &&
                method_exists('\App\Observers\EcouteurObservers', 'deleting')
            ) {

                try {
                    \App\Observers\EcouteurObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\EcouteurObservers') &&
                method_exists('\App\Observers\EcouteurObservers', 'deleted')
            ) {

                try {
                    \App\Observers\EcouteurObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getAvantAttribute($value)
    {
        return $value;
    }

    public function setAvantAttribute($value)
    {
        $this->attributes['avant'] = $value ?? "";
    }

    public function getApresAttribute($value)
    {
        return $value;
    }

    public function setApresAttribute($value)
    {
        $this->attributes['apres'] = $value ?? "";
    }

    public function getAttributAttribute($value)
    {
        return $value;
    }

    public function setAttributAttribute($value)
    {
        $this->attributes['attribut'] = $value ?? "";
    }

    public function getAgentIdAttribute($value)
    {
        return $value;
    }

    public function setAgentIdAttribute($value)
    {
        $this->attributes['agent_id'] = $value ?? "";
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


        $select = " " . $this->id;


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

