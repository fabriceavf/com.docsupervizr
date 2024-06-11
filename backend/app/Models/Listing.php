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


use App\Models\Actif;


use App\Models\Balise;


use App\Models\Categorie;


use App\Models\Client;


use App\Models\Contrat;


use App\Models\Direction;


use App\Models\Echelon;


use App\Models\Faction;


use App\Models\Fonction;


use App\Models\Matrimoniale;


use App\Models\Nationalite;


use App\Models\Online;


use App\Models\Poste;


use App\Models\Sexe;


use App\Models\Site;


use App\Models\Situation;


use App\Models\Type;


use App\Models\Ville;


use App\Models\Zone;


class Listing extends Model
{

    use SchemalessAttributesTrait;
    use SoftDeletes;


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = '';
    protected $fillable = [
        'id',
        'date',
        'id_user',
        'name',
        'nom',
        'prenom',
        'matricule',
        'num_badge',
        'actif_id',
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
        'emp_code',
        'online_id',
        'type_id',
        'faction_id',
        'present',
        'site_id',
        'client_id',
        'id_date',
        'deleted_at',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'actif',


        'balise',


        'categorie',


        'client',


        'contrat',


        'direction',


        'echelon',


        'faction',


        'fonction',


        'matrimoniale',


        'nationalite',


        'online',


        'poste',


        'sexe',


        'site',


        'situation',


        'type',


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
        $this->table = 'listings';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ListingObservers') &&
                method_exists('\App\Observers\ListingObservers', 'creating')
            ) {

                try {
                    \App\Observers\ListingObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ListingObservers') &&
                method_exists('\App\Observers\ListingObservers', 'created')
            ) {

                try {
                    \App\Observers\ListingObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ListingObservers') &&
                method_exists('\App\Observers\ListingObservers', 'updating')
            ) {

                try {
                    \App\Observers\ListingObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ListingObservers') &&
                method_exists('\App\Observers\ListingObservers', 'updated')
            ) {

                try {
                    \App\Observers\ListingObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ListingObservers') &&
                method_exists('\App\Observers\ListingObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ListingObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ListingObservers') &&
                method_exists('\App\Observers\ListingObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ListingObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function actif()
    {
        return $this->belongsTo(Actif::class, 'actif_id', '');
    }

    public function balise()
    {
        return $this->belongsTo(Balise::class, 'balise_id', '');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id', '');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', '');
    }

    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'contrat_id', '');
    }

    public function direction()
    {
        return $this->belongsTo(Direction::class, 'direction_id', '');
    }

    public function echelon()
    {
        return $this->belongsTo(Echelon::class, 'echelon_id', '');
    }

    public function faction()
    {
        return $this->belongsTo(Faction::class, 'faction_id', '');
    }

    public function fonction()
    {
        return $this->belongsTo(Fonction::class, 'fonction_id', '');
    }

    public function matrimoniale()
    {
        return $this->belongsTo(Matrimoniale::class, 'matrimoniale_id', '');
    }

    public function nationalite()
    {
        return $this->belongsTo(Nationalite::class, 'nationalite_id', '');
    }

    public function online()
    {
        return $this->belongsTo(Online::class, 'online_id', '');
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id', '');
    }

    public function sexe()
    {
        return $this->belongsTo(Sexe::class, 'sexe_id', '');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', '');
    }

    public function situation()
    {
        return $this->belongsTo(Situation::class, 'situation_id', '');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', '');
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville_id', '');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', '');
    }

    public function getDateAttribute($value)
    {
        return $value;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ?? "";
    }

    public function getIdUserAttribute($value)
    {
        return $value;
    }

    public function setIdUserAttribute($value)
    {
        $this->attributes['id_user'] = $value ?? "";
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

    public function getActifIdAttribute($value)
    {
        return $value;
    }

    public function setActifIdAttribute($value)
    {
        $this->attributes['actif_id'] = $value ?? "";
    }

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

    public function getEmpCodeAttribute($value)
    {
        return $value;
    }

    public function setEmpCodeAttribute($value)
    {
        $this->attributes['emp_code'] = $value ?? "";
    }

    public function getOnlineIdAttribute($value)
    {
        return $value;
    }

    public function setOnlineIdAttribute($value)
    {
        $this->attributes['online_id'] = $value ?? "";
    }

    public function getTypeIdAttribute($value)
    {
        return $value;
    }

    public function setTypeIdAttribute($value)
    {
        $this->attributes['type_id'] = $value ?? "";
    }

    public function getFactionIdAttribute($value)
    {
        return $value;
    }

    public function setFactionIdAttribute($value)
    {
        $this->attributes['faction_id'] = $value ?? "";
    }

    public function getPresentAttribute($value)
    {
        return $value;
    }

    public function setPresentAttribute($value)
    {
        $this->attributes['present'] = $value ?? "";
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

    public function getIdDateAttribute($value)
    {
        return $value;
    }

    public function setIdDateAttribute($value)
    {
        $this->attributes['id_date'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        $select = "";
        try {
            $select = $this->id;
        } catch (\Throwable $e) {

        }


        $select = " " . $this->site_id;


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

