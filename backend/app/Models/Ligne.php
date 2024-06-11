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


use App\Models\Ville;


use App\Models\Controlleursacce;


use App\Models\Deplacement;


use App\Models\Etape;


use App\Models\Lignesmoyenstransport;


use App\Models\Trajet;


class Ligne extends Model
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
        'ville_id',
        'code',
        'libelle',
        'tarifs',
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


        'ville',


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
        $this->table = 'lignes';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\LigneObservers') &&
                method_exists('\App\Observers\LigneObservers', 'creating')
            ) {

                try {
                    \App\Observers\LigneObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\LigneObservers') &&
                method_exists('\App\Observers\LigneObservers', 'created')
            ) {

                try {
                    \App\Observers\LigneObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\LigneObservers') &&
                method_exists('\App\Observers\LigneObservers', 'updating')
            ) {

                try {
                    \App\Observers\LigneObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\LigneObservers') &&
                method_exists('\App\Observers\LigneObservers', 'updated')
            ) {

                try {
                    \App\Observers\LigneObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\LigneObservers') &&
                method_exists('\App\Observers\LigneObservers', 'deleting')
            ) {

                try {
                    \App\Observers\LigneObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\LigneObservers') &&
                method_exists('\App\Observers\LigneObservers', 'deleted')
            ) {

                try {
                    \App\Observers\LigneObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id', 'id');
    }

    public function controlleursacces()
    {
        return $this->hasMany(Controlleursacce::class, 'ligne_id', 'id');
    }

    public function deplacements()
    {
        return $this->hasMany(Deplacement::class, 'ligne_id', 'id');
    }

    public function etapes()
    {
        return $this->hasMany(Etape::class, 'ligne_id', 'id');
    }

    public function lignesmoyenstransports()
    {
        return $this->hasMany(Lignesmoyenstransport::class, 'ligne_id', 'id');
    }

    public function trajets()
    {
        return $this->hasMany(Trajet::class, 'ligne_id', 'id');
    }

    public function getVilleIdAttribute($value)
    {
        return $value;
    }

    public function setVilleIdAttribute($value)
    {
        $this->attributes['ville_id'] = $value ?? "";
    }

    public function getCodeAttribute($value)
    {
        return $value;
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = $value ?? "";
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getTarifsAttribute($value)
    {
        return $value;
    }

    public function setTarifsAttribute($value)
    {
        $this->attributes['tarifs'] = $value ?? "";
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

