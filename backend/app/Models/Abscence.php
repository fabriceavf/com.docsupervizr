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


use App\Models\Typesabscence;


use App\Models\User;


class Abscence extends Model
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
        'raison',
        'debut',
        'fin',
        'etats',
        'typesabscence_id',
        'extra_attributes',
        'created_at',
        'updated_at',
        'valide',
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


        'typesabscence',


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
        $this->table = 'abscences';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\AbscenceObservers') &&
                method_exists('\App\Observers\AbscenceObservers', 'creating')
            ) {

                try {
                    \App\Observers\AbscenceObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\AbscenceObservers') &&
                method_exists('\App\Observers\AbscenceObservers', 'created')
            ) {

                try {
                    \App\Observers\AbscenceObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\AbscenceObservers') &&
                method_exists('\App\Observers\AbscenceObservers', 'updating')
            ) {

                try {
                    \App\Observers\AbscenceObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\AbscenceObservers') &&
                method_exists('\App\Observers\AbscenceObservers', 'updated')
            ) {

                try {
                    \App\Observers\AbscenceObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\AbscenceObservers') &&
                method_exists('\App\Observers\AbscenceObservers', 'deleting')
            ) {

                try {
                    \App\Observers\AbscenceObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\AbscenceObservers') &&
                method_exists('\App\Observers\AbscenceObservers', 'deleted')
            ) {

                try {
                    \App\Observers\AbscenceObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function typesabscence()
    {
        return $this->belongsTo(Typesabscence::class, 'typesabscence_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getRaisonAttribute($value)
    {
        return $value;
    }

    public function setRaisonAttribute($value)
    {
        $this->attributes['raison'] = $value ?? "";
    }

    public function getDebutAttribute($value)
    {
        return $value;
    }

    public function setDebutAttribute($value)
    {
        $this->attributes['debut'] = $value ?? "";
    }

    public function getFinAttribute($value)
    {
        return $value;
    }

    public function setFinAttribute($value)
    {
        $this->attributes['fin'] = $value ?? "";
    }

    public function getEtatsAttribute($value)
    {
        return $value;
    }

    public function setEtatsAttribute($value)
    {
        $this->attributes['etats'] = $value ?? "";
    }

    public function getTypesabscenceIdAttribute($value)
    {
        return $value;
    }

    public function setTypesabscenceIdAttribute($value)
    {
        $this->attributes['typesabscence_id'] = $value ?? "";
    }

    public function getValideAttribute($value)
    {
        return $value;
    }

    public function setValideAttribute($value)
    {
        $this->attributes['valide'] = $value ?? "";
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

