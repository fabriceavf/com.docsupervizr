<?php

namespace App\Models\base;

use App\Models\prod\UsersModel;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use URL;


class FilesModel extends Model
{


    use SoftDeletes;


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
        'old_name',
        'new_name',
        'descriptions',
        'extensions',
        'size',
        'path',
        'web_path',
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
    protected $appends = ['DT_RowId', 'CanEditPerms', 'CanDeletePerms', 'Selectvalue', 'Selectlabel',


        'OldNameRender',
        'CardRender',


        'NewNameRender',


        'DescriptionsRender',


        'ExtensionsRender',


        'SizeRender',


        'PathRender',


        'WebPathRender',


        'StatutRender',


    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'files';
    }

    public function getCreateursCrudsAttribute($value)
    {
        $response = "Systeme";
        $crud = \App\Models\prod\CrudsModel::where([
            'models' => "\App\Models\prod\FilesModel",
            'model_id' => (is_array($this->id) ? $this->id[0] : $this->id),
            'actions' => 'create',
        ])->get();
        if (count($crud->toArray()) == 1) {
            $users = UsersModel::find($crud->first()->users);
            if (!empty($users->selectlabel)) {
                $response = $users->selectlabel;
            }

        }
        return $response;
    }

    public function Myresource()
    {
        return $this->morphMany(AllresourcesModel::class, 'resource');
    }

    public function getOldNameRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['old_name']) ? $this->attributes['old_name'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getOldNameAttribute($value)
    {
        return $value;
    }

    public function setOldNameAttribute($value)
    {
        $this->attributes['old_name'] = $value ?? "";
    }

    public function getNewNameRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['new_name']) ? $this->attributes['new_name'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getNewNameAttribute($value)
    {
        return $value;
    }

    public function setNewNameAttribute($value)
    {
        $this->attributes['new_name'] = $value ?? "";
    }

    public function getDescriptionsRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['descriptions']) ? $this->attributes['descriptions'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getDescriptionsAttribute($value)
    {
        return $value;
    }

    public function setDescriptionsAttribute($value)
    {
        $this->attributes['descriptions'] = $value ?? "";
    }

    public function getExtensionsRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['extensions']) ? $this->attributes['extensions'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getExtensionsAttribute($value)
    {
        return $value;
    }

    public function setExtensionsAttribute($value)
    {
        $this->attributes['extensions'] = $value ?? "";
    }

    public function getSizeRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['size']) ? $this->attributes['size'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getSizeAttribute($value)
    {
        return $value;
    }

    public function setSizeAttribute($value)
    {
        $this->attributes['size'] = $value ?? "";
    }

    public function getPathRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['path']) ? $this->attributes['path'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getPathAttribute($value)
    {
        return $value;
    }

    public function setPathAttribute($value)
    {
        $this->attributes['path'] = $value ?? "";
    }

    public function getWebPathRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['web_path']) ? $this->attributes['web_path'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getWebPathAttribute($value)
    {
        return $value;
    }

    public function setWebPathAttribute($value)
    {
        $this->attributes['web_path'] = $value ?? "";
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
        $this->attributes['user_id'] = $value ?? Auth::id();
    }

    public function getDTRowIdAttribute()
    {
        return 'row_' . (is_array($this->id) ? $this->id[0] : $this->id);
    }

    public function getSelectvalueAttribute()
    {
        $select = "";


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
        return URL::signedRoute('Files_web_index_one',
            [
                'Files' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false,
                'impression' => false
            ]);
    }

    public function getSignedImpressionUrlAttribute($value)
    {
        return URL::signedRoute('Files_web_index_impression',
            [
                'Files' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false
            ]);
    }

    public function getSignedEditUrlAttribute($value)
    {
        return URL::signedRoute('Files_web_update',
            ['Files' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getSignedDeleteUrlAttribute($value)
    {
        return URL::signedRoute('Files_web_update',
            ['Files' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getCardRenderAttribute($value)
    {
        return view('/content/base/Files/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
    }

    public function getCardRenderMiniAttribute($value)
    {
        return view('/content/base/Files/cardrendermini', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
    }

    public function getCardRenderSelectAttribute($value)
    {
        return view('/content/base/Files/cardrenderselect', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
    }

    public function getCardRenderComponentAttribute($value)
    {
        return view('/content/base/Files/cardrendercomponent', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
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

