<?php

namespace App\Models\base;

use App\Models\base\ModelsModel;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use URL;


class CrudsModel extends Model
{


    use SoftDeletes;


    use SchemalessAttributesTrait;
    use SoftDeletes;

    protected $connection = 'mysql_microservices';


    /**
     * The primary key associated with the table.
     *
     * @var  string
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'models',
        'model_id',
        'users',
        'actions',
        'data_first',
        'data_end',
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

    ];
    protected $appends = ['DT_RowId'];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'cruds';
    }

    public function model()
    {
        return $this->belongsTo(ModelsModel::class, 'model_id', 'id');
    }

    public function getCreateursCrudsAttribute($value)
    {
        $response = "Systeme";
        $crud = CrudsModel::where([
            'models' => "\App\Models\base\CrudsModel",
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

    public function getModelsRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['models']) ? $this->attributes['models'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getModelsAttribute($value)
    {
        return $value;
    }

    public function setModelsAttribute($value)
    {
        $this->attributes['models'] = $value ?? "";
    }

    public function getModelIdRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['model_id']) ? $this->attributes['model_id'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getModelIdAttribute($value)
    {
        return $value;
    }

    public function setModelIdAttribute($value)
    {
        $this->attributes['model_id'] = $value ?? "";
    }

    public function getUsersRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['users']) ? $this->attributes['users'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getUsersAttribute($value)
    {
        return $value;
    }

    public function setUsersAttribute($value)
    {
        $this->attributes['users'] = $value ?? "";
    }

    public function getActionsRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['actions']) ? $this->attributes['actions'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getActionsAttribute($value)
    {
        return $value;
    }

    public function setActionsAttribute($value)
    {
        $this->attributes['actions'] = $value ?? "";
    }

    public function getDataFirstRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['data_first']) ? $this->attributes['data_first'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getDataFirstAttribute($value)
    {
        return $value;
    }

    public function setDataFirstAttribute($value)
    {
        $this->attributes['data_first'] = $value ?? "";
    }

    public function getDataEndRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['data_end']) ? $this->attributes['data_end'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getDataEndAttribute($value)
    {
        return $value;
    }

    public function setDataEndAttribute($value)
    {
        $this->attributes['data_end'] = $value ?? "";
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


        return trim($select);


    }

    public function getPipelinesAvfAttribute($value)
    {

        return view('/content/base/pipelines/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();


    }

    public function getSignedShowUrlAttribute($value)
    {
        return URL::signedRoute('Cruds_web_index_one',
            [
                'Cruds' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false,
                'impression' => false
            ]);
    }

    public function getSignedImpressionUrlAttribute($value)
    {
        return URL::signedRoute('Cruds_web_index_impression',
            [
                'Cruds' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false
            ]);
    }

    public function getSignedEditUrlAttribute($value)
    {
        return URL::signedRoute('Cruds_web_update',
            ['Cruds' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getSignedDeleteUrlAttribute($value)
    {
        return URL::signedRoute('Cruds_web_update',
            ['Cruds' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getCardRenderAttribute($value)
    {
        return view('/content/base/Cruds/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
    }

    public function getCardRenderMiniAttribute($value)
    {
        return view('/content/base/Cruds/cardrendermini', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
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
}

