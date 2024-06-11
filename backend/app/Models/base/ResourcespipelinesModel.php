<?php

namespace App\Models\base;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use URL;


class ResourcespipelinesModel extends Model
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
        'allresource_id',
        'pipelines',
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
    protected $appends = ['DT_RowId', 'Selectvalue', 'Selectlabel', 'CardRender', 'ForMe',
        'SignedEditUrl', 'SignedDeleteUrl', 'SignedShowUrl',


        'AllresourceIdRender',


        'PipelinesRender',


        'ResourcesprogressionsRender',
        'SignedresourcesprogressionsUrl',


    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'resourcespipelines';
    }

    public function allresource()
    {
        return $this->belongsTo(AllresourcesModel::class, 'allresource_id', 'id');
    }

    public function resourcesprogressions()
    {
        return $this->hasMany(ResourcesprogressionsModel::class, 'resourcespipeline_id', 'id');
    }

    public function getResourcesprogressionsRenderAttribute()
    {

        $resultat = ResourcesprogressionsModel::where('resourcespipeline_id', (is_array($this->id) ? $this->id[0] : $this->id))->get();
        return count($resultat);
    }

    public function getSignedResourcesprogressionsUrlAttribute($value)
    {
        return URL::signedRoute('Resourcesprogressions_web_index_two',
            [
                'key' => 'resourcespipeline_id',
                'val' => (is_array($this->id) ? $this->id[0] : $this->id),
            ]);
    }

    public function Myresource()
    {
        return $this->morphMany(AllresourcesModel::class, 'resource');
    }

    public function getAllresourceIdRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['allresource_id']) ? $this->attributes['allresource_id'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        $donnees = AllresourcesModel::all()
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

    public function getAllresourceIdAttribute($value)
    {
        return explode(',', $value);
    }

    public function setAllresourceIdAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['allresource_id'] = is_array($value) ? implode(',', $value) : $value;
        } else {
            $this->attributes['allresource_id'] = 0;
        }

    }

    public function getPipelinesRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['pipelines']) ? $this->attributes['pipelines'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getPipelinesAttribute($value)
    {
        return $value;
    }

    public function setPipelinesAttribute($value)
    {
        $this->attributes['pipelines'] = $value ?? "";
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

    public function getPipelinesAvfAttribute($value)
    {


    }

    public function getSignedShowUrlAttribute($value)
    {
        return URL::signedRoute('Resourcespipelines_web_index_one',
            [
                'Resourcespipelines' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false
            ]);
    }

    public function getSignedEditUrlAttribute($value)
    {
        return URL::signedRoute('Resourcespipelines_web_update',
            ['Resourcespipelines' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getSignedDeleteUrlAttribute($value)
    {
        return URL::signedRoute('Resourcespipelines_web_update',
            ['Resourcespipelines' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getCardRenderAttribute($value)
    {
        return view('/content/prod/Resourcespipelines/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
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

