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


use App\Models\Menu;


class Entreprise extends Model
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
        'nom',
        'menu',
        'host',
        'extra_attributes',
        'created_at',
        'updated_at',
        'deleted_at',
        'icon',
        'favicon',
        'status',
        'identifiants_sadge',
        'creat_by',
        'db_host',
        'db_user',
        'db_pass',
        'badge_avant',
        'badge_arriere',
        'modules',
        'filemodules',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


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
        $this->table = 'entreprises';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\EntrepriseObservers') &&
                method_exists('\App\Observers\EntrepriseObservers', 'creating')
            ) {

                try {
                    \App\Observers\EntrepriseObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\EntrepriseObservers') &&
                method_exists('\App\Observers\EntrepriseObservers', 'created')
            ) {

                try {
                    \App\Observers\EntrepriseObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\EntrepriseObservers') &&
                method_exists('\App\Observers\EntrepriseObservers', 'updating')
            ) {

                try {
                    \App\Observers\EntrepriseObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\EntrepriseObservers') &&
                method_exists('\App\Observers\EntrepriseObservers', 'updated')
            ) {

                try {
                    \App\Observers\EntrepriseObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\EntrepriseObservers') &&
                method_exists('\App\Observers\EntrepriseObservers', 'deleting')
            ) {

                try {
                    \App\Observers\EntrepriseObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\EntrepriseObservers') &&
                method_exists('\App\Observers\EntrepriseObservers', 'deleted')
            ) {

                try {
                    \App\Observers\EntrepriseObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'entreprise_id', 'id');
    }

    public function getNomAttribute($value)
    {
        return $value;
    }

    public function setNomAttribute($value)
    {
        $this->attributes['nom'] = $value ?? "";
    }

    public function getMenuAttribute($value)
    {
        return $value;
    }

    public function setMenuAttribute($value)
    {
        $this->attributes['menu'] = $value ?? "";
    }

    public function getHostAttribute($value)
    {
        return $value;
    }

    public function setHostAttribute($value)
    {
        $this->attributes['host'] = $value ?? "";
    }

    public function getIconAttribute($value)
    {
        return $value;
    }

    public function setIconAttribute($value)
    {
        $this->attributes['icon'] = $value ?? "";
    }

    public function getFaviconAttribute($value)
    {
        return $value;
    }

    public function setFaviconAttribute($value)
    {
        $this->attributes['favicon'] = $value ?? "";
    }

    public function getStatusAttribute($value)
    {
        return $value;
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value ?? "";
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

    public function getDbHostAttribute($value)
    {
        return $value;
    }

    public function setDbHostAttribute($value)
    {
        $this->attributes['db_host'] = $value ?? "";
    }

    public function getDbUserAttribute($value)
    {
        return $value;
    }

    public function setDbUserAttribute($value)
    {
        $this->attributes['db_user'] = $value ?? "";
    }

    public function getDbPassAttribute($value)
    {
        return $value;
    }

    public function setDbPassAttribute($value)
    {
        $this->attributes['db_pass'] = $value ?? "";
    }

    public function getBadgeAvantAttribute($value)
    {
        return $value;
    }

    public function setBadgeAvantAttribute($value)
    {
        $this->attributes['badge_avant'] = $value ?? "";
    }

    public function getBadgeArriereAttribute($value)
    {
        return $value;
    }

    public function setBadgeArriereAttribute($value)
    {
        $this->attributes['badge_arriere'] = $value ?? "";
    }

    public function getModulesAttribute($value)
    {
        return $value;
    }

    public function setModulesAttribute($value)
    {
        $this->attributes['modules'] = $value ?? "";
    }

    public function getFilemodulesAttribute($value)
    {
        return $value;
    }

    public function setFilemodulesAttribute($value)
    {
        $this->attributes['filemodules'] = $value ?? "";
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

