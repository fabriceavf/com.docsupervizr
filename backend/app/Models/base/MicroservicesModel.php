<?php

namespace App\Models\base;

use App\Models\prod\UsersModel;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use URL;


class MicroservicesModel extends Model
{


    use SoftDeletes;


    use SchemalessAttributesTrait;
    use SoftDeletes;

    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_microservices';

    /**
     * The primary key associated with the table.
     *
     * @var  string
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'table',
        'action',
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
    protected $appends = ['DT_RowId', 'Selectvalue', 'Selectlabel', 'ForMe',


    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'microservices';
    }

    public function getCreateursCrudsAttribute($value)
    {
        $response = "Systeme";
        $crud = \App\Models\prod\CrudsModel::where([
            'models' => "\App\Models\prod\MicroservicesModel",
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

    public function getTableRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['table']) ? $this->attributes['table'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getTableAttribute($value)
    {
        return $value;
    }

    public function setTableAttribute($value)
    {
        $this->attributes['table'] = $value ?? "";
    }

    public function getActionRenderAttribute($value)
    {
        $old = $value;

        $value_base = !empty($this->attributes['action']) ? $this->attributes['action'] : "";

        $value = explode(',', $value_base);
        $resultat = "########";


        return $resultat;
    }

    public function getActionAttribute($value)
    {
        return $value;
    }

    public function setActionAttribute($value)
    {
        $this->attributes['action'] = $value ?? "";
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
        return URL::signedRoute('Microservices_web_index_one',
            [
                'Microservices' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false,
                'impression' => false
            ]);
    }

    public function getSignedImpressionUrlAttribute($value)
    {
        return URL::signedRoute('Microservices_web_index_impression',
            [
                'Microservices' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false
            ]);
    }

    public function getSignedEditUrlAttribute($value)
    {
        return URL::signedRoute('Microservices_web_update',
            ['Microservices' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getSignedDeleteUrlAttribute($value)
    {
        return URL::signedRoute('Microservices_web_update',
            ['Microservices' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getCardRenderAttribute($value)
    {
        return view('/content/prod/Microservices/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
    }

    public function getCardRenderMiniAttribute($value)
    {
        return view('/content/prod/Microservices/cardrendermini', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
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

