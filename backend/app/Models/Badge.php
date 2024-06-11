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


use App\Models\Client;


use App\Models\Dependance;


class Badge extends Model
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
        'client_id',
        'content',
        'created_at',
        'updated_at',
        'js',
        'libelle',
        'css',
        'node_version',
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


        'client',


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
        $this->table = 'badges';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\BadgeObservers') &&
                method_exists('\App\Observers\BadgeObservers', 'creating')
            ) {

                try {
                    \App\Observers\BadgeObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\BadgeObservers') &&
                method_exists('\App\Observers\BadgeObservers', 'created')
            ) {

                try {
                    \App\Observers\BadgeObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\BadgeObservers') &&
                method_exists('\App\Observers\BadgeObservers', 'updating')
            ) {

                try {
                    \App\Observers\BadgeObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\BadgeObservers') &&
                method_exists('\App\Observers\BadgeObservers', 'updated')
            ) {

                try {
                    \App\Observers\BadgeObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\BadgeObservers') &&
                method_exists('\App\Observers\BadgeObservers', 'deleting')
            ) {

                try {
                    \App\Observers\BadgeObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\BadgeObservers') &&
                method_exists('\App\Observers\BadgeObservers', 'deleted')
            ) {

                try {
                    \App\Observers\BadgeObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function dependances()
    {
        return $this->hasMany(Dependance::class, 'badge_id', 'id');
    }

    public function getClientIdAttribute($value)
    {
        return $value;
    }

    public function setClientIdAttribute($value)
    {
        $this->attributes['client_id'] = $value ?? "";
    }

    public function getContentAttribute($value)
    {
        return $value;
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = $value ?? "";
    }

    public function getJsAttribute($value)
    {
        return $value;
    }

    public function setJsAttribute($value)
    {
        $this->attributes['js'] = $value ?? "";
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getCssAttribute($value)
    {
        return $value;
    }

    public function setCssAttribute($value)
    {
        $this->attributes['css'] = $value ?? "";
    }

    public function getNodeVersionAttribute($value)
    {
        return $value;
    }

    public function setNodeVersionAttribute($value)
    {
        $this->attributes['node_version'] = $value ?? "";
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

