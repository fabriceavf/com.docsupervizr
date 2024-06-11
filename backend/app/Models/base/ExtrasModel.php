<?php

namespace App\Models\base;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use URL;


class ExtrasModel extends Model
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
        'libelle',
        'types',
        'text',
        'files',
        'textarea',
        'datetime',
        'extra_attributes',
        'deleted_at',
        'created_at',
        'updated_at',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [

    ];
    protected $appends = ['DT_RowId', 'Selectvalue', 'Selectlabel', 'CardRender', 'ForMe',
        'SignedEditUrl', 'SignedDeleteUrl', 'SignedShowUrl', 'SignedImpressionUrl',


        'LibelleRender',


        'TypesRender',


        'TextRender',


        'FilesRender',


        'TextareaRender',


        'DatetimeRender',


    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'extras';
    }

    public function Myresource()
    {
        return $this->morphMany(AllresourcesModel::class, 'resource');
    }

    public function getLibelleRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['libelle']) ? $this->attributes['libelle'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getTypesRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['types']) ? $this->attributes['types'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getTypesAttribute($value)
    {
        return $value;
    }

    public function setTypesAttribute($value)
    {
        $this->attributes['types'] = $value ?? "";
    }

    public function getTextRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['text']) ? $this->attributes['text'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getTextAttribute($value)
    {
        return $value;
    }

    public function setTextAttribute($value)
    {
        $this->attributes['text'] = $value ?? "";
    }

    public function getFilesRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['files']) ? $this->attributes['files'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        $resultat = "Aucune images";

        if (!empty($value_base)) {

            $images = "";
            foreach ($value as $img) {
                $result = FilesModel::find($img);
                if (!empty($result->render)) {
                    $images .= $result->render;

                }

            }
            $resultat = "<div class='field_img_render'> $images </div>";
        }


        return $resultat;


        return $resultat;
    }

    public function getFilesAttribute($value)
    {
        return explode(',', $value);
    }

    public function setFilesAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['files'] = is_array($value) ? implode(',', $value) : $value;
        } else {
            $this->attributes['files'] = 0;
        }

    }

    public function getTextareaRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['textarea']) ? $this->attributes['textarea'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getTextareaAttribute($value)
    {
        return $value;
    }

    public function setTextareaAttribute($value)
    {
        $this->attributes['textarea'] = $value ?? "";
    }

    public function getDatetimeRenderAttribute($value)
    {

        $value_base = !empty($this->attributes['datetime']) ? $this->attributes['datetime'] : "";

        $value = explode(',', $value_base);

        $resultat = "########";


        return $resultat;
    }

    public function getDatetimeAttribute($value)
    {
        return $value;
    }

    public function setDatetimeAttribute($value)
    {
        $this->attributes['datetime'] = $value ?? "";
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

        return view('/content/base/pipelines/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();


    }

    public function getSignedShowUrlAttribute($value)
    {
        return URL::signedRoute('Extras_web_index_one',
            [
                'Extras' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false,
                'impression' => false
            ]);
    }

    public function getSignedImpressionUrlAttribute($value)
    {
        return URL::signedRoute('Extras_web_index_impression',
            [
                'Extras' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false
            ]);
    }

    public function getSignedEditUrlAttribute($value)
    {
        return URL::signedRoute('Extras_web_update',
            ['Extras' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getSignedDeleteUrlAttribute($value)
    {
        return URL::signedRoute('Extras_web_update',
            ['Extras' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getCardRenderAttribute($value)
    {
        return view('/content/base/Extras/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
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

