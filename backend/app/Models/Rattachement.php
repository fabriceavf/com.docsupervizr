<?php

namespace App\Models;

use App\Observers\RattachementObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Rattachement extends Model
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
        'postes id',
        'CLIENTS',
        'SITES',
        'Jour',
        'Nuit',
        'Nom',
        'Prenoms',
        'Matricule',
        'Numero Badge',
        ' Jour Repos',
        'Type d&#039;agent',
        'Vacation',
        'Superviseur  de zone',
        'id',
        'client_id',
        'site_id',
        'poste_id',
        'extra_attributes',
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


        'client',


        'poste',


        'site',


    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'rattachements';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\RattachementObservers') &&
                method_exists('\App\Observers\RattachementObservers', 'creating')
            ) {

                try {
                    RattachementObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\RattachementObservers') &&
                method_exists('\App\Observers\RattachementObservers', 'created')
            ) {

                try {
                    RattachementObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\RattachementObservers') &&
                method_exists('\App\Observers\RattachementObservers', 'updating')
            ) {

                try {
                    RattachementObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\RattachementObservers') &&
                method_exists('\App\Observers\RattachementObservers', 'updated')
            ) {

                try {
                    RattachementObservers::updated($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\RattachementObservers') &&
                method_exists('\App\Observers\RattachementObservers', 'deleting')
            ) {

                try {
                    RattachementObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\RattachementObservers') &&
                method_exists('\App\Observers\RattachementObservers', 'deleted')
            ) {

                try {
                    RattachementObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }


    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste_id', 'id');
    }


    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }


    public function getPostesIdAttribute($value)
    {
        return $value;
    }

    public function setPostesIdAttribute($value)
    {
        $this->attributes['postes id'] = $value ?? "";
    }


    public function getCLIENTSAttribute($value)
    {
        return $value;
    }

    public function setCLIENTSAttribute($value)
    {
        $this->attributes['CLIENTS'] = $value ?? "";
    }


    public function getSITESAttribute($value)
    {
        return $value;
    }

    public function setSITESAttribute($value)
    {
        $this->attributes['SITES'] = $value ?? "";
    }


    public function getJourAttribute($value)
    {
        return $value;
    }

    public function setJourAttribute($value)
    {
        $this->attributes['Jour'] = $value ?? "";
    }


    public function getNuitAttribute($value)
    {
        return $value;
    }

    public function setNuitAttribute($value)
    {
        $this->attributes['Nuit'] = $value ?? "";
    }


    public function getNomAttribute($value)
    {
        return $value;
    }

    public function setNomAttribute($value)
    {
        $this->attributes['Nom'] = $value ?? "";
    }


    public function getPrenomsAttribute($value)
    {
        return $value;
    }

    public function setPrenomsAttribute($value)
    {
        $this->attributes['Prenoms'] = $value ?? "";
    }


    public function getMatriculeAttribute($value)
    {
        return $value;
    }

    public function setMatriculeAttribute($value)
    {
        $this->attributes['Matricule'] = $value ?? "";
    }


    public function getNumeroBadgeAttribute($value)
    {
        return $value;
    }

    public function setNumeroBadgeAttribute($value)
    {
        $this->attributes['Numero Badge'] = $value ?? "";
    }


    public function getJourReposAttribute($value)
    {
        return $value;
    }

    public function setJourReposAttribute($value)
    {
        $this->attributes[' Jour Repos'] = $value ?? "";
    }


    public function getTypeD&#039;agentAttribute($value)
            {
            return $value;
            }

public
function setTypeD&#039;agentAttribute($value)
            {
                $this->attributes['Type d&#039;agent'] = $value ?? "";
            }













            public function getVacationAttribute($value)
{
    return $value;
}
            public function setVacationAttribute($value)
{
    $this->attributes['Vacation'] = $value ?? "";
}













            public function getSuperviseurDeZoneAttribute($value)
{
    return $value;
}
            public function setSuperviseurDeZoneAttribute($value)
{
    $this->attributes['Superviseur  de zone'] = $value ?? "";
}
















            public function getClientIdAttribute($value)
{
    return $value;
}
            public function setClientIdAttribute($value)
{
    $this->attributes['client_id'] = $value ?? "";
}













            public function getSiteIdAttribute($value)
{
    return $value;
}
            public function setSiteIdAttribute($value)
{
    $this->attributes['site_id'] = $value ?? "";
}













            public function getPosteIdAttribute($value)
{
    return $value;
}
            public function setPosteIdAttribute($value)
{
    $this->attributes['poste_id'] = $value ?? "";
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


    return trim($select);

}
public function getSelectlabelAttribute()
{
    $select = "";


    return trim($select);


}


protected $appends = [
    'Selectvalue', 'Selectlabel'
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

