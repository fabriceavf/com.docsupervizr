<?php

namespace App\Models\base;

use App\Models\prod\UsersModel;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use URL;


class BranchesModel extends Model
{


    use SoftDeletes;
    use QueryCacheable;

    protected static $flushCacheOnUpdate = true;
    protected $cacheFor = 180;


    use SchemalessAttributesTrait;
    use SoftDeletes;

    /**
     * The primary key associated with the table.
     *
     * @var  string
     */

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'parents',
        'family',
        'adn',
        'statut',
        'extra_attributes',
        'deleted_at',
        'created_at',
        'updated_at',
        'createurs',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


    ];
    protected $appends = ['DT_RowId', 'CanEditPerms', 'CanDeletePerms', 'Selectvalue', 'Selectlabel', 'ForMe',
        'SignedEditUrl', 'SignedDeleteUrl', 'SignedShowUrl', 'SignedImpressionUrl', 'CreateursCruds', 'CreateursRender',


        'FamilyRender',


        'AdnRender',


        'StatutRender',


        'CreateursRender',

    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'branches';
    }

    public function getCreateursCrudsAttribute($value)
    {
        $response = "Systeme";
        $crud = \App\Models\prod\CrudsModel::where([
            'models' => "\App\Models\base\BranchesModel",
            'model_id' => (is_array($this->id) ? $this->id[0] : $this->id),
            'actions' => 'create',
        ])->get();
        if (count($crud->toArray()) == 1) {
            $users = \App\Models\crud\UsersModel::find($crud->first()->users);
            if (!empty($users->selectlabel)) {
                $response = $users->selectlabel;
            }

        }
        return $response;
    }

    public function Myresource()
    {
        return $this->morphMany(\App\Models\crud\AllresourcesModel::class, 'resource');
    }

    public function getParentsRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['parents']) ? $this->attributes['parents'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getParentsAttribute($value)
    {
        return $value;
    }

    public function setParentsAttribute($value)
    {
        $this->attributes['parents'] = $value ?? "";
    }

    public function getFamilyRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['family']) ? $this->attributes['family'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getFamilyAttribute($value)
    {
        return $value;
    }

    public function setFamilyAttribute($value)
    {
        $this->attributes['family'] = $value ?? "";
    }

    public function getAdnRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['adn']) ? $this->attributes['adn'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getAdnAttribute($value)
    {
        return $value;
    }

    public function setAdnAttribute($value)
    {
        $this->attributes['adn'] = $value ?? "";
    }

    public function getStatutRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['statut']) ? $this->attributes['statut'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getStatutAttribute($value)
    {
        return !empty($value) ? $value : 0;
    }

    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = $value ?? "";
    }

    public function getCreateursRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['createurs']) ? $this->attributes['createurs'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        $donnees = UsersModel::findMany($value)

            // ->filter(function($data)use($value){ return Gate::inspect('view',$data)->allowed() && in_array($data->selectvalue,$value);  })
            ->map(function ($data) {
                return [
                    "label" => $data->selectlabel,
                    "value" => $data->selectvalue,
                ];
            });
        $donnees = Arr::pluck($donnees, 'label');
        $donnees = implode(' // ', $donnees);

        $resultat = $donnees;


        return $resultat;
    }

    public function getCreateursAttribute($value)
    {
        return explode(',', $value);
    }

    public function setCreateursAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['createurs'] = is_array($value) ? implode(',', $value) : $value;
        } else {
            $this->attributes['createurs'] = 0;
        }

    }

    public function setUserIdAttribute($value)
    {
        $retour = Auth::id();
        if (!empty($value)) {
            $retour = $value;
        }
        if (is_array($value)) {
            $retour = implode(',', $value);
        }
        $this->attributes['user_id'] = $retour;
    }

    public function getDTRowIdAttribute()
    {
        return '' . (is_array($this->id) ? $this->id[0] : $this->id);
    }

    public function getSelectvalueAttribute()
    {
        $select = "";


        $select .= " " . $this->id;


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";


        $select .= "#" . $this->id . " ";


        return trim($select);


    }

    public function getPipelinesAvfAttribute($value)
    {

        return view('/content/base/pipelines/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();


    }

    public function getSignedShowUrlAttribute($value)
    {
        return URL::signedRoute('Branches_web_index_one',
            [
                'Branches' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false,
                'impression' => false
            ]);
    }

    public function getSignedImpressionUrlAttribute($value)
    {
        return URL::signedRoute('Branches_web_index_impression',
            [
                'Branches' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false
            ]);
    }

    public function getSignedEditUrlAttribute($value)
    {
        return URL::signedRoute('Branches_web_update',
            ['Branches' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getSignedDeleteUrlAttribute($value)
    {
        return URL::signedRoute('Branches_web_update',
            ['Branches' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getCardRenderAttribute($value)
    {
        return view('/content/base/Branches/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
    }

    public function getCardRenderMiniAttribute($value)
    {
        return view('/content/base/Branches/cardrendermini', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
    }

    public function getCardRenderSelectAttribute($value)
    {
        return view('/content/base/Branches/cardrenderselect', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
    }

    public function getCardRenderComponentAttribute($value)
    {
        return view('/content/base/Branches/cardrendercomponent', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
    }

    public function getForMeAttribute($value)
    {
        return true;
    }

    public function getFichiersAttribute($value)
    {
        return $this->extra_attributes->fichiers ?? [];
    }

    public function setFichiersAttribute($value)
    {
        $this->extra_attributes->fichiers = $value ?? [];
    }

    public function scopeWithExtraAttributes(): Builder
    {
        return $this->extra_attributes->modelScope();
    }

    public function scopeWithOtherExtraAttributes(): Builder
    {
        return $this->other_extra_attributes->modelScope();
    }


    public function getEtatsAttribute($value)
    {
        return $this->extra_attributes->etats ?? "";
    }

    public function setEtatsAttribute($value)
    {
        $this->extra_attributes->etats = $value ?? "";
    }


    public function getCanEditPermsAttribute()
    {
        return Gate::inspect('update', $this)->allowed();
    }

    public function getCanDeletePermsAttribute()
    {
        return Gate::inspect('delete', $this)->allowed();
    }
}

