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


class Document extends Model
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
        'nom',
        'rubrique',
        'fichier',
        'agent_id',
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
        $this->table = 'documents';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\DocumentObservers') &&
                method_exists('\App\Observers\DocumentObservers', 'creating')
            ) {

                try {
                    \App\Observers\DocumentObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\DocumentObservers') &&
                method_exists('\App\Observers\DocumentObservers', 'created')
            ) {

                try {
                    \App\Observers\DocumentObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\DocumentObservers') &&
                method_exists('\App\Observers\DocumentObservers', 'updating')
            ) {

                try {
                    \App\Observers\DocumentObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\DocumentObservers') &&
                method_exists('\App\Observers\DocumentObservers', 'updated')
            ) {

                try {
                    \App\Observers\DocumentObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\DocumentObservers') &&
                method_exists('\App\Observers\DocumentObservers', 'deleting')
            ) {

                try {
                    \App\Observers\DocumentObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\DocumentObservers') &&
                method_exists('\App\Observers\DocumentObservers', 'deleted')
            ) {

                try {
                    \App\Observers\DocumentObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function getNomAttribute($value)
    {
        return $value;
    }

    public function setNomAttribute($value)
    {
        $this->attributes['nom'] = $value ?? "";
    }

    public function getRubriqueAttribute($value)
    {
        return $value;
    }

    public function setRubriqueAttribute($value)
    {
        $this->attributes['rubrique'] = $value ?? "";
    }

    public function getFichierAttribute($value)
    {
        return $value;
    }

    public function setFichierAttribute($value)
    {
        $this->attributes['fichier'] = $value ?? "";
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


        $select .= "" . $this->nom . " ";


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

