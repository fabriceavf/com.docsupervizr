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


use App\Models\Trajet;


use App\Models\Transporteur;


class Transporteurstrajet extends Model
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
        'transporteur_id',
        'trajet_id',
        'montant',
        'debut',
        'fin',
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


        'trajet',


        'transporteur',


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
        $this->table = 'transporteurstrajets';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TransporteurstrajetObservers') &&
                method_exists('\App\Observers\TransporteurstrajetObservers', 'creating')
            ) {

                try {
                    \App\Observers\TransporteurstrajetObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TransporteurstrajetObservers') &&
                method_exists('\App\Observers\TransporteurstrajetObservers', 'created')
            ) {

                try {
                    \App\Observers\TransporteurstrajetObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TransporteurstrajetObservers') &&
                method_exists('\App\Observers\TransporteurstrajetObservers', 'updating')
            ) {

                try {
                    \App\Observers\TransporteurstrajetObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TransporteurstrajetObservers') &&
                method_exists('\App\Observers\TransporteurstrajetObservers', 'updated')
            ) {

                try {
                    \App\Observers\TransporteurstrajetObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TransporteurstrajetObservers') &&
                method_exists('\App\Observers\TransporteurstrajetObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TransporteurstrajetObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TransporteurstrajetObservers') &&
                method_exists('\App\Observers\TransporteurstrajetObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TransporteurstrajetObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function trajet()
    {
        return $this->belongsTo(Trajet::class, 'trajet_id', 'id');
    }

    public function transporteur()
    {
        return $this->belongsTo(Transporteur::class, 'transporteur_id', 'id');
    }

    public function getTransporteurIdAttribute($value)
    {
        return $value;
    }

    public function setTransporteurIdAttribute($value)
    {
        $this->attributes['transporteur_id'] = $value ?? "";
    }

    public function getTrajetIdAttribute($value)
    {
        return $value;
    }

    public function setTrajetIdAttribute($value)
    {
        $this->attributes['trajet_id'] = $value ?? "";
    }

    public function getMontantAttribute($value)
    {
        return $value;
    }

    public function setMontantAttribute($value)
    {
        $this->attributes['montant'] = $value ?? "";
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

