<?php

namespace App\Models\base;

use App\Models\prod\UsersModel;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use URL;


class AuthentificationsModel extends Model
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
        'ip',
        'email',
        'operations',
        'lieu',
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
        'SignedEditUrl', 'SignedDeleteUrl', 'SignedShowUrl', 'Boutons', 'CreateursCruds',


        'IpRender',


        'EmailRender',


        'OperationsRender',


        'LieuRender',


    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'authentifications';
    }

    public function getCreateursCrudsAttribute($value)
    {
        $response = "Systeme";
        $crud = \App\Models\prod\CrudsModel::where([
            'models' => "\App\Models\prod\AuthentificationsModel",
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

    public function getIpRenderAttribute($value)
    {

        $value_base = $this->attributes['ip'];
        $value = explode(',', $this->attributes['ip']);
        $resultat = "Aucun fichiers";


        return $resultat;
    }

    public function getIpAttribute($value)
    {
        return $value;
    }

    public function setIpAttribute($value)
    {
        $this->attributes['ip'] = $value ?? "";
    }

    public function getEmailRenderAttribute($value)
    {

        $value_base = $this->attributes['email'];
        $value = explode(',', $this->attributes['email']);
        $resultat = "Aucun fichiers";


        return $resultat;
    }

    public function getEmailAttribute($value)
    {
        return $value;
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value ?? "";
    }

    public function getOperationsRenderAttribute($value)
    {

        $value_base = $this->attributes['operations'];
        $value = explode(',', $this->attributes['operations']);
        $resultat = "Aucun fichiers";


        return $resultat;
    }

    public function getOperationsAttribute($value)
    {
        return $value;
    }

    public function setOperationsAttribute($value)
    {
        $this->attributes['operations'] = $value ?? "";
    }

    public function getLieuRenderAttribute($value)
    {

        $value_base = $this->attributes['lieu'];
        $value = explode(',', $this->attributes['lieu']);
        $resultat = "Aucun fichiers";


        return $resultat;
    }

    public function getLieuAttribute($value)
    {
        return $value;
    }

    public function setLieuAttribute($value)
    {
        $this->attributes['lieu'] = $value ?? "";
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


        $select .= " " . $this->id;


        return trim($select);


    }

    public function getBoutonsAttribute($value)
    {
        return [];
    }

    public function getSignedShowUrlAttribute($value)
    {
        return URL::signedRoute('Authentifications_web_index_one',
            [
                'Authentifications' => (is_array($this->id) ? $this->id[0] : $this->id),
                'crud' => false,
                'voir' => false
            ]);
    }

    public function getSignedEditUrlAttribute($value)
    {
        return URL::signedRoute('Authentifications_web_update',
            ['Authentifications' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getSignedDeleteUrlAttribute($value)
    {
        return URL::signedRoute('Authentifications_web_update',
            ['Authentifications' => (is_array($this->id) ? $this->id[0] : $this->id)]);
    }

    public function getCardRenderAttribute($value)
    {
        return view('/content/prod/Authentifications/cardrender', ['data' => self::find((is_array($this->id) ? $this->id[0] : $this->id))])->render();
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

