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







class Suivitache extends Model
{

    use SchemalessAttributesTrait;
    use SoftDeletes;









    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\SuivitacheObservers') &&
                method_exists('\App\Observers\SuivitacheObservers', 'creating')
            ) {

                try {
                    \App\Observers\SuivitacheObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\SuivitacheObservers') &&
                method_exists('\App\Observers\SuivitacheObservers', 'created')
            ) {

                try {
                    \App\Observers\SuivitacheObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\SuivitacheObservers') &&
                method_exists('\App\Observers\SuivitacheObservers', 'updating')
            ) {

                try {
                    \App\Observers\SuivitacheObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\SuivitacheObservers') &&
                method_exists('\App\Observers\SuivitacheObservers', 'updated')
            ) {

                try {
                    \App\Observers\SuivitacheObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\SuivitacheObservers') &&
                method_exists('\App\Observers\SuivitacheObservers', 'deleting')
            ) {

                try {
                    \App\Observers\SuivitacheObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\SuivitacheObservers') &&
                method_exists('\App\Observers\SuivitacheObservers', 'deleted')
            ) {

                try {
                    \App\Observers\SuivitacheObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = 'id';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'Suivitaches';
    }
    protected $fillable = [
        'id',
        'priorite',
        'libelle',
        'date_demande',
        'deadline',
        'date_fin',
        'faisabilite',
        'commentaire',
        'projet_id',
        'client_id',
        'user_id',
        'creat_by',
        'extra_attributes',
        'created_at',
        'updated_at',
        'deleted_at',
        'identifiants_sadge',

    ];


    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',

























    ];





    protected $with = [















    ];









    public function user()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }







    public function clients()
    {
        return $this->hasMany(Client::class, 'client_id', 'id');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class, 'projet_id', 'id');
    }



















    public function getPrioriteAttribute($value)
    {
        return $value;
    }
    public function setPrioriteAttribute($value)
    {
        $this->attributes['priorite'] = $value ?? "";
    }


    public function getDateDemandeAttribute($value)
    {
        return $value;
    }
    public function setDateDemandeAttribute($value)
    {
        $this->attributes['date_demande'] = $value ?? "";
    }


    public function getDeadlineAttribute($value)
    {
        return $value;
    }
    public function setDeadlineAttribute($value)
    {
        $this->attributes['deadline'] = $value ?? "";
    }




    public function getDateFinAttribute($value)
    {
        return $value;
    }
    public function setDateFinAttribute($value)
    {
        $this->attributes['date_fin'] = $value ?? "";
    }




    public function getFaisabiliteAttribute($value)
    {
        return $value;
    }
    public function setFaisabiliteAttribute($value)
    {
        $this->attributes['faisabilite'] = $value ?? "";
    }




    public function getCommentaireAttribute($value)
    {
        return $value;
    }
    public function setCommentaireAttribute($value)
    {
        $this->attributes['commentaire'] = $value ?? "";
    }



    public function getProjetIdAttribute($value)
    {
        return $value;
    }
    public function setProjetIdAttribute($value)
    {
        $this->attributes['projet_id'] = $value ?? "";
    }


    public function getClientIdAttribute($value)
    {
        return $value;
    }
    public function setClientIdAttribute($value)
    {
        $this->attributes['client_id'] = $value ?? "";
    }


    public function getUserIdAttribute($value)
    {
        return $value;
    }
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value ?? "";
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }
    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }













    public function getCreatByAttribute($value)
    {
        return $value;
    }
    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }



















    public function getIdentifiantsSadgeAttribute($value)
    {
        return $value;
    }
    public function setIdentifiantsSadgeAttribute($value)
    {
        $this->attributes['identifiants_sadge'] = $value ?? "";
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


    protected $appends = [
        'Selectvalue',
        'Selectlabel'
    ];

    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }

    public function scopeWithOtherExtraAttributes(): Builder
    {
        return $this->other_extra_attributes->modelScope();
    }



}

