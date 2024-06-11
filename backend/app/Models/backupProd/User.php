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


use Illuminate\Foundation\Auth\User as Authenticatable;


use Spatie\Permission\Traits\HasRoles;


// use App\Models\Actif;


use App\Models\Balise;


use App\Models\Categorie;


use App\Models\Contrat;


use App\Models\Direction;


use App\Models\Echelon;


// use App\Models\Faction;


use App\Models\Fonction;


use App\Models\Matrimoniale;


use App\Models\Nationalite;


// use App\Models\Online;


use App\Models\Poste;


use App\Models\Role;


use App\Models\Sexe;


use App\Models\Site;


use App\Models\Situation;


use App\Models\Type;


use App\Models\Typeseffectif;


use App\Models\Ville;


use App\Models\Zone;


use App\Models\Abscence;


use App\Models\Activite;


use App\Models\Agentsrapport;


use App\Models\Attribution;


use App\Models\Conge;


use App\Models\Contratsagent;


use App\Models\Crud;


use App\Models\Ecouteur;


use App\Models\Empreinte;


use App\Models\Historiquemodelslisting;


use App\Models\Horaireagent;


use App\Models\Identification;


use App\Models\Interventionuser;


use App\Models\Listesappelsjour;


use App\Models\Listingsetat;


use App\Models\Log;


use App\Models\Modelslisting;


use App\Models\OauthAccessToken;


use App\Models\OauthAuthCode;


use App\Models\OauthClient;


use App\Models\Objectif;


use App\Models\Permissionsdetail;


use App\Models\Perm;


use App\Models\Pointage;


use App\Models\Postesagent;


use App\Models\Presence;


use App\Models\Programmation;


use App\Models\Programmationsronde;


use App\Models\Programmationsuser;


use App\Models\Programme;


use App\Models\Programmesronde;


use App\Models\Statszone;


use App\Models\Surveillance;


use App\Models\Travailleur;


use App\Models\Userbadge;


use App\Models\Usersgraphique;


use App\Models\Userstypesposte;


use App\Models\Userszone;


use App\Models\Ventilation;


use App\Models\Work;


class User extends Authenticatable
{

    use SchemalessAttributesTrait;
    use SoftDeletes;


    use HasApiTokens;
    use HasFactory;


    use Notifiable;

    use HasRoles;


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'nom',
        'prenom',
        'matricule',
        'num_badge',
        'date_naissance',
        'num_cnss',
        'num_cnamgs',
        'telephone1',
        'telephone2',
        'photo',
        'date_embauche',
        'download_date',
        // 'actif_id',
        'nationalite_id',
        'contrat_id',
        'direction_id',
        'categorie_id',
        'echelon_id',
        'sexe_id',
        'matrimoniale_id',
        'poste_id',
        'ville_id',
        'zone_id',
        'site_id',
        'situation_id',
        'balise_id',
        'fonction_id',
        'user_id',
        'email',
        'email_verified_at',
        'password',
        'emp_code',
        'nombre_enfant',
        'num_dossier',
        // 'online_id',
        'type_id',
        // 'faction_id',
        'remember_token',
        'extra_attributes',
        'created_at',
        'updated_at',
        'role_id',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',
        'typeseffectif_id',
        'postes',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $hidden = [
        // 'password',
        // 'remember_token',
        // 'two_factor_recovery_codes',
        // 'two_factor_secret',
    ];
    protected $with = [


        // 'actif',


        'balise',


        'categorie',


        'contrat',


        'direction',


        'echelon',


        // 'faction',


        'fonction',


        'matrimoniale',


        'nationalite',


        // 'online',


        'poste',


        'role',


        'sexe',


        'site',


        'situation',


        'type',


        'typeseffectif',


        'user',


        'ville',


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
        $this->table = 'users';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\UserObservers') &&
                method_exists('\App\Observers\UserObservers', 'creating')
            ) {

                try {
                    \App\Observers\UserObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\UserObservers') &&
                method_exists('\App\Observers\UserObservers', 'created')
            ) {

                try {
                    \App\Observers\UserObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\UserObservers') &&
                method_exists('\App\Observers\UserObservers', 'updating')
            ) {

                try {
                    \App\Observers\UserObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\UserObservers') &&
                method_exists('\App\Observers\UserObservers', 'updated')
            ) {

                try {
                    \App\Observers\UserObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\UserObservers') &&
                method_exists('\App\Observers\UserObservers', 'deleting')
            ) {

                try {
                    \App\Observers\UserObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\UserObservers') &&
                method_exists('\App\Observers\UserObservers', 'deleted')
            ) {

                try {
                    \App\Observers\UserObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    // public function actif()
    // {
    //     return $this->belongsTo(Actif::class, 'actif_id', 'id');
    // }

    public function balise()
    {
        return $this->belongsTo(Balise::class, 'balise_id', 'id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id', 'id');
    }

    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'contrat_id', 'id');
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class, 'direction_id', 'id');
    }

    public function echelon()
    {
        return $this->belongsTo(Echelon::class, 'echelon_id', 'id');
    }

    // public function faction()
    // {
    //     return $this->belongsTo(Faction::class, 'faction_id', 'id');
    // }

    public function fonction()
    {
        return $this->belongsTo(Fonction::class, 'fonction_id', 'id');
    }

    public function matrimoniale()
    {
        return $this->belongsTo(Matrimoniale::class, 'matrimoniale_id', 'id');
    }

    public function nationalite()
    {
        return $this->belongsTo(Nationalite::class, 'nationalite_id', 'id');
    }

    // public function online()
    // {
    //     return $this->belongsTo(Online::class, 'online_id', 'id');
    // }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function sexe()
    {
        return $this->belongsTo(Sexe::class, 'sexe_id', 'id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function situation()
    {
        return $this->belongsTo(Situation::class, 'situation_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function typeseffectif()
    {
        return $this->belongsTo(Typeseffectif::class, 'typeseffectif_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id', 'id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }

    public function abscences()
    {
        return $this->hasMany(Abscence::class, 'user_id', 'id');
    }

    public function activites()
    {
        return $this->hasMany(Activite::class, 'user_id', 'id');
    }

    public function agentsrapports()
    {
        return $this->hasMany(Agentsrapport::class, 'user_id', 'id');
    }

    public function attributions()
    {
        return $this->hasMany(Attribution::class, 'user_id', 'id');
    }

    public function conges()
    {
        return $this->hasMany(Conge::class, 'user_id', 'id');
    }

    public function contratsagents()
    {
        return $this->hasMany(Contratsagent::class, 'user_id', 'id');
    }

    public function cruds()
    {
        return $this->hasMany(Crud::class, 'user_id', 'id');
    }

    public function ecouteurs()
    {
        return $this->hasMany(Ecouteur::class, 'user_id', 'id');
    }

    public function empreintes()
    {
        return $this->hasMany(Empreinte::class, 'user_id', 'id');
    }

    public function historiquemodelslistings()
    {
        return $this->hasMany(Historiquemodelslisting::class, 'user_id', 'id');
    }

    public function horaireagents()
    {
        return $this->hasMany(Horaireagent::class, 'user_id', 'id');
    }

    public function identifications()
    {
        return $this->hasMany(Identification::class, 'user_id', 'id');
    }

    public function interventionusers()
    {
        return $this->hasMany(Interventionuser::class, 'user_id', 'id');
    }

    public function listesappelsjours()
    {
        return $this->hasMany(Listesappelsjour::class, 'user_id', 'id');
    }

    public function listingsetats()
    {
        return $this->hasMany(Listingsetat::class, 'user_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'user_id', 'id');
    }

    public function modelslistings()
    {
        return $this->hasMany(Modelslisting::class, 'user_id', 'id');
    }

    public function oauth_access_tokens()
    {
        return $this->hasMany(OauthAccessToken::class, 'user_id', 'id');
    }

    public function oauth_auth_codes()
    {
        return $this->hasMany(OauthAuthCode::class, 'user_id', 'id');
    }

    public function oauth_clients()
    {
        return $this->hasMany(OauthClient::class, 'user_id', 'id');
    }

    public function objectifs()
    {
        return $this->hasMany(Objectif::class, 'user_id', 'id');
    }

    public function permissionsdetails()
    {
        return $this->hasMany(Permissionsdetail::class, 'user_id', 'id');
    }

    public function perms()
    {
        return $this->hasMany(Perm::class, 'user_id', 'id');
    }

    public function pointages()
    {
        return $this->hasMany(Pointage::class, 'user_id', 'id');
    }

    public function postesagents()
    {
        return $this->hasMany(Postesagent::class, 'user_id', 'id');
    }

    public function presences()
    {
        return $this->hasMany(Presence::class, 'user_id', 'id');
    }

    public function programmations()
    {
        return $this->hasMany(Programmation::class, 'user_id', 'id');
    }

    public function programmationsrondes()
    {
        return $this->hasMany(Programmationsronde::class, 'user_id', 'id');
    }

    public function programmationsusers()
    {
        return $this->hasMany(Programmationsuser::class, 'user_id', 'id');
    }

    public function programmes()
    {
        return $this->hasMany(Programme::class, 'user_id', 'id');
    }

    public function programmesrondes()
    {
        return $this->hasMany(Programmesronde::class, 'user_id', 'id');
    }

    public function statszones()
    {
        return $this->hasMany(Statszone::class, 'user_id', 'id');
    }

    public function surveillances()
    {
        return $this->hasMany(Surveillance::class, 'user_id', 'id');
    }

    public function travailleurs()
    {
        return $this->hasMany(Travailleur::class, 'user_id', 'id');
    }

    public function userbadges()
    {
        return $this->hasMany(Userbadge::class, 'user_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }

    public function usersgraphiques()
    {
        return $this->hasMany(Usersgraphique::class, 'user_id', 'id');
    }

    public function userstypespostes()
    {
        return $this->hasMany(Userstypesposte::class, 'user_id', 'id');
    }

    public function userszones()
    {
        return $this->hasMany(Userszone::class, 'user_id', 'id');
    }

    public function ventilations()
    {
        return $this->hasMany(Ventilation::class, 'user_id', 'id');
    }

    public function works()
    {
        return $this->hasMany(Work::class, 'user_id', 'id');
    }

    public function getNameAttribute($value)
    {
        return $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value ?? "";
    }

    public function getNomAttribute($value)
    {
        return $value;
    }

    public function setNomAttribute($value)
    {
        $this->attributes['nom'] = $value ?? "";
    }

    public function getPrenomAttribute($value)
    {
        return $value;
    }

    public function setPrenomAttribute($value)
    {
        $this->attributes['prenom'] = $value ?? "";
    }

    public function getMatriculeAttribute($value)
    {
        return $value;
    }

    public function setMatriculeAttribute($value)
    {
        $this->attributes['matricule'] = $value ?? "";
    }

    public function getNumBadgeAttribute($value)
    {
        return $value;
    }

    public function setNumBadgeAttribute($value)
    {
        $this->attributes['num_badge'] = $value ?? "";
    }

    public function getDateNaissanceAttribute($value)
    {
        return $value;
    }

    public function setDateNaissanceAttribute($value)
    {
        $this->attributes['date_naissance'] = $value ?? "";
    }

    public function getNumCnssAttribute($value)
    {
        return $value;
    }

    public function setNumCnssAttribute($value)
    {
        $this->attributes['num_cnss'] = $value ?? "";
    }

    public function getNumCnamgsAttribute($value)
    {
        return $value;
    }

    public function setNumCnamgsAttribute($value)
    {
        $this->attributes['num_cnamgs'] = $value ?? "";
    }

    public function getTelephone1Attribute($value)
    {
        return $value;
    }

    public function setTelephone1Attribute($value)
    {
        $this->attributes['telephone1'] = $value ?? "";
    }

    public function getTelephone2Attribute($value)
    {
        return $value;
    }

    public function setTelephone2Attribute($value)
    {
        $this->attributes['telephone2'] = $value ?? "";
    }

    public function getPhotoAttribute($value)
    {
        return $value;
    }

    public function setPhotoAttribute($value)
    {
        $this->attributes['photo'] = $value ?? "";
    }

    public function getDateEmbaucheAttribute($value)
    {
        return $value;
    }

    public function setDateEmbaucheAttribute($value)
    {
        $this->attributes['date_embauche'] = $value ?? "";
    }

    public function getDownloadDateAttribute($value)
    {
        return $value;
    }

    public function setDownloadDateAttribute($value)
    {
        $this->attributes['download_date'] = $value ?? "";
    }

    // public function getActifIdAttribute($value)
    // {
    //     return $value;
    // }

    // public function setActifIdAttribute($value)
    // {
    //     $this->attributes['actif_id'] = $value ?? "";
    // }

    public function getNationaliteIdAttribute($value)
    {
        return $value;
    }

    public function setNationaliteIdAttribute($value)
    {
        $this->attributes['nationalite_id'] = $value ?? "";
    }

    public function getContratIdAttribute($value)
    {
        return $value;
    }

    public function setContratIdAttribute($value)
    {
        $this->attributes['contrat_id'] = $value ?? "";
    }

    public function getDirectionIdAttribute($value)
    {
        return $value;
    }

    public function setDirectionIdAttribute($value)
    {
        $this->attributes['direction_id'] = $value ?? "";
    }

    public function getCategorieIdAttribute($value)
    {
        return $value;
    }

    public function setCategorieIdAttribute($value)
    {
        $this->attributes['categorie_id'] = $value ?? "";
    }

    public function getEchelonIdAttribute($value)
    {
        return $value;
    }

    public function setEchelonIdAttribute($value)
    {
        $this->attributes['echelon_id'] = $value ?? "";
    }

    public function getSexeIdAttribute($value)
    {
        return $value;
    }

    public function setSexeIdAttribute($value)
    {
        $this->attributes['sexe_id'] = $value ?? "";
    }

    public function getMatrimonialeIdAttribute($value)
    {
        return $value;
    }

    public function setMatrimonialeIdAttribute($value)
    {
        $this->attributes['matrimoniale_id'] = $value ?? "";
    }

    public function getPosteIdAttribute($value)
    {
        return $value;
    }

    public function setPosteIdAttribute($value)
    {
        $this->attributes['poste_id'] = $value ?? "";
    }

    public function getVilleIdAttribute($value)
    {
        return $value;
    }

    public function setVilleIdAttribute($value)
    {
        $this->attributes['ville_id'] = $value ?? "";
    }

    public function getZoneIdAttribute($value)
    {
        return $value;
    }

    public function setZoneIdAttribute($value)
    {
        $this->attributes['zone_id'] = $value ?? "";
    }

    public function getSiteIdAttribute($value)
    {
        return $value;
    }

    public function setSiteIdAttribute($value)
    {
        $this->attributes['site_id'] = $value ?? "";
    }

    public function getSituationIdAttribute($value)
    {
        return $value;
    }

    public function setSituationIdAttribute($value)
    {
        $this->attributes['situation_id'] = $value ?? "";
    }

    public function getBaliseIdAttribute($value)
    {
        return $value;
    }

    public function setBaliseIdAttribute($value)
    {
        $this->attributes['balise_id'] = $value ?? "";
    }

    public function getFonctionIdAttribute($value)
    {
        return $value;
    }

    public function setFonctionIdAttribute($value)
    {
        $this->attributes['fonction_id'] = $value ?? "";
    }

    public function getEmailAttribute($value)
    {
        return $value;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value ?? "";
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ?? "";
    }

    public function getPasswordAttribute($value)
    {
        return $value;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $value ?? "";
    }

    public function getEmpCodeAttribute($value)
    {
        return $value;
    }

    public function setEmpCodeAttribute($value)
    {
        $this->attributes['emp_code'] = $value ?? "";
    }

    public function getNombreEnfantAttribute($value)
    {
        return $value;
    }

    public function setNombreEnfantAttribute($value)
    {
        $this->attributes['nombre_enfant'] = $value ?? "";
    }

    public function getNumDossierAttribute($value)
    {
        return $value;
    }

    public function setNumDossierAttribute($value)
    {
        $this->attributes['num_dossier'] = $value ?? "";
    }

    // public function getOnlineIdAttribute($value)
    // {
    //     return $value;
    // }

    // public function setOnlineIdAttribute($value)
    // {
    //     $this->attributes['online_id'] = $value ?? "";
    // }

    public function getTypeIdAttribute($value)
    {
        return $value;
    }

    public function setTypeIdAttribute($value)
    {
        $this->attributes['type_id'] = $value ?? "";
    }

    // public function getFactionIdAttribute($value)
    // {
    //     return $value;
    // }

    // public function setFactionIdAttribute($value)
    // {
    //     $this->attributes['faction_id'] = $value ?? "";
    // }

    public function getRememberTokenAttribute($value)
    {
        return $value;
    }

    public function setRememberTokenAttribute($value)
    {
        $this->attributes['remember_token'] = $value ?? "";
    }

    public function getRoleIdAttribute($value)
    {
        return $value;
    }

    public function setRoleIdAttribute($value)
    {
        $this->attributes['role_id'] = $value ?? "";
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

    public function getTypeseffectifIdAttribute($value)
    {
        return $value;
    }

    public function setTypeseffectifIdAttribute($value)
    {
        $this->attributes['typeseffectif_id'] = $value ?? "";
    }

    public function getPostesAttribute($value)
    {
        return $value;
    }

    public function setPostesAttribute($value)
    {
        $this->attributes['postes'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        return (is_array($this->id) ? $this->id[0] : $this->id);
    }

    public function getSelectlabelAttribute()
    {
        return $this->nom . " " . $this->prenom;


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

