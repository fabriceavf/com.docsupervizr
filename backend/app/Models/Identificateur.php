<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;


class Identificateur extends Model
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
        'carte_id',
        'date_debut',
        'date_fin',
        'statuts',
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


        'carte',


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
        $this->table = 'identificateurs';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\IdentificateurObservers') &&
                method_exists('\App\Observers\IdentificateurObservers', 'creating')
            ) {

                try {
                    \App\Observers\IdentificateurObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\IdentificateurObservers') &&
                method_exists('\App\Observers\IdentificateurObservers', 'created')
            ) {

                try {
                    \App\Observers\IdentificateurObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\IdentificateurObservers') &&
                method_exists('\App\Observers\IdentificateurObservers', 'updating')
            ) {

                try {
                    \App\Observers\IdentificateurObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\IdentificateurObservers') &&
                method_exists('\App\Observers\IdentificateurObservers', 'updated')
            ) {

                try {
                    \App\Observers\IdentificateurObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\IdentificateurObservers') &&
                method_exists('\App\Observers\IdentificateurObservers', 'deleting')
            ) {

                try {
                    \App\Observers\IdentificateurObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\IdentificateurObservers') &&
                method_exists('\App\Observers\IdentificateurObservers', 'deleted')
            ) {

                try {
                    \App\Observers\IdentificateurObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function carte()
    {
        return $this->belongsTo(Carte::class, 'carte_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'identificateur_id', 'id');
    }

    public function getCarteIdAttribute($value)
    {
        return $value;
    }

    public function setCarteIdAttribute($value)
    {
        $this->attributes['carte_id'] = $value ?? "";
    }

    public function getDateDebutAttribute($value)
    {
        return $value;
    }

    public function setDateDebutAttribute($value)
    {
        $this->attributes['date_debut'] = $value ?? "";
    }

    public function getDateFinAttribute($value)
    {
        return $value;
    }

    public function setDateFinAttribute($value)
    {
        $this->attributes['date_fin'] = $value ?? "";
    }

    public function getStatutsAttribute($value)
    {
        return $value;
    }

    public function setStatutsAttribute($value)
    {
        $this->attributes['statuts'] = $value ?? "";
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

