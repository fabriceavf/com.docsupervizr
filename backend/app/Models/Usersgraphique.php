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


use App\Models\Graphique;


use App\Models\User;


class Usersgraphique extends Model
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
        'user_id',
        'graphique_id',
        'creat_by',
        'extra_attributes',
        'created_at',
        'updated_at',
        'deleted_at',
        'identifiants_sadge',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'graphique',


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
        $this->table = 'usersgraphiques';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\UsersgraphiqueObservers') &&
                method_exists('\App\Observers\UsersgraphiqueObservers', 'creating')
            ) {

                try {
                    \App\Observers\UsersgraphiqueObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\UsersgraphiqueObservers') &&
                method_exists('\App\Observers\UsersgraphiqueObservers', 'created')
            ) {

                try {
                    \App\Observers\UsersgraphiqueObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\UsersgraphiqueObservers') &&
                method_exists('\App\Observers\UsersgraphiqueObservers', 'updating')
            ) {

                try {
                    \App\Observers\UsersgraphiqueObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\UsersgraphiqueObservers') &&
                method_exists('\App\Observers\UsersgraphiqueObservers', 'updated')
            ) {

                try {
                    \App\Observers\UsersgraphiqueObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\UsersgraphiqueObservers') &&
                method_exists('\App\Observers\UsersgraphiqueObservers', 'deleting')
            ) {

                try {
                    \App\Observers\UsersgraphiqueObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\UsersgraphiqueObservers') &&
                method_exists('\App\Observers\UsersgraphiqueObservers', 'deleted')
            ) {

                try {
                    \App\Observers\UsersgraphiqueObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function graphique()
    {
        return $this->belongsTo(Graphique::class, 'graphique_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getGraphiqueIdAttribute($value)
    {
        return $value;
    }

    public function setGraphiqueIdAttribute($value)
    {
        $this->attributes['graphique_id'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }

    public function getIdentifiantsSadgeAttribute($value)
    {
        return $value;
    }

    public function setIdentifiantsSadgeAttribute($value)
    {
        $this->attributes['identifiants_sadge'] = $value ?? "";
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

