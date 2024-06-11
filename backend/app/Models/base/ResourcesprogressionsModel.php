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


class ResourcesprogressionsModel extends Model
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
        'resourcespipeline_id',
        'validateurs',
        'etats',
        'steps',
        'messages',
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
        'SignedEditUrl', 'SignedDeleteUrl', 'SignedShowUrl',


        'ResourcespipelineIdRender',


        'ValidateursRender',


        'EtatsRender',


        'StepsRender',


        'MessagesRender',


    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'resourcesprogressions';
    }

    public function resourcespipeline()
    {
        return $this->belongsTo(ResourcespipelinesModel::class, 'resourcespipeline_id', 'id');
    }

    public function Myresource()
    {
        return $this->morphMany(AllresourcesModel::class, 'resource');
    }

    public function getResourcespipelineIdRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['resourcespipeline_id']) ? $this->attributes['resourcespipeline_id'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        $donnees = ResourcespipelinesModel::all()
            ->filter(function ($data) use ($value) {
                return Gate::inspect('view', $data)->allowed() && in_array($data->selectvalue, $value);
            })
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

    public function getResourcespipelineIdAttribute($value)
    {
        return explode(',', $value);
    }

    public function setResourcespipelineIdAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['resourcespipeline_id'] = is_array($value) ? implode(',', $value) : $value;
        } else {
            $this->attributes['resourcespipeline_id'] = 0;
        }

    }

    public function getValidateursRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['validateurs']) ? $this->attributes['validateurs'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        $donnees = UsersModel::all()
            ->filter(function ($data) use ($value) {
                return Gate::inspect('view', $data)->allowed() && in_array($data->selectvalue, $value);
            })
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

    public function getValidateursAttribute($value)
    {
        return explode(',', $value);
    }

    public function setValidateursAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['validateurs'] = is_array($value) ? implode(',', $value) : $value;
        } else {
            $this->attributes['validateurs'] = 0;
        }

    }

    public function getEtatsRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['etats']) ? $this->attributes['etats'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getEtatsAttribute($value)
    {
        return $value;
    }

    public function setEtatsAttribute($value)
    {
        $this->attributes['etats'] = $value ?? "";
    }

    public function getStepsRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['steps']) ? $this->attributes['steps'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getStepsAttribute($value)
    {
        return $value;
    }

    public function setStepsAttribute($value)
    {
        $this->attributes['steps'] = $value ?? "";
    }

    public function getMessagesRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['messages']) ? $this->attributes['messages'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getMessagesAttribute($value)
    {
        return $value;
    }

    public function setMessagesAttribute($value)
    {
        $this->attributes['messages'] = $value ?? "";
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


        $select .= " " . $this->id;


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";


        return trim($select);


    }

    public function getSignedShowUrlAttribute($value)
    {
        return URL::signedRoute('Resourcesprogressions_web_index_one',
            [
                'Resourcesprogressions' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false
            ]);
    }

    public function getSignedEditUrlAttribute($value)
    {
        return URL::signedRoute('Resourcesprogressions_web_update',
            ['Resourcesprogressions' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getSignedDeleteUrlAttribute($value)
    {
        return URL::signedRoute('Resourcesprogressions_web_update',
            ['Resourcesprogressions' => (is_array($this->id) ? $this->id[0] : $this->id)]);
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

    public function getExtrasAttribute($value)
    {
        return $this->extra_attributes->extras ?? [];
    }

    public function setExtrasAttribute($value)
    {
        $this->extra_attributes->extras = $value ?? [];
    }

    public function getBannieresAttribute($value)
    {
        return $this->extra_attributes->bannieres ?? [];
    }

    public function getBannieresDataAttribute($value)
    {
        return FilesModel::find($this->bannieres);
    }

    public function setBannieresAttribute($value)
    {
        return $this->extra_attributes->bannieres = $value ?? [];
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

