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


use App\Models\Horaire;


use App\Models\Poste;


use App\Models\Programmation;


// use App\Models\Programmationsuser;


use App\Models\Typesheure;


use App\Models\User;


use App\Models\Pointage;


use App\Models\Preuve;


class Programme extends Model
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
        'date',
        'debut_prevu',
        'fin_prevu',
        'debut_reel',
        'debut_realise',
        'fin_realise',
        'volume_horaire',
        'hs_base',
        'hs_hors_faction',
        'hs_in_faction',
        // 'programmationsuser_id',
        'horaire_id',
        'etats',
        'totalReel',
        'totalFictif',
        'extra_attributes',
        'created_at',
        'updated_at',
        'poste_id',
        'remplacant',
        'type',
        'week',
        'user',
        'DayStatut',
        'Remplacantuser',
        'PresencesDeclarer',
        'AbscencesDeclarer',
        'EtatsDeclarer',
        'Totalpresent',
        'J1',
        'J2',
        'J3',
        'J4',
        'J5',
        'J6',
        'J7',
        'J8',
        'J9',
        'J10',
        'J11',
        'J12',
        'J13',
        'J14',
        'J15',
        'J16',
        'J17',
        'J18',
        'J19',
        'J20',
        'J21',
        'J22',
        'J23',
        'J24',
        'J25',
        'J26',
        'J27',
        'J28',
        'J29',
        'J30',
        'J31',
        'deja_annaliser',
        'pointages_rattacher_auto',
        'pointages_rattacher_manuel',
        'pointages_debut_auto',
        'pointages_debut_manuel',
        'pointages_fin_auto',
        'pointages_fin_manuel',
        'presence_declarer_auto',
        'presence_declarer_manuel',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',
        'programmation_id',
        'user_id',
        'qualification_horaire',
        'fin_reel',
        'typesheure_id',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'horaire',


        'poste',


        'programmation',


        // 'programmationsuser',


        'typesheure',


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
        $this->table = 'programmes';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammeObservers') &&
                method_exists('\App\Observers\ProgrammeObservers', 'creating')
            ) {

                try {
                    \App\Observers\ProgrammeObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammeObservers') &&
                method_exists('\App\Observers\ProgrammeObservers', 'created')
            ) {

                try {
                    \App\Observers\ProgrammeObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammeObservers') &&
                method_exists('\App\Observers\ProgrammeObservers', 'updating')
            ) {

                try {
                    \App\Observers\ProgrammeObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammeObservers') &&
                method_exists('\App\Observers\ProgrammeObservers', 'updated')
            ) {

                try {
                    \App\Observers\ProgrammeObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammeObservers') &&
                method_exists('\App\Observers\ProgrammeObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ProgrammeObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammeObservers') &&
                method_exists('\App\Observers\ProgrammeObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ProgrammeObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function horaire()
    {
        return $this->belongsTo(Horaire::class, 'horaire_id', 'id');
    }

    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id', 'id');
    }

    public function programmation()
    {
        return $this->belongsTo(Programmation::class, 'programmation_id', 'id');
    }

    // public function programmationsuser()
    // {
    //     return $this->belongsTo(Programmationsuser::class, 'programmationsuser_id', 'id');
    // }

    public function typesheure()
    {
        return $this->belongsTo(Typesheure::class, 'typesheure_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pointages()
    {
        return $this->hasMany(Pointage::class, 'programme_id', 'id');
    }

    public function preuves()
    {
        return $this->hasMany(Preuve::class, 'programme_id', 'id');
    }

    public function getDateAttribute($value)
    {
        return $value;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ?? "";
    }

    public function getDebutPrevuAttribute($value)
    {
        return $value;
    }

    public function setDebutPrevuAttribute($value)
    {
        $this->attributes['debut_prevu'] = $value ?? "";
    }

    public function getFinPrevuAttribute($value)
    {
        return $value;
    }

    public function setFinPrevuAttribute($value)
    {
        $this->attributes['fin_prevu'] = $value ?? "";
    }

    public function getDebutReelAttribute($value)
    {
        return $value;
    }

    public function setDebutReelAttribute($value)
    {
        $this->attributes['debut_reel'] = $value ?? "";
    }

    public function getDebutRealiseAttribute($value)
    {
        return $value;
    }

    public function setDebutRealiseAttribute($value)
    {
        $this->attributes['debut_realise'] = $value ?? "";
    }

    public function getFinRealiseAttribute($value)
    {
        return $value;
    }

    public function setFinRealiseAttribute($value)
    {
        $this->attributes['fin_realise'] = $value ?? "";
    }

    public function getVolumeHoraireAttribute($value)
    {
        return $value;
    }

    public function setVolumeHoraireAttribute($value)
    {
        $this->attributes['volume_horaire'] = $value ?? "";
    }

    public function getHsBaseAttribute($value)
    {
        return $value;
    }

    public function setHsBaseAttribute($value)
    {
        $this->attributes['hs_base'] = $value ?? "";
    }

    public function getHsHorsFactionAttribute($value)
    {
        return $value;
    }

    public function setHsHorsFactionAttribute($value)
    {
        $this->attributes['hs_hors_faction'] = $value ?? "";
    }

    public function getHsInFactionAttribute($value)
    {
        return $value;
    }

    public function setHsInFactionAttribute($value)
    {
        $this->attributes['hs_in_faction'] = $value ?? "";
    }

    // public function getProgrammationsuserIdAttribute($value)
    // {
    //     return $value;
    // }

    // public function setProgrammationsuserIdAttribute($value)
    // {
    //     $this->attributes['programmationsuser_id'] = $value ?? "";
    // }

    public function getHoraireIdAttribute($value)
    {
        return $value;
    }

    public function setHoraireIdAttribute($value)
    {
        $this->attributes['horaire_id'] = $value ?? "";
    }

    public function getEtatsAttribute($value)
    {
        return $value;
    }

    public function setEtatsAttribute($value)
    {
        $this->attributes['etats'] = $value ?? "";
    }

    public function getTotalReelAttribute($value)
    {
        return $value;
    }

    public function setTotalReelAttribute($value)
    {
        $this->attributes['totalReel'] = $value ?? "";
    }

    public function getTotalFictifAttribute($value)
    {
        return $value;
    }

    public function setTotalFictifAttribute($value)
    {
        $this->attributes['totalFictif'] = $value ?? "";
    }

    public function getPosteIdAttribute($value)
    {
        return $value;
    }

    public function setPosteIdAttribute($value)
    {
        $this->attributes['poste_id'] = $value ?? "";
    }

    public function getRemplacantAttribute($value)
    {
        return $value;
    }

    public function setRemplacantAttribute($value)
    {
        $this->attributes['remplacant'] = $value ?? "";
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
    }

    public function getWeekAttribute($value)
    {
        return $value;
    }

    public function setWeekAttribute($value)
    {
        $this->attributes['week'] = $value ?? "";
    }

    public function getUserAttribute($value)
    {
        return $value;
    }

    public function setUserAttribute($value)
    {
        $this->attributes['user'] = $value ?? "";
    }

    public function getDayStatutAttribute($value)
    {
        return $value;
    }

    public function setDayStatutAttribute($value)
    {
        $this->attributes['DayStatut'] = $value ?? "";
    }

    public function getRemplacantuserAttribute($value)
    {
        return $value;
    }

    public function setRemplacantuserAttribute($value)
    {
        $this->attributes['Remplacantuser'] = $value ?? "";
    }

    public function getPresencesDeclarerAttribute($value)
    {
        return $value;
    }

    public function setPresencesDeclarerAttribute($value)
    {
        $this->attributes['PresencesDeclarer'] = $value ?? "";
    }

    public function getAbscencesDeclarerAttribute($value)
    {
        return $value;
    }

    public function setAbscencesDeclarerAttribute($value)
    {
        $this->attributes['AbscencesDeclarer'] = $value ?? "";
    }

    public function getEtatsDeclarerAttribute($value)
    {
        return $value;
    }

    public function setEtatsDeclarerAttribute($value)
    {
        $this->attributes['EtatsDeclarer'] = $value ?? "";
    }

    public function getTotalpresentAttribute($value)
    {
        return $value;
    }

    public function setTotalpresentAttribute($value)
    {
        $this->attributes['Totalpresent'] = $value ?? "";
    }

    public function getJ1Attribute($value)
    {
        return $value;
    }

    public function setJ1Attribute($value)
    {
        $this->attributes['J1'] = $value ?? "";
    }

    public function getJ2Attribute($value)
    {
        return $value;
    }

    public function setJ2Attribute($value)
    {
        $this->attributes['J2'] = $value ?? "";
    }

    public function getJ3Attribute($value)
    {
        return $value;
    }

    public function setJ3Attribute($value)
    {
        $this->attributes['J3'] = $value ?? "";
    }

    public function getJ4Attribute($value)
    {
        return $value;
    }

    public function setJ4Attribute($value)
    {
        $this->attributes['J4'] = $value ?? "";
    }

    public function getJ5Attribute($value)
    {
        return $value;
    }

    public function setJ5Attribute($value)
    {
        $this->attributes['J5'] = $value ?? "";
    }

    public function getJ6Attribute($value)
    {
        return $value;
    }

    public function setJ6Attribute($value)
    {
        $this->attributes['J6'] = $value ?? "";
    }

    public function getJ7Attribute($value)
    {
        return $value;
    }

    public function setJ7Attribute($value)
    {
        $this->attributes['J7'] = $value ?? "";
    }

    public function getJ8Attribute($value)
    {
        return $value;
    }

    public function setJ8Attribute($value)
    {
        $this->attributes['J8'] = $value ?? "";
    }

    public function getJ9Attribute($value)
    {
        return $value;
    }

    public function setJ9Attribute($value)
    {
        $this->attributes['J9'] = $value ?? "";
    }

    public function getJ10Attribute($value)
    {
        return $value;
    }

    public function setJ10Attribute($value)
    {
        $this->attributes['J10'] = $value ?? "";
    }

    public function getJ11Attribute($value)
    {
        return $value;
    }

    public function setJ11Attribute($value)
    {
        $this->attributes['J11'] = $value ?? "";
    }

    public function getJ12Attribute($value)
    {
        return $value;
    }

    public function setJ12Attribute($value)
    {
        $this->attributes['J12'] = $value ?? "";
    }

    public function getJ13Attribute($value)
    {
        return $value;
    }

    public function setJ13Attribute($value)
    {
        $this->attributes['J13'] = $value ?? "";
    }

    public function getJ14Attribute($value)
    {
        return $value;
    }

    public function setJ14Attribute($value)
    {
        $this->attributes['J14'] = $value ?? "";
    }

    public function getJ15Attribute($value)
    {
        return $value;
    }

    public function setJ15Attribute($value)
    {
        $this->attributes['J15'] = $value ?? "";
    }

    public function getJ16Attribute($value)
    {
        return $value;
    }

    public function setJ16Attribute($value)
    {
        $this->attributes['J16'] = $value ?? "";
    }

    public function getJ17Attribute($value)
    {
        return $value;
    }

    public function setJ17Attribute($value)
    {
        $this->attributes['J17'] = $value ?? "";
    }

    public function getJ18Attribute($value)
    {
        return $value;
    }

    public function setJ18Attribute($value)
    {
        $this->attributes['J18'] = $value ?? "";
    }

    public function getJ19Attribute($value)
    {
        return $value;
    }

    public function setJ19Attribute($value)
    {
        $this->attributes['J19'] = $value ?? "";
    }

    public function getJ20Attribute($value)
    {
        return $value;
    }

    public function setJ20Attribute($value)
    {
        $this->attributes['J20'] = $value ?? "";
    }

    public function getJ21Attribute($value)
    {
        return $value;
    }

    public function setJ21Attribute($value)
    {
        $this->attributes['J21'] = $value ?? "";
    }

    public function getJ22Attribute($value)
    {
        return $value;
    }

    public function setJ22Attribute($value)
    {
        $this->attributes['J22'] = $value ?? "";
    }

    public function getJ23Attribute($value)
    {
        return $value;
    }

    public function setJ23Attribute($value)
    {
        $this->attributes['J23'] = $value ?? "";
    }

    public function getJ24Attribute($value)
    {
        return $value;
    }

    public function setJ24Attribute($value)
    {
        $this->attributes['J24'] = $value ?? "";
    }

    public function getJ25Attribute($value)
    {
        return $value;
    }

    public function setJ25Attribute($value)
    {
        $this->attributes['J25'] = $value ?? "";
    }

    public function getJ26Attribute($value)
    {
        return $value;
    }

    public function setJ26Attribute($value)
    {
        $this->attributes['J26'] = $value ?? "";
    }

    public function getJ27Attribute($value)
    {
        return $value;
    }

    public function setJ27Attribute($value)
    {
        $this->attributes['J27'] = $value ?? "";
    }

    public function getJ28Attribute($value)
    {
        return $value;
    }

    public function setJ28Attribute($value)
    {
        $this->attributes['J28'] = $value ?? "";
    }

    public function getJ29Attribute($value)
    {
        return $value;
    }

    public function setJ29Attribute($value)
    {
        $this->attributes['J29'] = $value ?? "";
    }

    public function getJ30Attribute($value)
    {
        return $value;
    }

    public function setJ30Attribute($value)
    {
        $this->attributes['J30'] = $value ?? "";
    }

    public function getJ31Attribute($value)
    {
        return $value;
    }

    public function setJ31Attribute($value)
    {
        $this->attributes['J31'] = $value ?? "";
    }

    public function getDejaAnnaliserAttribute($value)
    {
        return $value;
    }

    public function setDejaAnnaliserAttribute($value)
    {
        $this->attributes['deja_annaliser'] = $value ?? "";
    }

    public function getPointagesRattacherAutoAttribute($value)
    {
        return $value;
    }

    public function setPointagesRattacherAutoAttribute($value)
    {
        $this->attributes['pointages_rattacher_auto'] = $value ?? "";
    }

    public function getPointagesRattacherManuelAttribute($value)
    {
        return $value;
    }

    public function setPointagesRattacherManuelAttribute($value)
    {
        $this->attributes['pointages_rattacher_manuel'] = $value ?? "";
    }

    public function getPointagesDebutAutoAttribute($value)
    {
        return $value;
    }

    public function setPointagesDebutAutoAttribute($value)
    {
        $this->attributes['pointages_debut_auto'] = $value ?? "";
    }

    public function getPointagesDebutManuelAttribute($value)
    {
        return $value;
    }

    public function setPointagesDebutManuelAttribute($value)
    {
        $this->attributes['pointages_debut_manuel'] = $value ?? "";
    }

    public function getPointagesFinAutoAttribute($value)
    {
        return $value;
    }

    public function setPointagesFinAutoAttribute($value)
    {
        $this->attributes['pointages_fin_auto'] = $value ?? "";
    }

    public function getPointagesFinManuelAttribute($value)
    {
        return $value;
    }

    public function setPointagesFinManuelAttribute($value)
    {
        $this->attributes['pointages_fin_manuel'] = $value ?? "";
    }

    public function getPresenceDeclarerAutoAttribute($value)
    {
        return $value;
    }

    public function setPresenceDeclarerAutoAttribute($value)
    {
        $this->attributes['presence_declarer_auto'] = $value ?? "";
    }

    public function getPresenceDeclarerManuelAttribute($value)
    {
        return $value;
    }

    public function setPresenceDeclarerManuelAttribute($value)
    {
        $this->attributes['presence_declarer_manuel'] = $value ?? "";
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

    public function getProgrammationIdAttribute($value)
    {
        return $value;
    }

    public function setProgrammationIdAttribute($value)
    {
        $this->attributes['programmation_id'] = $value ?? "";
    }

    public function getQualificationHoraireAttribute($value)
    {
        return $value;
    }

    public function setQualificationHoraireAttribute($value)
    {
        $this->attributes['qualification_horaire'] = $value ?? "";
    }

    public function getFinReelAttribute($value)
    {
        return $value;
    }

    public function setFinReelAttribute($value)
    {
        $this->attributes['fin_reel'] = $value ?? "";
    }

    public function getTypesheureIdAttribute($value)
    {
        return $value;
    }

    public function setTypesheureIdAttribute($value)
    {
        $this->attributes['typesheure_id'] = $value ?? "";
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

