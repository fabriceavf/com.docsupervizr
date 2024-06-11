<?php

namespace App\Models;

use App\Observers\JournalObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Journal extends Model
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
        'name',
        'nom',
        'prenom',
        'matricule',
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
        'date',
        'pointeuse_id',
        'site_id',
        'badge',
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


        'contrat',


        'direction',


        'echelon',


        'faction',


        'fonction',


        'matrimoniale',


        'nationalite',


        'online',


        'pointeuse',


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
        $this->table = 'journals';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\JournalObservers') &&
                method_exists('\App\Observers\JournalObservers', 'creating')
            ) {

                try {
                    JournalObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\JournalObservers') &&
                method_exists('\App\Observers\JournalObservers', 'created')
            ) {

                try {
                    JournalObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\JournalObservers') &&
                method_exists('\App\Observers\JournalObservers', 'updating')
            ) {

                try {
                    JournalObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\JournalObservers') &&
                method_exists('\App\Observers\JournalObservers', 'updated')
            ) {

                try {
                    JournalObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\JournalObservers') &&
                method_exists('\App\Observers\JournalObservers', 'deleting')
            ) {

                try {
                    JournalObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\JournalObservers') &&
                method_exists('\App\Observers\JournalObservers', 'deleted')
            ) {

                try {
                    JournalObservers::deleted($model);

                } catch (Throwable $e) {

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

    public function pointeuse()
    {
        return $this->belongsTo(Pointeuse::class, 'pointeuse_id', '');
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

    public function getDateAttribute($value)
    {
        return $value;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ?? "";
    }

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

    public function getBadgeAttribute($value)
    {
        return $value;
    }

    public function setBadgeAttribute($value)
    {
        $this->attributes['badge'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        $select = "";


        $select .= " " . $this->pointeuse_id;


        $select .= " " . $this->site_id;


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";


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

