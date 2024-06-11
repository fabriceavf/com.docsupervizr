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


use App\Models\Programme;


use App\Models\User;


class Pointage extends Model
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
        'pointeuse',
        'lieu',
        'debut_prevu',
        'fin_prevu',
        'faction_horaire',
        'debut_reel',
        'debut_realise',
        'fin_realise',
        'volume_realise',
        'emp_code',
        'motif',
        'volume_prevu',
        'actif',
        'est_valide',
        'horaire_id',
        'programme_id',
        'tolerance',
        'est_attendu',
        'etats',
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


        'horaire',


        'programme',


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
        $this->table = 'pointages';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\PointageObservers') &&
                method_exists('\App\Observers\PointageObservers', 'creating')
            ) {

                try {
                    \App\Observers\PointageObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\PointageObservers') &&
                method_exists('\App\Observers\PointageObservers', 'created')
            ) {

                try {
                    \App\Observers\PointageObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\PointageObservers') &&
                method_exists('\App\Observers\PointageObservers', 'updating')
            ) {

                try {
                    \App\Observers\PointageObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\PointageObservers') &&
                method_exists('\App\Observers\PointageObservers', 'updated')
            ) {

                try {
                    \App\Observers\PointageObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\PointageObservers') &&
                method_exists('\App\Observers\PointageObservers', 'deleting')
            ) {

                try {
                    \App\Observers\PointageObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\PointageObservers') &&
                method_exists('\App\Observers\PointageObservers', 'deleted')
            ) {

                try {
                    \App\Observers\PointageObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function horaire()
    {
        return $this->belongsTo(Horaire::class, 'horaire_id', 'id');
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'programme_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getPointeuseAttribute($value)
    {
        return $value;
    }

    public function setPointeuseAttribute($value)
    {
        $this->attributes['pointeuse'] = $value ?? "";
    }

    public function getLieuAttribute($value)
    {
        return $value;
    }

    public function setLieuAttribute($value)
    {
        $this->attributes['lieu'] = $value ?? "";
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

    public function getFactionHoraireAttribute($value)
    {
        return $value;
    }

    public function setFactionHoraireAttribute($value)
    {
        $this->attributes['faction_horaire'] = $value ?? "";
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

    public function getVolumeRealiseAttribute($value)
    {
        return $value;
    }

    public function setVolumeRealiseAttribute($value)
    {
        $this->attributes['volume_realise'] = $value ?? "";
    }

    public function getEmpCodeAttribute($value)
    {
        return $value;
    }

    public function setEmpCodeAttribute($value)
    {
        $this->attributes['emp_code'] = $value ?? "";
    }

    public function getMotifAttribute($value)
    {
        return $value;
    }

    public function setMotifAttribute($value)
    {
        $this->attributes['motif'] = $value ?? "";
    }

    public function getVolumePrevuAttribute($value)
    {
        return $value;
    }

    public function setVolumePrevuAttribute($value)
    {
        $this->attributes['volume_prevu'] = $value ?? "";
    }

    public function getActifAttribute($value)
    {
        return $value;
    }

    public function setActifAttribute($value)
    {
        $this->attributes['actif'] = $value ?? "";
    }

    public function getEstValideAttribute($value)
    {
        return $value;
    }

    public function setEstValideAttribute($value)
    {
        $this->attributes['est_valide'] = $value ?? "";
    }

    public function getHoraireIdAttribute($value)
    {
        return $value;
    }

    public function setHoraireIdAttribute($value)
    {
        $this->attributes['horaire_id'] = $value ?? "";
    }

    public function getProgrammeIdAttribute($value)
    {
        return $value;
    }

    public function setProgrammeIdAttribute($value)
    {
        $this->attributes['programme_id'] = $value ?? "";
    }

    public function getToleranceAttribute($value)
    {
        return $value;
    }

    public function setToleranceAttribute($value)
    {
        $this->attributes['tolerance'] = $value ?? "";
    }

    public function getEstAttenduAttribute($value)
    {
        return $value;
    }

    public function setEstAttenduAttribute($value)
    {
        $this->attributes['est_attendu'] = $value ?? "";
    }

    public function getEtatsAttribute($value)
    {
        return $value;
    }

    public function setEtatsAttribute($value)
    {
        $this->attributes['etats'] = $value ?? "";
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

