<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;


class Poste extends Model
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
        'libelle',
        'nature',
        'coordonnees',
        'site_id',
        'typesposte_id',
        'created_at',
        'updated_at',
        'jours',
        'contratsclient_id',
        'maxjours',
        'maxnuits',
        'NbrsJours',
        'NbrsNuits',
        'IsCouvert',
        'pointeuses',
        'Agentjour',
        'Agentnuit',
        'couvertAgentjour',
        'couvertAgentnuit',
        'type',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',
        'typeagents',
        'postesarticle_id',

    ];
    protected $casts = [];
    protected $with = [


        'postesarticle',


        'contratsclient',

        'typesposte',


        'site',


    ];
    protected $appends = [
        'Selectvalue', 'Selectlabel', 'CodeConcat'
    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'postes';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\PosteObservers') &&
                method_exists('\App\Observers\PosteObservers', 'creating')
            ) {

                try {
                    \App\Observers\PosteObservers::creating($model);
                } catch (\Throwable $e) {
                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\PosteObservers') &&
                method_exists('\App\Observers\PosteObservers', 'created')
            ) {

                try {
                    \App\Observers\PosteObservers::created($model);
                } catch (\Throwable $e) {
                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\PosteObservers') &&
                method_exists('\App\Observers\PosteObservers', 'updating')
            ) {

                try {
                    \App\Observers\PosteObservers::updating($model);
                } catch (\Throwable $e) {
                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\PosteObservers') &&
                method_exists('\App\Observers\PosteObservers', 'updated')
            ) {

                try {
                    \App\Observers\PosteObservers::updated($model);
                } catch (\Throwable $e) {
                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\PosteObservers') &&
                method_exists('\App\Observers\PosteObservers', 'deleting')
            ) {

                try {
                    \App\Observers\PosteObservers::deleting($model);
                } catch (\Throwable $e) {
                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\PosteObservers') &&
                method_exists('\App\Observers\PosteObservers', 'deleted')
            ) {

                try {
                    \App\Observers\PosteObservers::deleted($model);
                } catch (\Throwable $e) {
                }
            }
        });
    }

    public function contratsclient()
    {
        return $this->belongsTo(Contratsclient::class, 'contratsclient_id', 'id');
        // return $this->belongsTo(Contratsclient::class, 'contratsclient_id', 'id')->select(['id', 'libelle']);
    }

    public function postesarticle()
    {
        return $this->belongsTo(Postesarticle::class, 'postesarticle_id', 'id')->select(['id', 'libelle']);
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function typesposte()
    {
        return $this->belongsTo(Typesposte::class, 'typesposte_id', 'id');
    }

    public function contratspostes()
    {
        return $this->hasMany(Contratsposte::class, 'poste_id', 'id');
    }

    public function listings()
    {
        return $this->hasMany(Listing::class, 'poste_id', 'id');
    }

    public function postesagents()
    {
        return $this->hasMany(Postesagent::class, 'poste_id', 'id');
    }

    public function postespointeuses()
    {
        return $this->hasMany(Postespointeuse::class, 'poste_id', 'id');
    }

    public function programmations()
    {
        return $this->hasMany(Programmation::class, 'poste_id', 'id');
    }

    public function programmes()
    {
        return $this->hasMany(Programme::class, 'poste_id', 'id');
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class, 'poste_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'poste_id', 'id');
    }

    public function transactionspostessyntheses()
    {
        return $this->hasMany(Transactionspostessynthese::class, 'poste_id', 'id');
    }

    public function transactionspostessynthesesvacations()
    {
        return $this->hasMany(Transactionspostessynthesesvacation::class, 'poste_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'poste_id', 'id');
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

    public function getNatureAttribute($value)
    {
        return $value;
    }

    public function setNatureAttribute($value)
    {
        $this->attributes['nature'] = $value ?? "";
    }

    public function getCoordonneesAttribute($value)
    {
        return $value;
    }

    public function setCoordonneesAttribute($value)
    {
        $this->attributes['coordonnees'] = $value ?? "";
    }

    public function getSiteIdAttribute($value)
    {
        return $value;
    }

    public function setSiteIdAttribute($value)
    {
        $this->attributes['site_id'] = $value ?? "";
    }

    public function getTypesposteIdAttribute($value)
    {
        return $value;
    }

    public function setTypesposteIdAttribute($value)
    {
        $this->attributes['typesposte_id'] = $value ?? "";
    }

    public function getJoursAttribute($value)
    {
        return $value;
    }

    public function setJoursAttribute($value)
    {
        $this->attributes['jours'] = $value ?? "";
    }

    public function getContratsclientIdAttribute($value)
    {
        return $value;
    }

    public function setContratsclientIdAttribute($value)
    {
        $this->attributes['contratsclient_id'] = $value ?? "";
    }

    public function getMaxjoursAttribute($value)
    {
        return $value;
    }

    public function setMaxjoursAttribute($value)
    {
        $this->attributes['maxjours'] = $value ?? "";
    }

    public function getMaxnuitsAttribute($value)
    {
        return $value;
    }

    public function setMaxnuitsAttribute($value)
    {
        $this->attributes['maxnuits'] = $value ?? "";
    }

    public function getNbrsJoursAttribute($value)
    {
        return $value;
    }

    public function setNbrsJoursAttribute($value)
    {
        $this->attributes['NbrsJours'] = $value ?? "";
    }

    public function getNbrsNuitsAttribute($value)
    {
        return $value;
    }

    public function setNbrsNuitsAttribute($value)
    {
        $this->attributes['NbrsNuits'] = $value ?? "";
    }

    public function getIsCouvertAttribute($value)
    {
        return $value;
    }

    public function setIsCouvertAttribute($value)
    {
        $this->attributes['IsCouvert'] = $value ?? "";
    }

    public function getPointeusesAttribute($value)
    {
        return $value;
    }

    public function setPointeusesAttribute($value)
    {
        $this->attributes['pointeuses'] = $value ?? "";
    }

    public function getAgentjourAttribute($value)
    {
        return $value;
    }

    public function setAgentjourAttribute($value)
    {
        $this->attributes['Agentjour'] = $value ?? "";
    }

    public function getAgentnuitAttribute($value)
    {
        return $value;
    }

    public function setAgentnuitAttribute($value)
    {
        $this->attributes['Agentnuit'] = $value ?? "";
    }

    public function getCouvertAgentjourAttribute($value)
    {
        return $value;
    }

    public function setCouvertAgentjourAttribute($value)
    {
        $this->attributes['couvertAgentjour'] = $value ?? "";
    }

    public function getCouvertAgentnuitAttribute($value)
    {
        return $value;
    }

    public function setCouvertAgentnuitAttribute($value)
    {
        $this->attributes['couvertAgentnuit'] = $value ?? "";
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
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

    public function getTypeagentsAttribute($value)
    {
        return $value;
    }

    public function setTypeagentsAttribute($value)
    {
        $this->attributes['typeagents'] = $value ?? "";
    }

    public function getPostesarticleIdAttribute($value)
    {
        return $value;
    }

    public function setPostesarticleIdAttribute($value)
    {
        $this->attributes['postesarticle_id'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        $select = "";


        $select .= " " . $this->id;


        return trim($select);
    }

    public function getSelectlabelAttribute()
    {
        $select = "";


        $select .= "" . $this->libelle . " ";


        return trim($select);
    }

    public function getCodeConcatAttribute()
    {
        $select = "";
        $code = [];
        // try {
        //     $code[] = $this->site->client->code;
        // } catch (\Throwable $e) {

        // }
        try {
            $code[] = $this->contratsclient->identifiants_sadge;
        } catch (\Throwable $e) {

        }
        try {
            $code[] = $this->site->identifiants_sadge;
        } catch (\Throwable $e) {

        }
        try {
            $code[] = $this->identifiants_sadge;
        } catch (\Throwable $e) {

        }

        $select = join('-', $code);


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


//  0 => "Code unique du client"
//  1 => "Nom du Client"
//  2 => "Code unique du Contrat Clients"
//  3 => "libelle du Contrat Clients"
//  4 => "code unique du site"
//  5 => "libelle du Site"
//  6 => "libelle de la Zone"
//  7 => "Code unique du Poste"
//  8 => "libelle du Poste"
//  9 => "Nombre de jour couvert"
//  10 => "Nombre d'agent titulaire jour/nuit"
//  11 => "Type de faction"
