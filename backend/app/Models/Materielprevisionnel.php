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


use App\Models\Chantier;


use App\Models\Materiel;


class Materielprevisionnel extends Model
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
        'materiel_id',
        'chantier_id',
        'quantite',
        'created_at',
        'updated_at',
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


        'chantier',


        'materiel',


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
        $this->table = 'materielprevisionnels';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\MaterielprevisionnelObservers') &&
                method_exists('\App\Observers\MaterielprevisionnelObservers', 'creating')
            ) {

                try {
                    \App\Observers\MaterielprevisionnelObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\MaterielprevisionnelObservers') &&
                method_exists('\App\Observers\MaterielprevisionnelObservers', 'created')
            ) {

                try {
                    \App\Observers\MaterielprevisionnelObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\MaterielprevisionnelObservers') &&
                method_exists('\App\Observers\MaterielprevisionnelObservers', 'updating')
            ) {

                try {
                    \App\Observers\MaterielprevisionnelObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\MaterielprevisionnelObservers') &&
                method_exists('\App\Observers\MaterielprevisionnelObservers', 'updated')
            ) {

                try {
                    \App\Observers\MaterielprevisionnelObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\MaterielprevisionnelObservers') &&
                method_exists('\App\Observers\MaterielprevisionnelObservers', 'deleting')
            ) {

                try {
                    \App\Observers\MaterielprevisionnelObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\MaterielprevisionnelObservers') &&
                method_exists('\App\Observers\MaterielprevisionnelObservers', 'deleted')
            ) {

                try {
                    \App\Observers\MaterielprevisionnelObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function chantier()
    {
        return $this->belongsTo(Chantier::class, 'chantier_id', 'id');
    }

    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id', 'id');
    }

    public function getMaterielIdAttribute($value)
    {
        return $value;
    }

    public function setMaterielIdAttribute($value)
    {
        $this->attributes['materiel_id'] = $value ?? "";
    }

    public function getChantierIdAttribute($value)
    {
        return $value;
    }

    public function setChantierIdAttribute($value)
    {
        $this->attributes['chantier_id'] = $value ?? "";
    }

    public function getQuantiteAttribute($value)
    {
        return $value;
    }

    public function setQuantiteAttribute($value)
    {
        $this->attributes['quantite'] = $value ?? "";
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

