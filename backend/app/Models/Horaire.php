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


use App\Models\Poste;


use App\Models\Horaireagent;


use App\Models\Pointage;


use App\Models\Programme;


use App\Models\Programmesronde;


use App\Models\Travailleur;


class Horaire extends Model
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
        'debut',
        'fin',
        'tolerance',
        'type',
        'extra_attributes',
        'created_at',
        'updated_at',
        'parent',
        'parentId',
        'vol_horaire_min',
        'nmb_pointage_min',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',
        'poste_id',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'poste',


    ];
    protected $appends = [
        'Selectvalue', 'Selectlabel', 'SelectlabelPoste'
    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'horaires';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\HoraireObservers') &&
                method_exists('\App\Observers\HoraireObservers', 'creating')
            ) {

                try {
                    \App\Observers\HoraireObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\HoraireObservers') &&
                method_exists('\App\Observers\HoraireObservers', 'created')
            ) {

                try {
                    \App\Observers\HoraireObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\HoraireObservers') &&
                method_exists('\App\Observers\HoraireObservers', 'updating')
            ) {

                try {
                    \App\Observers\HoraireObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\HoraireObservers') &&
                method_exists('\App\Observers\HoraireObservers', 'updated')
            ) {

                try {
                    \App\Observers\HoraireObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\HoraireObservers') &&
                method_exists('\App\Observers\HoraireObservers', 'deleting')
            ) {

                try {
                    \App\Observers\HoraireObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\HoraireObservers') &&
                method_exists('\App\Observers\HoraireObservers', 'deleted')
            ) {

                try {
                    \App\Observers\HoraireObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id', 'id');
    }

    public function horaireagents()
    {
        return $this->hasMany(Horaireagent::class, 'horaire_id', 'id');
    }

    public function pointages()
    {
        return $this->hasMany(Pointage::class, 'horaire_id', 'id');
    }

    public function programmes()
    {
        return $this->hasMany(Programme::class, 'horaire_id', 'id');
    }

    public function programmesrondes()
    {
        return $this->hasMany(Programmesronde::class, 'horaire_id', 'id');
    }

    public function travailleurs()
    {
        return $this->hasMany(Travailleur::class, 'horaire_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
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

    public function getToleranceAttribute($value)
    {
        return $value;
    }

    public function setToleranceAttribute($value)
    {
        $this->attributes['tolerance'] = $value ?? "";
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
    }

    public function getParentAttribute($value)
    {
        return $value;
    }

    public function setParentAttribute($value)
    {
        $this->attributes['parent'] = $value ?? "";
    }

    public function getParentIdAttribute($value)
    {
        return $value;
    }

    public function setParentIdAttribute($value)
    {
        $this->attributes['parentId'] = $value ?? "";
    }

    public function getVolHoraireMinAttribute($value)
    {
        return $value;
    }

    public function setVolHoraireMinAttribute($value)
    {
        $this->attributes['vol_horaire_min'] = $value ?? "";
    }

    public function getNmbPointageMinAttribute($value)
    {
        return $value;
    }

    public function setNmbPointageMinAttribute($value)
    {
        $this->attributes['nmb_pointage_min'] = $value ?? "";
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

    public function getPosteIdAttribute($value)
    {
        return $value;
    }

    public function setPosteIdAttribute($value)
    {
        $this->attributes['poste_id'] = $value ?? "";
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

    public function getSelectlabelPosteAttribute()
    {
        $select = "";

        try {

            // $select .= "" . $this->poste->libelle ." "."[". $this->type . "]". " ";
            $select .= "" . $this->libelle . " (" . $this->debut . "-" . $this->fin . ")";
        } catch (\Throwable $th) {
            //throw $th;
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

