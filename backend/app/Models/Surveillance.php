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


use App\Models\User;


class Surveillance extends Model
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
        'action',
        'entite',
        'entite_cle',
        'ancien',
        'nouveau',
        'ip',
        'details',
        'navigateur',
        'pays',
        'ville',
        'user_id',
        'id_base',
        'created_at',
        'updated_at',
        'deleted_at',
        'extra_attributes',
        'identifiants_sadge',
        'creat_by',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'user',


    ];
    protected $appends = [
        'Selectvalue', 'Selectlabel', 'Detail'
    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'surveillances';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\SurveillanceObservers') &&
                method_exists('\App\Observers\SurveillanceObservers', 'creating')
            ) {

                try {
                    \App\Observers\SurveillanceObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\SurveillanceObservers') &&
                method_exists('\App\Observers\SurveillanceObservers', 'created')
            ) {

                try {
                    \App\Observers\SurveillanceObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\SurveillanceObservers') &&
                method_exists('\App\Observers\SurveillanceObservers', 'updating')
            ) {

                try {
                    \App\Observers\SurveillanceObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\SurveillanceObservers') &&
                method_exists('\App\Observers\SurveillanceObservers', 'updated')
            ) {

                try {
                    \App\Observers\SurveillanceObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\SurveillanceObservers') &&
                method_exists('\App\Observers\SurveillanceObservers', 'deleting')
            ) {

                try {
                    \App\Observers\SurveillanceObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\SurveillanceObservers') &&
                method_exists('\App\Observers\SurveillanceObservers', 'deleted')
            ) {

                try {
                    \App\Observers\SurveillanceObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getActionAttribute($value)
    {
        return $value;
    }

    public function setActionAttribute($value)
    {
        $this->attributes['action'] = $value ?? "";
    }

    public function getEntiteAttribute($value)
    {
        return $value;
    }

    public function setEntiteAttribute($value)
    {
        $this->attributes['entite'] = $value ?? "";
    }

    public function getEntiteCleAttribute($value)
    {
        return $value;
    }

    public function setEntiteCleAttribute($value)
    {
        $this->attributes['entite_cle'] = $value ?? "";
    }

    public function getAncienAttribute($value)
    {
        return $value;
    }

    public function setAncienAttribute($value)
    {
        $this->attributes['ancien'] = $value ?? "";
    }

    public function getNouveauAttribute($value)
    {
        return $value;
    }

    public function setNouveauAttribute($value)
    {
        $this->attributes['nouveau'] = $value ?? "";
    }

    public function getIpAttribute($value)
    {
        return $value;
    }

    public function setIpAttribute($value)
    {
        $this->attributes['ip'] = $value ?? "";
    }

    public function getDetailsAttribute($value)
    {
        return $value;
    }

    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = $value ?? "";
    }

    public function getNavigateurAttribute($value)
    {
        return $value;
    }

    public function setNavigateurAttribute($value)
    {
        $this->attributes['navigateur'] = $value ?? "";
    }

    public function getPaysAttribute($value)
    {
        return $value;
    }

    public function setPaysAttribute($value)
    {
        $this->attributes['pays'] = $value ?? "";
    }

    public function getVilleAttribute($value)
    {
        return $value;
    }

    public function setVilleAttribute($value)
    {
        $this->attributes['ville'] = $value ?? "";
    }

    public function getIdBaseAttribute($value)
    {
        return $value;
    }

    public function setIdBaseAttribute($value)
    {
        $this->attributes['id_base'] = $value ?? "";
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


        $select .= "" . $this->action . " ";


        $select .= "" . $this->entite . " ";


        $select .= "" . $this->ip . " ";


        return trim($select);


    }

    public function getDetailAttribute()
    {

        $option = "";
        $actif = [];
        $actif = json_decode($this->nouveau);

        // dd($actif->{'type_id'});

        if ($this->action === 'Update') {
            $option .= 'Modification' . " ";
        } elseif ($this->action === 'Create') {
            $option .= 'Création' . " ";
        } elseif ($this->action === 'Delete') {
            $option .= 'Suppression' . " ";
        } else {
            $option .= $this->action;
        }
        switch ($this->entite) {
            case "Users":
                if (property_exists($actif, 'type_id')) {
                    switch ($actif->{'type_id'}) {
                        case "2":
                            $option .= 'agent';
                            break;
                        case "3":
                            $option .= 'agent ONE';
                            break;
                        default:
                            $option .= 'utilisateur';
                            break;
                    }
                }
                break;
            case "Postes":
                $option .= 'Postes';
                break;
            case "Listingsjours":
                $option .= 'Listingsjours';
                break;
            case "Transactions":
                $option .= 'pointages';
                break;
            case "Contrats":
                $option .= 'Contrats';
                break;
            case "Userszones":
                $option .= 'Userszones';
                break;
            case "Variables":
                $option .= 'Variables';
                break;
            case "Zones":
                $option .= 'Zones';
                break;
            case "Soldables":
                $option .= 'Soldables';
                break;
            case "Modelslistings":
                $option .= 'Plannification';
                break;
            case "Pointeuses":
                $option .= 'Pointeuses';
                break;
            case "Postesagents":
                $option .= 'agents titulaire';
                break;
            case "Contratsclients":
                $option .= 'Contrats clients';
                break;
            case "Clients":
                $option .= 'Clients';
                break;
            case "Abscences":
                $option .= 'Absences';
                break;
            case "Actifs":
                $option .= 'Actifs';
                break;
            case "Actions":
                $option .= 'Actions';
                break;
            case "Actionsprevisionelles":
                $option .= 'Actionsprevisionelles';
                break;
            case "Actionsrealises":
                $option .= 'Actionsrealises';
                break;
            case "Activites":
                $option .= 'Activites';
                break;
            case "Agentsrapports":
                $option .= 'Vaccation par agents';
                break;
            case "Alldatas":
                $option .= 'Alldatas';
                break;
            case "Analysespointeuse":
                $option .= 'Analysespointeuse';
                break;
            case "Approvisionements":
                $option .= 'Approvisionements';
                break;
            case "Attributions":
                $option .= 'Attributions';
                break;
            case "Auth_user":
                $option .= 'Auth_user';
                break;
            case "Badges":
                $option .= 'Badges';
                break;
            case "Balises":
                $option .= 'Balises';
                break;
            case "Besoins":
                $option .= 'Besoins';
                break;
            case "Calendriers":
                $option .= 'Calendriers';
                break;
            case "Categories":
                $option .= 'Categories';
                break;
            case "Causeracines":
                $option .= 'Causeracines';
                break;
            case "Chantiers":
                $option .= 'Chantiers';
                break;
            case "Chantierlocalisations":
                $option .= 'Chantierlocalisations';
                break;
            case "Conges":
                $option .= 'Conges';
                break;
            case "Contratsagents":
                $option .= 'Contratsagents';
                break;
            case "Contratspostes":
                $option .= 'Contratspostes';
                break;
            case "Contratssites":
                $option .= 'Contratssites';
                break;
            case "Dependances":
                $option .= 'Dependances';
                break;
            case "Details":
                $option .= 'Details';
                break;
            case "Directions":
                $option .= 'Directions';
                break;
            case "Documents":
                $option .= 'Documents';
                break;
            case "Domains":
                $option .= 'Domains';
                break;
            case "Sites":
                $option .= 'Sites';
                break;
            case "Programmations":
                $option .= 'Programmations';
                break;
            case "Programmes":
                $option .= 'Programmes';
                break;
            case "Role_has_permissions":
                $option .= "attribution d'une permision à un role";
                break;
            case "Roles":
                $option .= "Roles";
                break;
            case "Facturationuploads":
                $option .= 'Facturationuploads';
                break;
            case "Files":
                $option .= 'Files';
                break;
            case "Fonctions":
                $option .= 'Fonctions';
                break;
            case "Alarms":
                $option .= 'Alarms';
                break;
            case "Typestaches":
                $option .= 'Types de taches';
                break;
            case "Taches":
                $option .= 'taches';
                break;
            case "Horaireagents":
                $option .= 'Horaire';
                break;
            case "Horaires":
                $option .= 'Horaire';
                break;
            case "Imports":
                $option .= 'Importation';
                break;
        }
        return trim($option);
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

