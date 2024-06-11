<?php

namespace App\Models\base;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use URL;


class AllresourcesModel extends Model
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
        'resource_type',
        'resource_id',
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


        'ResourceTypeRender',


        'ResourceIdRender',


        'ResourcespipelinesRender',
        'SignedresourcespipelinesUrl',


    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'allresources';
    }

    public function resourcespipelines()
    {
        return $this->hasMany(ResourcespipelinesModel::class, 'allresource_id', 'id');
    }

    public function getResourcespipelinesRenderAttribute()
    {

        $resultat = ResourcespipelinesModel::where('allresource_id', (is_array($this->id) ? $this->id[0] : $this->id))->get();
        return count($resultat);
    }

    public function getSignedResourcespipelinesUrlAttribute($value)
    {
        return URL::signedRoute('Resourcespipelines_web_index_two',
            [
                'key' => 'allresource_id',
                'val' => (is_array($this->id) ? $this->id[0] : $this->id),
            ]);
    }

    public function getResourceTypeRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['resource_type']) ? $this->attributes['resource_type'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getResourceTypeAttribute($value)
    {
        return $value;
    }

    public function setResourceTypeAttribute($value)
    {
        $this->attributes['resource_type'] = $value ?? "";
    }

    public function getResourceIdRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['resource_id']) ? $this->attributes['resource_id'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getResourceIdAttribute($value)
    {
        return $value;
    }

    public function setResourceIdAttribute($value)
    {
        $this->attributes['resource_id'] = $value ?? "";
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
        return URL::signedRoute('Allresources_web_index_one',
            [
                'Allresources' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false
            ]);
    }

    public function getSignedEditUrlAttribute($value)
    {
        return URL::signedRoute('Allresources_web_update',
            ['Allresources' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getSignedDeleteUrlAttribute($value)
    {
        return URL::signedRoute('Allresources_web_update',
            ['Allresources' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getCardRenderAttribute($value)
    {
        return view('/content/prod/Allresources/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
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

