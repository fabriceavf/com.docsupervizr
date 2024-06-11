<?php

namespace App\Models;

use App\Observers\UsersbackObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Usersback extends Model
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
        'name',
        'email',
        'email_verified_at',
        'password',
        'matricule',
        'emp_code',
        'nom',
        'prenom',
        'num_badge',
        'date_naissance',
        'num_cnss',
        'num_cnamgs',
        'telephone1',
        'telephone2',
        'nationalite_id',
        'nombre_enfant',
        'photo',
        'actif_id',
        'online_id',
        'date_embauche',
        'sexe_id',
        'type_id',
        'contrat_id',
        'matrimoniale_id',
        'fonction_id',
        'user_id',
        'remember_token',
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


        'actif',


        'contrat',


        'fonction',


        'matrimoniale',


        'nationalite',


        'online',


        'sexe',


        'type',


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
        $this->table = 'usersbacks';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\UsersbackObservers') &&
                method_exists('\App\Observers\UsersbackObservers', 'creating')
            ) {

                try {
                    UsersbackObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\UsersbackObservers') &&
                method_exists('\App\Observers\UsersbackObservers', 'created')
            ) {

                try {
                    UsersbackObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\UsersbackObservers') &&
                method_exists('\App\Observers\UsersbackObservers', 'updating')
            ) {

                try {
                    UsersbackObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\UsersbackObservers') &&
                method_exists('\App\Observers\UsersbackObservers', 'updated')
            ) {

                try {
                    UsersbackObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\UsersbackObservers') &&
                method_exists('\App\Observers\UsersbackObservers', 'deleting')
            ) {

                try {
                    UsersbackObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\UsersbackObservers') &&
                method_exists('\App\Observers\UsersbackObservers', 'deleted')
            ) {

                try {
                    UsersbackObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function actif()
    {
        return $this->belongsTo(Actif::class, 'actif_id', 'id');
    }

    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'contrat_id', 'id');
    }

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

    public function online()
    {
        return $this->belongsTo(Online::class, 'online_id', 'id');
    }

    public function sexe()
    {
        return $this->belongsTo(Sexe::class, 'sexe_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getNameAttribute($value)
    {
        return $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value ?? "";
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

    public function getMatriculeAttribute($value)
    {
        return $value;
    }

    public function setMatriculeAttribute($value)
    {
        $this->attributes['matricule'] = $value ?? "";
    }

    public function getEmpCodeAttribute($value)
    {
        return $value;
    }

    public function setEmpCodeAttribute($value)
    {
        $this->attributes['emp_code'] = $value ?? "";
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

    public function getNationaliteIdAttribute($value)
    {
        return $value;
    }

    public function setNationaliteIdAttribute($value)
    {
        $this->attributes['nationalite_id'] = $value ?? "";
    }

    public function getNombreEnfantAttribute($value)
    {
        return $value;
    }

    public function setNombreEnfantAttribute($value)
    {
        $this->attributes['nombre_enfant'] = $value ?? "";
    }

    public function getPhotoAttribute($value)
    {
        return $value;
    }

    public function setPhotoAttribute($value)
    {
        $this->attributes['photo'] = $value ?? "";
    }

    public function getActifIdAttribute($value)
    {
        return $value;
    }

    public function setActifIdAttribute($value)
    {
        $this->attributes['actif_id'] = $value ?? "";
    }

    public function getOnlineIdAttribute($value)
    {
        return $value;
    }

    public function setOnlineIdAttribute($value)
    {
        $this->attributes['online_id'] = $value ?? "";
    }

    public function getDateEmbaucheAttribute($value)
    {
        return $value;
    }

    public function setDateEmbaucheAttribute($value)
    {
        $this->attributes['date_embauche'] = $value ?? "";
    }

    public function getSexeIdAttribute($value)
    {
        return $value;
    }

    public function setSexeIdAttribute($value)
    {
        $this->attributes['sexe_id'] = $value ?? "";
    }

    public function getTypeIdAttribute($value)
    {
        return $value;
    }

    public function setTypeIdAttribute($value)
    {
        $this->attributes['type_id'] = $value ?? "";
    }

    public function getContratIdAttribute($value)
    {
        return $value;
    }

    public function setContratIdAttribute($value)
    {
        $this->attributes['contrat_id'] = $value ?? "";
    }

    public function getMatrimonialeIdAttribute($value)
    {
        return $value;
    }

    public function setMatrimonialeIdAttribute($value)
    {
        $this->attributes['matrimoniale_id'] = $value ?? "";
    }

    public function getFonctionIdAttribute($value)
    {
        return $value;
    }

    public function setFonctionIdAttribute($value)
    {
        $this->attributes['fonction_id'] = $value ?? "";
    }

    public function getRememberTokenAttribute($value)
    {
        return $value;
    }

    public function setRememberTokenAttribute($value)
    {
        $this->attributes['remember_token'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        $select = "";


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

