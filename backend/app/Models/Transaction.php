<?php

namespace App\Models;

use App\Models\Sexe;
use App\Models\Site;
use App\Models\User;
use App\Models\Zone;

// use App\Models\Actif;
use App\Models\Poste;
use App\Models\Ville;
use App\Models\Balise;
use App\Models\Client;

// use App\Models\Online;
use App\Models\Preuve;


use App\Models\Contrat;


use App\Models\Echelon;


// use App\Models\Faction;


use App\Models\Fonction;


use App\Models\Categorie;


use App\Models\Direction;


use App\Models\Pointeuse;


use App\Models\Situation;


use App\Models\Nationalite;


use Illuminate\Support\Arr;


use App\Models\Matrimoniale;


use App\Models\Identification;


use App\Models\Controlleursacce;


// use App\Models\Transactionsdetail;


use Laravel\Passport\HasApiTokens;


use Illuminate\Support\Facades\Gate;


// use App\Models\Transactionhistorique;


// use App\Models\Transactionsulterieur;


use Illuminate\Database\Eloquent\Model;


use Illuminate\Notifications\Notifiable;


use Illuminate\Database\Eloquent\Builder;


use Illuminate\Database\Eloquent\SoftDeletes;


use GeneaLabs\LaravelModelCaching\Traits\Cachable;


use Spatie\SchemalessAttributes\SchemalessAttributes;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;


class Transaction extends Model
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
        'bio_id',
        'area_alias',
        'first_name',
        'last_name',
        'card_no',
        'terminal_alias',
        'emp_code',
        'punch_date',
        'punch_time',
        'nom',
        'prenom',
        'matricule',
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
        'situation_id',
        'balise_id',
        'fonction_id',
        // 'online_id',
        // 'faction_id',
        'pointeuse_id',
        'site_id',
        'client_id',
        'extra_attributes',
        'created_at',
        'updated_at',
        'annuler',
        'type',
        'traiter',
        'pointeusepostes',
        'verification',
        'rechercheetape',
        'tache',
        'poste',
        'TachesPotentiels',
        'PostesPotentiels',
        'TotalPostes',
        'TotalPostescouvert',
        'TotalPostesnoncouvert',
        'TotalPostessouscouvert',
        'heure',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',
        'etats',
        'identification_id',
        'controlleursacce_id',
        'carte_id',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        // 'actif',


        'balise',


        'categorie',


        'client',


        'contrat',


        'controlleursacce',


        'direction',


        'echelon',


        // 'faction',


        'fonction',


        'identification',


        'matrimoniale',


        'nationalite',


        // 'online',


        'pointeuse',


        'poste',

        'ligne',


        'sexe',


        'site',


        'situation',


        'ville',


        'zone',


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
        $this->table = 'transactions';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TransactionObservers') &&
                method_exists('\App\Observers\TransactionObservers', 'creating')
            ) {

                try {
                    \App\Observers\TransactionObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TransactionObservers') &&
                method_exists('\App\Observers\TransactionObservers', 'created')
            ) {

                try {
                    \App\Observers\TransactionObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TransactionObservers') &&
                method_exists('\App\Observers\TransactionObservers', 'updating')
            ) {

                try {
                    \App\Observers\TransactionObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TransactionObservers') &&
                method_exists('\App\Observers\TransactionObservers', 'updated')
            ) {

                try {
                    \App\Observers\TransactionObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TransactionObservers') &&
                method_exists('\App\Observers\TransactionObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TransactionObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TransactionObservers') &&
                method_exists('\App\Observers\TransactionObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TransactionObservers::deleted($model);

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
    public function ligne()
    {
        return $this->belongsTo(Ligne::class, 'ligne_id', 'id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'contrat_id', 'id');
    }

    public function controlleursacce()
    {
        return $this->belongsTo(Controlleursacce::class, 'controlleursacce_id', 'id');
    }

    public function carte()
    {
        return $this->belongsTo(Carte::class, 'carte_id', 'id');
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

    public function identification()
    {
        return $this->belongsTo(Identification::class, 'identification_id', 'id');
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

    public function pointeuse()
    {
        return $this->belongsTo(Pointeuse::class, 'terminal_alias', 'code');
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id', 'id');
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

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id', 'id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'card_no', 'num_badge');
    }

    public function preuves()
    {
        return $this->hasMany(Preuve::class, 'transaction_id', 'id');
    }

    // public function transactionhistoriques()
    // {
    //     return $this->hasMany(Transactionhistorique::class, 'transaction_id', 'id');
    // }

    // public function transactionsdetails()
    // {
    //     return $this->hasMany(Transactionsdetail::class, 'transaction_id', 'id');
    // }

    // public function transactionsulterieurs()
    // {
    //     return $this->hasMany(Transactionsulterieur::class, 'transaction_id', 'id');
    // }

    public function getBioIdAttribute($value)
    {
        return $value;
    }

    public function setBioIdAttribute($value)
    {
        $this->attributes['bio_id'] = $value ?? "";
    }

    public function getAreaAliasAttribute($value)
    {
        return $value;
    }

    public function setAreaAliasAttribute($value)
    {
        $this->attributes['area_alias'] = $value ?? "";
    }

    public function getFirstNameAttribute($value)
    {
        return $value;
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = $value ?? "";
    }

    public function getLastNameAttribute($value)
    {
        return $value;
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = $value ?? "";
    }

    public function getCardNoAttribute($value)
    {
        return $value;
    }

    public function setCardNoAttribute($value)
    {
        $this->attributes['card_no'] = $value ?? "";
    }

    public function getTerminalAliasAttribute($value)
    {
        return $value;
    }

    public function setTerminalAliasAttribute($value)
    {
        $this->attributes['terminal_alias'] = $value ?? "";
    }

    public function getEmpCodeAttribute($value)
    {
        return $value;
    }

    public function setEmpCodeAttribute($value)
    {
        $this->attributes['emp_code'] = $value ?? "";
    }

    public function getPunchDateAttribute($value)
    {
        return $value;
    }

    public function setPunchDateAttribute($value)
    {
        $this->attributes['punch_date'] = $value ?? "";
    }

    public function getPunchTimeAttribute($value)
    {
        return $value;
    }

    public function setPunchTimeAttribute($value)
    {
        $this->attributes['punch_time'] = $value ?? "";
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

    // public function getOnlineIdAttribute($value)
    // {
    //     return $value;
    // }

    // public function setOnlineIdAttribute($value)
    // {
    //     $this->attributes['online_id'] = $value ?? "";
    // }

    // public function getFactionIdAttribute($value)
    // {
    //     return $value;
    // }

    // public function setFactionIdAttribute($value)
    // {
    //     $this->attributes['faction_id'] = $value ?? "";
    // }

    public function getPointeuseIdAttribute($value)
    {
        return $value;
    }

    public function setPointeuseIdAttribute($value)
    {
        $this->attributes['pointeuse_id'] = $value ?? "";
    }

    public function getSiteIdAttribute($value)
    {
        return $value;
    }

    public function setSiteIdAttribute($value)
    {
        $this->attributes['site_id'] = $value ?? "";
    }

    public function getClientIdAttribute($value)
    {
        return $value;
    }

    public function setClientIdAttribute($value)
    {
        $this->attributes['client_id'] = $value ?? "";
    }

    public function getAnnulerAttribute($value)
    {
        return $value;
    }

    public function setAnnulerAttribute($value)
    {
        $this->attributes['annuler'] = $value ?? "";
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
    }

    public function getTraiterAttribute($value)
    {
        return $value;
    }

    public function setTraiterAttribute($value)
    {
        $this->attributes['traiter'] = $value ?? "";
    }

    public function getPointeusepostesAttribute($value)
    {
        return $value;
    }

    public function setPointeusepostesAttribute($value)
    {
        $this->attributes['pointeusepostes'] = $value ?? "";
    }

    public function getVerificationAttribute($value)
    {
        return $value;
    }

    public function setVerificationAttribute($value)
    {
        $this->attributes['verification'] = $value ?? "";
    }

    public function getRechercheetapeAttribute($value)
    {
        return $value;
    }

    public function setRechercheetapeAttribute($value)
    {
        $this->attributes['rechercheetape'] = $value ?? "";
    }

    public function getTacheAttribute($value)
    {
        return $value;
    }

    public function setTacheAttribute($value)
    {
        $this->attributes['tache'] = $value ?? "";
    }

    public function getPosteAttribute($value)
    {
        return $value;
    }

    public function setPosteAttribute($value)
    {
        $this->attributes['poste'] = $value ?? "";
    }

    public function getTachesPotentielsAttribute($value)
    {
        return $value;
    }

    public function setTachesPotentielsAttribute($value)
    {
        $this->attributes['TachesPotentiels'] = $value ?? "";
    }

    public function getPostesPotentielsAttribute($value)
    {
        return $value;
    }

    public function setPostesPotentielsAttribute($value)
    {
        $this->attributes['PostesPotentiels'] = $value ?? "";
    }

    public function getTotalPostesAttribute($value)
    {
        return $value;
    }

    public function setTotalPostesAttribute($value)
    {
        $this->attributes['TotalPostes'] = $value ?? "";
    }

    public function getTotalPostescouvertAttribute($value)
    {
        return $value;
    }

    public function setTotalPostescouvertAttribute($value)
    {
        $this->attributes['TotalPostescouvert'] = $value ?? "";
    }

    public function getTotalPostesnoncouvertAttribute($value)
    {
        return $value;
    }

    public function setTotalPostesnoncouvertAttribute($value)
    {
        $this->attributes['TotalPostesnoncouvert'] = $value ?? "";
    }

    public function getTotalPostessouscouvertAttribute($value)
    {
        return $value;
    }

    public function setTotalPostessouscouvertAttribute($value)
    {
        $this->attributes['TotalPostessouscouvert'] = $value ?? "";
    }

    public function getHeureAttribute($value)
    {
        return $value;
    }

    public function setHeureAttribute($value)
    {
        $this->attributes['heure'] = $value ?? "";
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

    public function getEtatsAttribute($value)
    {
        return $value;
    }

    public function setEtatsAttribute($value)
    {
        $this->attributes['etats'] = $value ?? "";
    }

    public function getIdentificationIdAttribute($value)
    {
        return $value;
    }

    public function setIdentificationIdAttribute($value)
    {
        $this->attributes['identification_id'] = $value ?? "";
    }

    public function getControlleursacceIdAttribute($value)
    {
        return $value;
    }

    public function setControlleursacceIdAttribute($value)
    {
        $this->attributes['controlleursacce_id'] = $value ?? "";
    }

    public function getCarteIdAttribute($value)
    {
        return $value;
    }

    public function setCarteIdAttribute($value)
    {
        $this->attributes['carte_id'] = $value ?? "";
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

