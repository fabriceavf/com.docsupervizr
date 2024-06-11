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


use App\Models\User;


use App\Models\Zone;


use App\Models\Programmesronde;


class Programmationsronde extends Model
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
        'description',
        'date_debut',
        'date_fin',
        'default_heure_debut',
        'default_heure_fin',
        'user_id',
        'statut',
        'type',
        'postesbaladeur',
        'valider1',
        'zone_id',
        'valider2',
        'poste_id',
        'etats',
        'postes',
        'min_pointage',
        'Allclients',
        'AllDatesInRange',
        'Presents',
        'Abscents',
        'Presentsid',
        'Abscentsid',
        'user_id_2',
        'user_id_3',
        'user_id_4',
        'valideur_1',
        'valideur_2',
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


        'poste',


        'user',


        'zone',


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
        $this->table = 'programmationsrondes';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsrondeObservers') &&
                method_exists('\App\Observers\ProgrammationsrondeObservers', 'creating')
            ) {

                try {
                    \App\Observers\ProgrammationsrondeObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsrondeObservers') &&
                method_exists('\App\Observers\ProgrammationsrondeObservers', 'created')
            ) {

                try {
                    \App\Observers\ProgrammationsrondeObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsrondeObservers') &&
                method_exists('\App\Observers\ProgrammationsrondeObservers', 'updating')
            ) {

                try {
                    \App\Observers\ProgrammationsrondeObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsrondeObservers') &&
                method_exists('\App\Observers\ProgrammationsrondeObservers', 'updated')
            ) {

                try {
                    \App\Observers\ProgrammationsrondeObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsrondeObservers') &&
                method_exists('\App\Observers\ProgrammationsrondeObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ProgrammationsrondeObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsrondeObservers') &&
                method_exists('\App\Observers\ProgrammationsrondeObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ProgrammationsrondeObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }

    public function programmesrondes()
    {
        return $this->hasMany(Programmesronde::class, 'programmationsronde_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value ?? "";
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

    public function getDefaultHeureDebutAttribute($value)
    {
        return $value;
    }

    public function setDefaultHeureDebutAttribute($value)
    {
        $this->attributes['default_heure_debut'] = $value ?? "";
    }

    public function getDefaultHeureFinAttribute($value)
    {
        return $value;
    }

    public function setDefaultHeureFinAttribute($value)
    {
        $this->attributes['default_heure_fin'] = $value ?? "";
    }

    public function getStatutAttribute($value)
    {
        return $value;
    }

    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = $value ?? "";
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
    }

    public function getPostesbaladeurAttribute($value)
    {
        return $value;
    }

    public function setPostesbaladeurAttribute($value)
    {
        $this->attributes['postesbaladeur'] = $value ?? "";
    }

    public function getValider1Attribute($value)
    {
        return $value;
    }

    public function setValider1Attribute($value)
    {
        $this->attributes['valider1'] = $value ?? "";
    }

    public function getZoneIdAttribute($value)
    {
        return $value;
    }

    public function setZoneIdAttribute($value)
    {
        $this->attributes['zone_id'] = $value ?? "";
    }

    public function getValider2Attribute($value)
    {
        return $value;
    }

    public function setValider2Attribute($value)
    {
        $this->attributes['valider2'] = $value ?? "";
    }

    public function getPosteIdAttribute($value)
    {
        return $value;
    }

    public function setPosteIdAttribute($value)
    {
        $this->attributes['poste_id'] = $value ?? "";
    }

    public function getEtatsAttribute($value)
    {
        return $value;
    }

    public function setEtatsAttribute($value)
    {
        $this->attributes['etats'] = $value ?? "";
    }

    public function getPostesAttribute($value)
    {
        return $value;
    }

    public function setPostesAttribute($value)
    {
        $this->attributes['postes'] = $value ?? "";
    }

    public function getMinPointageAttribute($value)
    {
        return $value;
    }

    public function setMinPointageAttribute($value)
    {
        $this->attributes['min_pointage'] = $value ?? "";
    }

    public function getAllclientsAttribute($value)
    {
        return $value;
    }

    public function setAllclientsAttribute($value)
    {
        $this->attributes['Allclients'] = $value ?? "";
    }

    public function getAllDatesInRangeAttribute($value)
    {
        return $value;
    }

    public function setAllDatesInRangeAttribute($value)
    {
        $this->attributes['AllDatesInRange'] = $value ?? "";
    }

    public function getPresentsAttribute($value)
    {
        return $value;
    }

    public function setPresentsAttribute($value)
    {
        $this->attributes['Presents'] = $value ?? "";
    }

    public function getAbscentsAttribute($value)
    {
        return $value;
    }

    public function setAbscentsAttribute($value)
    {
        $this->attributes['Abscents'] = $value ?? "";
    }

    public function getPresentsidAttribute($value)
    {
        return $value;
    }

    public function setPresentsidAttribute($value)
    {
        $this->attributes['Presentsid'] = $value ?? "";
    }

    public function getAbscentsidAttribute($value)
    {
        return $value;
    }

    public function setAbscentsidAttribute($value)
    {
        $this->attributes['Abscentsid'] = $value ?? "";
    }

    public function getUserId2Attribute($value)
    {
        return $value;
    }

    public function setUserId2Attribute($value)
    {
        $this->attributes['user_id_2'] = $value ?? "";
    }

    public function getUserId3Attribute($value)
    {
        return $value;
    }

    public function setUserId3Attribute($value)
    {
        $this->attributes['user_id_3'] = $value ?? "";
    }

    public function getUserId4Attribute($value)
    {
        return $value;
    }

    public function setUserId4Attribute($value)
    {
        $this->attributes['user_id_4'] = $value ?? "";
    }

    public function getValideur1Attribute($value)
    {
        return $value;
    }

    public function setValideur1Attribute($value)
    {
        $this->attributes['valideur_1'] = $value ?? "";
    }

    public function getValideur2Attribute($value)
    {
        return $value;
    }

    public function setValideur2Attribute($value)
    {
        $this->attributes['valideur_2'] = $value ?? "";
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

