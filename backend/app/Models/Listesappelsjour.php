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


use App\Models\Listesappel;


use App\Models\User;


class Listesappelsjour extends Model
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
        'rand',
        'jour01',
        'jour02',
        'jour03',
        'jour04',
        'jour05',
        'jour06',
        'jour07',
        'jour08',
        'jour09',
        'jour10',
        'jour11',
        'jour12',
        'jour13',
        'jour14',
        'jour15',
        'jour16',
        'jour17',
        'jour18',
        'jour19',
        'jour20',
        'jour21',
        'jour22',
        'jour23',
        'jour24',
        'jour25',
        'jour26',
        'jour27',
        'jour28',
        'jour29',
        'jour30',
        'jour31',
        'tache01',
        'tache02',
        'tache03',
        'tache04',
        'tache05',
        'tache06',
        'tache07',
        'tache08',
        'tache09',
        'tache10',
        'tache11',
        'tache12',
        'tache13',
        'tache14',
        'tache15',
        'tache16',
        'tache17',
        'tache18',
        'tache19',
        'tache20',
        'tache21',
        'tache22',
        'tache23',
        'tache24',
        'tache25',
        'tache26',
        'tache27',
        'tache28',
        'tache29',
        'tache30',
        'tache31',
        'listesappel_id',
        'user_id',
        'extra_attributes',
        'created_at',
        'updated_at',
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


        'listesappel',


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
        $this->table = 'listesappelsjours';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ListesappelsjourObservers') &&
                method_exists('\App\Observers\ListesappelsjourObservers', 'creating')
            ) {

                try {
                    \App\Observers\ListesappelsjourObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ListesappelsjourObservers') &&
                method_exists('\App\Observers\ListesappelsjourObservers', 'created')
            ) {

                try {
                    \App\Observers\ListesappelsjourObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ListesappelsjourObservers') &&
                method_exists('\App\Observers\ListesappelsjourObservers', 'updating')
            ) {

                try {
                    \App\Observers\ListesappelsjourObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ListesappelsjourObservers') &&
                method_exists('\App\Observers\ListesappelsjourObservers', 'updated')
            ) {

                try {
                    \App\Observers\ListesappelsjourObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ListesappelsjourObservers') &&
                method_exists('\App\Observers\ListesappelsjourObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ListesappelsjourObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ListesappelsjourObservers') &&
                method_exists('\App\Observers\ListesappelsjourObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ListesappelsjourObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function listesappel()
    {
        return $this->belongsTo(Listesappel::class, 'listesappel_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getRandAttribute($value)
    {
        return $value;
    }

    public function setRandAttribute($value)
    {
        $this->attributes['rand'] = $value ?? "";
    }

    public function getJour01Attribute($value)
    {
        return $value;
    }

    public function setJour01Attribute($value)
    {
        $this->attributes['jour01'] = $value ?? "";
    }

    public function getJour02Attribute($value)
    {
        return $value;
    }

    public function setJour02Attribute($value)
    {
        $this->attributes['jour02'] = $value ?? "";
    }

    public function getJour03Attribute($value)
    {
        return $value;
    }

    public function setJour03Attribute($value)
    {
        $this->attributes['jour03'] = $value ?? "";
    }

    public function getJour04Attribute($value)
    {
        return $value;
    }

    public function setJour04Attribute($value)
    {
        $this->attributes['jour04'] = $value ?? "";
    }

    public function getJour05Attribute($value)
    {
        return $value;
    }

    public function setJour05Attribute($value)
    {
        $this->attributes['jour05'] = $value ?? "";
    }

    public function getJour06Attribute($value)
    {
        return $value;
    }

    public function setJour06Attribute($value)
    {
        $this->attributes['jour06'] = $value ?? "";
    }

    public function getJour07Attribute($value)
    {
        return $value;
    }

    public function setJour07Attribute($value)
    {
        $this->attributes['jour07'] = $value ?? "";
    }

    public function getJour08Attribute($value)
    {
        return $value;
    }

    public function setJour08Attribute($value)
    {
        $this->attributes['jour08'] = $value ?? "";
    }

    public function getJour09Attribute($value)
    {
        return $value;
    }

    public function setJour09Attribute($value)
    {
        $this->attributes['jour09'] = $value ?? "";
    }

    public function getJour10Attribute($value)
    {
        return $value;
    }

    public function setJour10Attribute($value)
    {
        $this->attributes['jour10'] = $value ?? "";
    }

    public function getJour11Attribute($value)
    {
        return $value;
    }

    public function setJour11Attribute($value)
    {
        $this->attributes['jour11'] = $value ?? "";
    }

    public function getJour12Attribute($value)
    {
        return $value;
    }

    public function setJour12Attribute($value)
    {
        $this->attributes['jour12'] = $value ?? "";
    }

    public function getJour13Attribute($value)
    {
        return $value;
    }

    public function setJour13Attribute($value)
    {
        $this->attributes['jour13'] = $value ?? "";
    }

    public function getJour14Attribute($value)
    {
        return $value;
    }

    public function setJour14Attribute($value)
    {
        $this->attributes['jour14'] = $value ?? "";
    }

    public function getJour15Attribute($value)
    {
        return $value;
    }

    public function setJour15Attribute($value)
    {
        $this->attributes['jour15'] = $value ?? "";
    }

    public function getJour16Attribute($value)
    {
        return $value;
    }

    public function setJour16Attribute($value)
    {
        $this->attributes['jour16'] = $value ?? "";
    }

    public function getJour17Attribute($value)
    {
        return $value;
    }

    public function setJour17Attribute($value)
    {
        $this->attributes['jour17'] = $value ?? "";
    }

    public function getJour18Attribute($value)
    {
        return $value;
    }

    public function setJour18Attribute($value)
    {
        $this->attributes['jour18'] = $value ?? "";
    }

    public function getJour19Attribute($value)
    {
        return $value;
    }

    public function setJour19Attribute($value)
    {
        $this->attributes['jour19'] = $value ?? "";
    }

    public function getJour20Attribute($value)
    {
        return $value;
    }

    public function setJour20Attribute($value)
    {
        $this->attributes['jour20'] = $value ?? "";
    }

    public function getJour21Attribute($value)
    {
        return $value;
    }

    public function setJour21Attribute($value)
    {
        $this->attributes['jour21'] = $value ?? "";
    }

    public function getJour22Attribute($value)
    {
        return $value;
    }

    public function setJour22Attribute($value)
    {
        $this->attributes['jour22'] = $value ?? "";
    }

    public function getJour23Attribute($value)
    {
        return $value;
    }

    public function setJour23Attribute($value)
    {
        $this->attributes['jour23'] = $value ?? "";
    }

    public function getJour24Attribute($value)
    {
        return $value;
    }

    public function setJour24Attribute($value)
    {
        $this->attributes['jour24'] = $value ?? "";
    }

    public function getJour25Attribute($value)
    {
        return $value;
    }

    public function setJour25Attribute($value)
    {
        $this->attributes['jour25'] = $value ?? "";
    }

    public function getJour26Attribute($value)
    {
        return $value;
    }

    public function setJour26Attribute($value)
    {
        $this->attributes['jour26'] = $value ?? "";
    }

    public function getJour27Attribute($value)
    {
        return $value;
    }

    public function setJour27Attribute($value)
    {
        $this->attributes['jour27'] = $value ?? "";
    }

    public function getJour28Attribute($value)
    {
        return $value;
    }

    public function setJour28Attribute($value)
    {
        $this->attributes['jour28'] = $value ?? "";
    }

    public function getJour29Attribute($value)
    {
        return $value;
    }

    public function setJour29Attribute($value)
    {
        $this->attributes['jour29'] = $value ?? "";
    }

    public function getJour30Attribute($value)
    {
        return $value;
    }

    public function setJour30Attribute($value)
    {
        $this->attributes['jour30'] = $value ?? "";
    }

    public function getJour31Attribute($value)
    {
        return $value;
    }

    public function setJour31Attribute($value)
    {
        $this->attributes['jour31'] = $value ?? "";
    }

    public function getTache01Attribute($value)
    {
        return $value;
    }

    public function setTache01Attribute($value)
    {
        $this->attributes['tache01'] = $value ?? "";
    }

    public function getTache02Attribute($value)
    {
        return $value;
    }

    public function setTache02Attribute($value)
    {
        $this->attributes['tache02'] = $value ?? "";
    }

    public function getTache03Attribute($value)
    {
        return $value;
    }

    public function setTache03Attribute($value)
    {
        $this->attributes['tache03'] = $value ?? "";
    }

    public function getTache04Attribute($value)
    {
        return $value;
    }

    public function setTache04Attribute($value)
    {
        $this->attributes['tache04'] = $value ?? "";
    }

    public function getTache05Attribute($value)
    {
        return $value;
    }

    public function setTache05Attribute($value)
    {
        $this->attributes['tache05'] = $value ?? "";
    }

    public function getTache06Attribute($value)
    {
        return $value;
    }

    public function setTache06Attribute($value)
    {
        $this->attributes['tache06'] = $value ?? "";
    }

    public function getTache07Attribute($value)
    {
        return $value;
    }

    public function setTache07Attribute($value)
    {
        $this->attributes['tache07'] = $value ?? "";
    }

    public function getTache08Attribute($value)
    {
        return $value;
    }

    public function setTache08Attribute($value)
    {
        $this->attributes['tache08'] = $value ?? "";
    }

    public function getTache09Attribute($value)
    {
        return $value;
    }

    public function setTache09Attribute($value)
    {
        $this->attributes['tache09'] = $value ?? "";
    }

    public function getTache10Attribute($value)
    {
        return $value;
    }

    public function setTache10Attribute($value)
    {
        $this->attributes['tache10'] = $value ?? "";
    }

    public function getTache11Attribute($value)
    {
        return $value;
    }

    public function setTache11Attribute($value)
    {
        $this->attributes['tache11'] = $value ?? "";
    }

    public function getTache12Attribute($value)
    {
        return $value;
    }

    public function setTache12Attribute($value)
    {
        $this->attributes['tache12'] = $value ?? "";
    }

    public function getTache13Attribute($value)
    {
        return $value;
    }

    public function setTache13Attribute($value)
    {
        $this->attributes['tache13'] = $value ?? "";
    }

    public function getTache14Attribute($value)
    {
        return $value;
    }

    public function setTache14Attribute($value)
    {
        $this->attributes['tache14'] = $value ?? "";
    }

    public function getTache15Attribute($value)
    {
        return $value;
    }

    public function setTache15Attribute($value)
    {
        $this->attributes['tache15'] = $value ?? "";
    }

    public function getTache16Attribute($value)
    {
        return $value;
    }

    public function setTache16Attribute($value)
    {
        $this->attributes['tache16'] = $value ?? "";
    }

    public function getTache17Attribute($value)
    {
        return $value;
    }

    public function setTache17Attribute($value)
    {
        $this->attributes['tache17'] = $value ?? "";
    }

    public function getTache18Attribute($value)
    {
        return $value;
    }

    public function setTache18Attribute($value)
    {
        $this->attributes['tache18'] = $value ?? "";
    }

    public function getTache19Attribute($value)
    {
        return $value;
    }

    public function setTache19Attribute($value)
    {
        $this->attributes['tache19'] = $value ?? "";
    }

    public function getTache20Attribute($value)
    {
        return $value;
    }

    public function setTache20Attribute($value)
    {
        $this->attributes['tache20'] = $value ?? "";
    }

    public function getTache21Attribute($value)
    {
        return $value;
    }

    public function setTache21Attribute($value)
    {
        $this->attributes['tache21'] = $value ?? "";
    }

    public function getTache22Attribute($value)
    {
        return $value;
    }

    public function setTache22Attribute($value)
    {
        $this->attributes['tache22'] = $value ?? "";
    }

    public function getTache23Attribute($value)
    {
        return $value;
    }

    public function setTache23Attribute($value)
    {
        $this->attributes['tache23'] = $value ?? "";
    }

    public function getTache24Attribute($value)
    {
        return $value;
    }

    public function setTache24Attribute($value)
    {
        $this->attributes['tache24'] = $value ?? "";
    }

    public function getTache25Attribute($value)
    {
        return $value;
    }

    public function setTache25Attribute($value)
    {
        $this->attributes['tache25'] = $value ?? "";
    }

    public function getTache26Attribute($value)
    {
        return $value;
    }

    public function setTache26Attribute($value)
    {
        $this->attributes['tache26'] = $value ?? "";
    }

    public function getTache27Attribute($value)
    {
        return $value;
    }

    public function setTache27Attribute($value)
    {
        $this->attributes['tache27'] = $value ?? "";
    }

    public function getTache28Attribute($value)
    {
        return $value;
    }

    public function setTache28Attribute($value)
    {
        $this->attributes['tache28'] = $value ?? "";
    }

    public function getTache29Attribute($value)
    {
        return $value;
    }

    public function setTache29Attribute($value)
    {
        $this->attributes['tache29'] = $value ?? "";
    }

    public function getTache30Attribute($value)
    {
        return $value;
    }

    public function setTache30Attribute($value)
    {
        $this->attributes['tache30'] = $value ?? "";
    }

    public function getTache31Attribute($value)
    {
        return $value;
    }

    public function setTache31Attribute($value)
    {
        $this->attributes['tache31'] = $value ?? "";
    }

    public function getListesappelIdAttribute($value)
    {
        return $value;
    }

    public function setListesappelIdAttribute($value)
    {
        $this->attributes['listesappel_id'] = $value ?? "";
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

