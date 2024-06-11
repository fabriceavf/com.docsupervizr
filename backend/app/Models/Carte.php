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


use App\Models\Site;


use App\Models\Assignation;


use App\Models\Identification;


use App\Models\Transaction;


class Carte extends Model
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
        'code',
        'uid_mifare',
        'solde',
        'site_id',
        'etats',
        'deleted_at',
        'creat_by',
        'identifiants_sadge',
        'extra_attributes',
        'created_at',
        'updated_at',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'site',


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
        $this->table = 'cartes';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\CarteObservers') &&
                method_exists('\App\Observers\CarteObservers', 'creating')
            ) {

                try {
                    \App\Observers\CarteObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\CarteObservers') &&
                method_exists('\App\Observers\CarteObservers', 'created')
            ) {

                try {
                    \App\Observers\CarteObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\CarteObservers') &&
                method_exists('\App\Observers\CarteObservers', 'updating')
            ) {

                try {
                    \App\Observers\CarteObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\CarteObservers') &&
                method_exists('\App\Observers\CarteObservers', 'updated')
            ) {

                try {
                    \App\Observers\CarteObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\CarteObservers') &&
                method_exists('\App\Observers\CarteObservers', 'deleting')
            ) {

                try {
                    \App\Observers\CarteObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\CarteObservers') &&
                method_exists('\App\Observers\CarteObservers', 'deleted')
            ) {

                try {
                    \App\Observers\CarteObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function assignations()
    {
        return $this->hasMany(Assignation::class, 'carte_id', 'id');
    }

    public function identifications()
    {
        return $this->hasMany(Identification::class, 'carte_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'carte_id', 'id');
    }

    public function getCodeAttribute($value)
    {
        return $value;
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = $value ?? "";
    }

    public function getUidMifareAttribute($value)
    {
        return $value;
    }

    public function setUidMifareAttribute($value)
    {
        $this->attributes['uid_mifare'] = $value ?? "";
    }

    public function getSoldeAttribute($value)
    {
        return $value;
    }

    public function setSoldeAttribute($value)
    {
        $this->attributes['solde'] = $value ?? "";
    }

    public function getSiteIdAttribute($value)
    {
        return $value;
    }

    public function setSiteIdAttribute($value)
    {
        $this->attributes['site_id'] = $value ?? "";
    }

    public function getEtatsAttribute($value)
    {
        return $value;
    }

    public function setEtatsAttribute($value)
    {
        $this->attributes['etats'] = $value ?? "";
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
            $select = $this->uid_mifare;
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

