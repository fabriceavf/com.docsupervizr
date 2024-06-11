<?php

namespace App\Models;

use App\Observers\ActiviteObservers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Throwable;


class Activite1 extends Model
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
        'libelle',
        'description',
        'created_at',
        'updated_at',
        'extra_attributes',
        'deleted_at',
        'etats_actuel',
        'description_actual',
        'duree',
        'parent',
        'user_id',
        'has_child',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'user',


    ];
    protected $appends = [
        'Selectvalue', 'Selectlabel', 'ParentElements',
        "AllEtats", "CanUpdate", 'IsCreateByMe', 'IsWorkForMe', 'Status', 'Createur'
//        ,'IsValider'
//        ,'IsAccepter'
//        ,'IsRefuser'
//        ,'IsBloquer'
//        ,'IsTerminer'
    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'activites';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'creating')
            ) {

                try {
                    ActiviteObservers::creating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'created')
            ) {

                ActiviteObservers::created($model);
                try {
                    ActiviteObservers::created($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'updating')
            ) {

                try {
                    ActiviteObservers::updating($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'updated')
            ) {

                ActiviteObservers::updated($model);

                try {

                } catch (Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'deleting')
            ) {

                try {
                    ActiviteObservers::deleting($model);

                } catch (Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ActiviteObservers') &&
                method_exists('\App\Observers\ActiviteObservers', 'deleted')
            ) {

                try {
                    ActiviteObservers::deleted($model);

                } catch (Throwable $e) {

                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function objectifs()
    {
        return $this->hasMany(Objectif::class, 'activite_id', 'id');
    }

    public function ressources()
    {
        return $this->hasMany(Ressource::class, 'activite_id', 'id');
    }

    public function works()
    {
        return $this->hasMany(Work::class, 'activite_id', 'id');
    }

    public function getStatusAttribute()
    {
        $allParentsId = collect($this->ParentElements)->pluck('id')->toArray();
        $allParentValider = DB::table('activites')
            ->whereIn('parent', $allParentsId)
            ->where('created_at', '>=', $this->created_at)
            ->where('type', 'VALIDER')
            ->get()->toArray();
        $allDirectParent = DB::table('activites')
            ->where('parent', $this->id)
            ->where('type', '<>', 'normal')
            ->get()
            ->toArray();
        $allParent = array_merge($allParentValider, $allDirectParent);
        $allParent = collect($allParent)->sortBy('created_at')->unique('type')->values()->map(function ($data) {
            $data->user = User::find($data->user_id);
            return $data;
        })->toArray();

        return $allParent;
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getCanUpdateAttribute($value)
    {
        return $this->creat_by == Auth::id();
    }

    public function getIsCreateByMeAttribute($value)
    {
//        si je suis le createur et que cest nest pas active ou si je ne suis pas le createur et que cest pour moi sans et cest active
        return $this->creat_by == Auth::id();
    }

    public function getIsWorkForMeAttribute()
    {
        return $this->user_id == Auth::id();
    }

    public function getEtatsActuelAttribute($value)
    {
        return $value;
    }

    public function setEtatsActuelAttribute($value)
    {
        $this->attributes['etats_actuel'] = $value ?? "";
    }

    public function getDescriptionActuelAttribute($value)
    {
        return $value;
    }

    public function setDescriptionActuelAttribute($value)
    {
        $this->attributes['description_actuel'] = $value ?? "";
    }

    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value ?? "";
    }

    public function getCreateurAttribute($value)
    {
        return User::find($this->creat_by);
    }

    public function getDureeAttribute($value)
    {
        return $value;
    }

    public function setDureeAttribute($value)
    {
        $this->attributes['duree'] = $value ?? "";
    }

    public function getParentAttribute($value)
    {
        return $value;
    }

    public function setParentAttribute($value)
    {
        $this->attributes['parent'] = $value ?? "";
    }

    public function getAllEtatsAttribute($value)
    {

        $actualEtats = collect($this->Status)->pluck('type')->toArray();
        return $actualEtats;
    }

    public function getIsRefuserAttribute($value)
    {

        return DB::table('activites')->where('type', 'REFUSER')->where('parent', $this->id)->count() == 1;
    }

    public function getIsBloquerAttribute($value)
    {

        return DB::table('activites')->where('type', 'BLOQUER')->where('parent', $this->id)->count() == 1;
    }

    public function getIsValiderAttribute($value)
    {

        return DB::table('activites')->where('type', 'VALIDER')->where('parent', $this->id)->count() == 1;
    }

    public function getIsTerminerAttribute($value)
    {
        return DB::table('activites')->where('type', 'TERMINER')->where('parent', $this->id)->count() == 1;
    }

    public function getHasChildAttribute($value)
    {
        return DB::table('activites')->where('parent', $this->id)->where('type', 'normal')->count() > 0;
    }

    public function getParentElementsAttribute($value)
    {
        $elements = [];
        $parent = 0;
        try {
            $parent = $this->parent;
            $parent = intval($parent);
        } catch (Throwable $e) {

        }
        while ($parent != 0) {
            $parentElement = DB::table('activites')->find($parent);
            $_parent = [
                'id' => $parentElement->id,
                'libelle' => $parentElement->libelle,
                'description' => $parentElement->description,
                'etats' => $parentElement->etats_actuel,
            ];
            array_unshift($elements, $_parent);
            $parent = intval($parentElement->parent);

        }


        return $elements;
    }

    public function setHasChildAttribute($value)
    {
        $this->attributes['has_child'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        $select = "";


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";
        $select .= $this->libelle;


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

