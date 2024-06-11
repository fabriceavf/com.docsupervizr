<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Arr;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


use App\Models\Form;


class Formsdata extends Model
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
        'parent',
        'form_id',
        'cle0',
        'cle1',
        'cle2',
        'cle3',
        'cle4',
        'cle5',
        'cle6',
        'cle7',
        'cle8',
        'cle9',
        'cle10',
        'cle11',
        'cle12',
        'cle13',
        'cle14',
        'cle15',
        'cle16',
        'cle17',
        'cle18',
        'cle19',
        'cle20',
        'cle21',
        'cle22',
        'cle23',
        'cle24',
        'cle25',
        'cle26',
        'cle27',
        'cle28',
        'cle29',
        'cle30',
        'cle31',
        'cle32',
        'cle33',
        'cle34',
        'cle35',
        'cle36',
        'cle37',
        'cle38',
        'cle39',
        'cle40',
        'cle41',
        'cle42',
        'cle43',
        'cle44',
        'cle45',
        'cle46',
        'cle47',
        'cle48',
        'cle49',
        'cle50',
        'cle51',
        'cle52',
        'cle53',
        'cle54',
        'cle55',
        'cle56',
        'cle57',
        'cle58',
        'cle59',
        'cle60',
        'cle61',
        'cle62',
        'cle63',
        'cle64',
        'cle65',
        'cle66',
        'cle67',
        'cle68',
        'cle69',
        'cle70',
        'cle71',
        'cle72',
        'cle73',
        'cle74',
        'cle75',
        'cle76',
        'cle77',
        'cle78',
        'cle79',
        'cle80',
        'cle81',
        'cle82',
        'cle83',
        'cle84',
        'cle85',
        'cle86',
        'cle87',
        'cle88',
        'cle89',
        'cle90',
        'cle91',
        'cle92',
        'cle93',
        'cle94',
        'cle95',
        'cle96',
        'cle97',
        'cle98',
        'cle99',
        'extra_attributes',
        'creat_by',
        'deleted_at',
        'created_at',
        'updated_at',
        'identifiants_sadge',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'form',


    ];
    protected $appends = [
        'Selectvalue', 'Selectlabel'
    ];
    protected $schemalessAttributes = [
        'extra_attributes',
        'other_extra_attributes',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'formsdatas';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\FormsdataObservers') &&
                method_exists('\App\Observers\FormsdataObservers', 'creating')
            ) {

                try {
                    \App\Observers\FormsdataObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\FormsdataObservers') &&
                method_exists('\App\Observers\FormsdataObservers', 'created')
            ) {

                try {
                    \App\Observers\FormsdataObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\FormsdataObservers') &&
                method_exists('\App\Observers\FormsdataObservers', 'updating')
            ) {

                try {
                    \App\Observers\FormsdataObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\FormsdataObservers') &&
                method_exists('\App\Observers\FormsdataObservers', 'updated')
            ) {

                try {
                    \App\Observers\FormsdataObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\FormsdataObservers') &&
                method_exists('\App\Observers\FormsdataObservers', 'deleting')
            ) {

                try {
                    \App\Observers\FormsdataObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\FormsdataObservers') &&
                method_exists('\App\Observers\FormsdataObservers', 'deleted')
            ) {

                try {
                    \App\Observers\FormsdataObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }

    public function getLibelleAttribute($value)
    {
        return $value;
    }

    public function setLibelleAttribute($value)
    {
        $this->attributes['libelle'] = $value ?? "";
    }

    public function getParentAttribute($value)
    {
        return $value;
    }

    public function setParentAttribute($value)
    {
        $this->attributes['parent'] = $value ?? "";
    }

    public function getFormIdAttribute($value)
    {
        return $value;
    }

    public function setFormIdAttribute($value)
    {
        $this->attributes['form_id'] = $value ?? "";
    }

    public function getCle0Attribute($value)
    {
        return $value;
    }

    public function setCle0Attribute($value)
    {
        $this->attributes['cle0'] = $value ?? "";
    }

    public function getCle1Attribute($value)
    {
        return $value;
    }

    public function setCle1Attribute($value)
    {
        $this->attributes['cle1'] = $value ?? "";
    }

    public function getCle2Attribute($value)
    {
        return $value;
    }

    public function setCle2Attribute($value)
    {
        $this->attributes['cle2'] = $value ?? "";
    }

    public function getCle3Attribute($value)
    {
        return $value;
    }

    public function setCle3Attribute($value)
    {
        $this->attributes['cle3'] = $value ?? "";
    }

    public function getCle4Attribute($value)
    {
        return $value;
    }

    public function setCle4Attribute($value)
    {
        $this->attributes['cle4'] = $value ?? "";
    }

    public function getCle5Attribute($value)
    {
        return $value;
    }

    public function setCle5Attribute($value)
    {
        $this->attributes['cle5'] = $value ?? "";
    }

    public function getCle6Attribute($value)
    {
        return $value;
    }

    public function setCle6Attribute($value)
    {
        $this->attributes['cle6'] = $value ?? "";
    }

    public function getCle7Attribute($value)
    {
        return $value;
    }

    public function setCle7Attribute($value)
    {
        $this->attributes['cle7'] = $value ?? "";
    }

    public function getCle8Attribute($value)
    {
        return $value;
    }

    public function setCle8Attribute($value)
    {
        $this->attributes['cle8'] = $value ?? "";
    }

    public function getCle9Attribute($value)
    {
        return $value;
    }

    public function setCle9Attribute($value)
    {
        $this->attributes['cle9'] = $value ?? "";
    }

    public function getCle10Attribute($value)
    {
        return $value;
    }

    public function setCle10Attribute($value)
    {
        $this->attributes['cle10'] = $value ?? "";
    }

    public function getCle11Attribute($value)
    {
        return $value;
    }

    public function setCle11Attribute($value)
    {
        $this->attributes['cle11'] = $value ?? "";
    }

    public function getCle12Attribute($value)
    {
        return $value;
    }

    public function setCle12Attribute($value)
    {
        $this->attributes['cle12'] = $value ?? "";
    }

    public function getCle13Attribute($value)
    {
        return $value;
    }

    public function setCle13Attribute($value)
    {
        $this->attributes['cle13'] = $value ?? "";
    }

    public function getCle14Attribute($value)
    {
        return $value;
    }

    public function setCle14Attribute($value)
    {
        $this->attributes['cle14'] = $value ?? "";
    }

    public function getCle15Attribute($value)
    {
        return $value;
    }

    public function setCle15Attribute($value)
    {
        $this->attributes['cle15'] = $value ?? "";
    }

    public function getCle16Attribute($value)
    {
        return $value;
    }

    public function setCle16Attribute($value)
    {
        $this->attributes['cle16'] = $value ?? "";
    }

    public function getCle17Attribute($value)
    {
        return $value;
    }

    public function setCle17Attribute($value)
    {
        $this->attributes['cle17'] = $value ?? "";
    }

    public function getCle18Attribute($value)
    {
        return $value;
    }

    public function setCle18Attribute($value)
    {
        $this->attributes['cle18'] = $value ?? "";
    }

    public function getCle19Attribute($value)
    {
        return $value;
    }

    public function setCle19Attribute($value)
    {
        $this->attributes['cle19'] = $value ?? "";
    }

    public function getCle20Attribute($value)
    {
        return $value;
    }

    public function setCle20Attribute($value)
    {
        $this->attributes['cle20'] = $value ?? "";
    }

    public function getCle21Attribute($value)
    {
        return $value;
    }

    public function setCle21Attribute($value)
    {
        $this->attributes['cle21'] = $value ?? "";
    }

    public function getCle22Attribute($value)
    {
        return $value;
    }

    public function setCle22Attribute($value)
    {
        $this->attributes['cle22'] = $value ?? "";
    }

    public function getCle23Attribute($value)
    {
        return $value;
    }

    public function setCle23Attribute($value)
    {
        $this->attributes['cle23'] = $value ?? "";
    }

    public function getCle24Attribute($value)
    {
        return $value;
    }

    public function setCle24Attribute($value)
    {
        $this->attributes['cle24'] = $value ?? "";
    }

    public function getCle25Attribute($value)
    {
        return $value;
    }

    public function setCle25Attribute($value)
    {
        $this->attributes['cle25'] = $value ?? "";
    }

    public function getCle26Attribute($value)
    {
        return $value;
    }

    public function setCle26Attribute($value)
    {
        $this->attributes['cle26'] = $value ?? "";
    }

    public function getCle27Attribute($value)
    {
        return $value;
    }

    public function setCle27Attribute($value)
    {
        $this->attributes['cle27'] = $value ?? "";
    }

    public function getCle28Attribute($value)
    {
        return $value;
    }

    public function setCle28Attribute($value)
    {
        $this->attributes['cle28'] = $value ?? "";
    }

    public function getCle29Attribute($value)
    {
        return $value;
    }

    public function setCle29Attribute($value)
    {
        $this->attributes['cle29'] = $value ?? "";
    }

    public function getCle30Attribute($value)
    {
        return $value;
    }

    public function setCle30Attribute($value)
    {
        $this->attributes['cle30'] = $value ?? "";
    }

    public function getCle31Attribute($value)
    {
        return $value;
    }

    public function setCle31Attribute($value)
    {
        $this->attributes['cle31'] = $value ?? "";
    }

    public function getCle32Attribute($value)
    {
        return $value;
    }

    public function setCle32Attribute($value)
    {
        $this->attributes['cle32'] = $value ?? "";
    }

    public function getCle33Attribute($value)
    {
        return $value;
    }

    public function setCle33Attribute($value)
    {
        $this->attributes['cle33'] = $value ?? "";
    }

    public function getCle34Attribute($value)
    {
        return $value;
    }

    public function setCle34Attribute($value)
    {
        $this->attributes['cle34'] = $value ?? "";
    }

    public function getCle35Attribute($value)
    {
        return $value;
    }

    public function setCle35Attribute($value)
    {
        $this->attributes['cle35'] = $value ?? "";
    }

    public function getCle36Attribute($value)
    {
        return $value;
    }

    public function setCle36Attribute($value)
    {
        $this->attributes['cle36'] = $value ?? "";
    }

    public function getCle37Attribute($value)
    {
        return $value;
    }

    public function setCle37Attribute($value)
    {
        $this->attributes['cle37'] = $value ?? "";
    }

    public function getCle38Attribute($value)
    {
        return $value;
    }

    public function setCle38Attribute($value)
    {
        $this->attributes['cle38'] = $value ?? "";
    }

    public function getCle39Attribute($value)
    {
        return $value;
    }

    public function setCle39Attribute($value)
    {
        $this->attributes['cle39'] = $value ?? "";
    }

    public function getCle40Attribute($value)
    {
        return $value;
    }

    public function setCle40Attribute($value)
    {
        $this->attributes['cle40'] = $value ?? "";
    }

    public function getCle41Attribute($value)
    {
        return $value;
    }

    public function setCle41Attribute($value)
    {
        $this->attributes['cle41'] = $value ?? "";
    }

    public function getCle42Attribute($value)
    {
        return $value;
    }

    public function setCle42Attribute($value)
    {
        $this->attributes['cle42'] = $value ?? "";
    }

    public function getCle43Attribute($value)
    {
        return $value;
    }

    public function setCle43Attribute($value)
    {
        $this->attributes['cle43'] = $value ?? "";
    }

    public function getCle44Attribute($value)
    {
        return $value;
    }

    public function setCle44Attribute($value)
    {
        $this->attributes['cle44'] = $value ?? "";
    }

    public function getCle45Attribute($value)
    {
        return $value;
    }

    public function setCle45Attribute($value)
    {
        $this->attributes['cle45'] = $value ?? "";
    }

    public function getCle46Attribute($value)
    {
        return $value;
    }

    public function setCle46Attribute($value)
    {
        $this->attributes['cle46'] = $value ?? "";
    }

    public function getCle47Attribute($value)
    {
        return $value;
    }

    public function setCle47Attribute($value)
    {
        $this->attributes['cle47'] = $value ?? "";
    }

    public function getCle48Attribute($value)
    {
        return $value;
    }

    public function setCle48Attribute($value)
    {
        $this->attributes['cle48'] = $value ?? "";
    }

    public function getCle49Attribute($value)
    {
        return $value;
    }

    public function setCle49Attribute($value)
    {
        $this->attributes['cle49'] = $value ?? "";
    }

    public function getCle50Attribute($value)
    {
        return $value;
    }

    public function setCle50Attribute($value)
    {
        $this->attributes['cle50'] = $value ?? "";
    }

    public function getCle51Attribute($value)
    {
        return $value;
    }

    public function setCle51Attribute($value)
    {
        $this->attributes['cle51'] = $value ?? "";
    }

    public function getCle52Attribute($value)
    {
        return $value;
    }

    public function setCle52Attribute($value)
    {
        $this->attributes['cle52'] = $value ?? "";
    }

    public function getCle53Attribute($value)
    {
        return $value;
    }

    public function setCle53Attribute($value)
    {
        $this->attributes['cle53'] = $value ?? "";
    }

    public function getCle54Attribute($value)
    {
        return $value;
    }

    public function setCle54Attribute($value)
    {
        $this->attributes['cle54'] = $value ?? "";
    }

    public function getCle55Attribute($value)
    {
        return $value;
    }

    public function setCle55Attribute($value)
    {
        $this->attributes['cle55'] = $value ?? "";
    }

    public function getCle56Attribute($value)
    {
        return $value;
    }

    public function setCle56Attribute($value)
    {
        $this->attributes['cle56'] = $value ?? "";
    }

    public function getCle57Attribute($value)
    {
        return $value;
    }

    public function setCle57Attribute($value)
    {
        $this->attributes['cle57'] = $value ?? "";
    }

    public function getCle58Attribute($value)
    {
        return $value;
    }

    public function setCle58Attribute($value)
    {
        $this->attributes['cle58'] = $value ?? "";
    }

    public function getCle59Attribute($value)
    {
        return $value;
    }

    public function setCle59Attribute($value)
    {
        $this->attributes['cle59'] = $value ?? "";
    }

    public function getCle60Attribute($value)
    {
        return $value;
    }

    public function setCle60Attribute($value)
    {
        $this->attributes['cle60'] = $value ?? "";
    }

    public function getCle61Attribute($value)
    {
        return $value;
    }

    public function setCle61Attribute($value)
    {
        $this->attributes['cle61'] = $value ?? "";
    }

    public function getCle62Attribute($value)
    {
        return $value;
    }

    public function setCle62Attribute($value)
    {
        $this->attributes['cle62'] = $value ?? "";
    }

    public function getCle63Attribute($value)
    {
        return $value;
    }

    public function setCle63Attribute($value)
    {
        $this->attributes['cle63'] = $value ?? "";
    }

    public function getCle64Attribute($value)
    {
        return $value;
    }

    public function setCle64Attribute($value)
    {
        $this->attributes['cle64'] = $value ?? "";
    }

    public function getCle65Attribute($value)
    {
        return $value;
    }

    public function setCle65Attribute($value)
    {
        $this->attributes['cle65'] = $value ?? "";
    }

    public function getCle66Attribute($value)
    {
        return $value;
    }

    public function setCle66Attribute($value)
    {
        $this->attributes['cle66'] = $value ?? "";
    }

    public function getCle67Attribute($value)
    {
        return $value;
    }

    public function setCle67Attribute($value)
    {
        $this->attributes['cle67'] = $value ?? "";
    }

    public function getCle68Attribute($value)
    {
        return $value;
    }

    public function setCle68Attribute($value)
    {
        $this->attributes['cle68'] = $value ?? "";
    }

    public function getCle69Attribute($value)
    {
        return $value;
    }

    public function setCle69Attribute($value)
    {
        $this->attributes['cle69'] = $value ?? "";
    }

    public function getCle70Attribute($value)
    {
        return $value;
    }

    public function setCle70Attribute($value)
    {
        $this->attributes['cle70'] = $value ?? "";
    }

    public function getCle71Attribute($value)
    {
        return $value;
    }

    public function setCle71Attribute($value)
    {
        $this->attributes['cle71'] = $value ?? "";
    }

    public function getCle72Attribute($value)
    {
        return $value;
    }

    public function setCle72Attribute($value)
    {
        $this->attributes['cle72'] = $value ?? "";
    }

    public function getCle73Attribute($value)
    {
        return $value;
    }

    public function setCle73Attribute($value)
    {
        $this->attributes['cle73'] = $value ?? "";
    }

    public function getCle74Attribute($value)
    {
        return $value;
    }

    public function setCle74Attribute($value)
    {
        $this->attributes['cle74'] = $value ?? "";
    }

    public function getCle75Attribute($value)
    {
        return $value;
    }

    public function setCle75Attribute($value)
    {
        $this->attributes['cle75'] = $value ?? "";
    }

    public function getCle76Attribute($value)
    {
        return $value;
    }

    public function setCle76Attribute($value)
    {
        $this->attributes['cle76'] = $value ?? "";
    }

    public function getCle77Attribute($value)
    {
        return $value;
    }

    public function setCle77Attribute($value)
    {
        $this->attributes['cle77'] = $value ?? "";
    }

    public function getCle78Attribute($value)
    {
        return $value;
    }

    public function setCle78Attribute($value)
    {
        $this->attributes['cle78'] = $value ?? "";
    }

    public function getCle79Attribute($value)
    {
        return $value;
    }

    public function setCle79Attribute($value)
    {
        $this->attributes['cle79'] = $value ?? "";
    }

    public function getCle80Attribute($value)
    {
        return $value;
    }

    public function setCle80Attribute($value)
    {
        $this->attributes['cle80'] = $value ?? "";
    }

    public function getCle81Attribute($value)
    {
        return $value;
    }

    public function setCle81Attribute($value)
    {
        $this->attributes['cle81'] = $value ?? "";
    }

    public function getCle82Attribute($value)
    {
        return $value;
    }

    public function setCle82Attribute($value)
    {
        $this->attributes['cle82'] = $value ?? "";
    }

    public function getCle83Attribute($value)
    {
        return $value;
    }

    public function setCle83Attribute($value)
    {
        $this->attributes['cle83'] = $value ?? "";
    }

    public function getCle84Attribute($value)
    {
        return $value;
    }

    public function setCle84Attribute($value)
    {
        $this->attributes['cle84'] = $value ?? "";
    }

    public function getCle85Attribute($value)
    {
        return $value;
    }

    public function setCle85Attribute($value)
    {
        $this->attributes['cle85'] = $value ?? "";
    }

    public function getCle86Attribute($value)
    {
        return $value;
    }

    public function setCle86Attribute($value)
    {
        $this->attributes['cle86'] = $value ?? "";
    }

    public function getCle87Attribute($value)
    {
        return $value;
    }

    public function setCle87Attribute($value)
    {
        $this->attributes['cle87'] = $value ?? "";
    }

    public function getCle88Attribute($value)
    {
        return $value;
    }

    public function setCle88Attribute($value)
    {
        $this->attributes['cle88'] = $value ?? "";
    }

    public function getCle89Attribute($value)
    {
        return $value;
    }

    public function setCle89Attribute($value)
    {
        $this->attributes['cle89'] = $value ?? "";
    }

    public function getCle90Attribute($value)
    {
        return $value;
    }

    public function setCle90Attribute($value)
    {
        $this->attributes['cle90'] = $value ?? "";
    }

    public function getCle91Attribute($value)
    {
        return $value;
    }

    public function setCle91Attribute($value)
    {
        $this->attributes['cle91'] = $value ?? "";
    }

    public function getCle92Attribute($value)
    {
        return $value;
    }

    public function setCle92Attribute($value)
    {
        $this->attributes['cle92'] = $value ?? "";
    }

    public function getCle93Attribute($value)
    {
        return $value;
    }

    public function setCle93Attribute($value)
    {
        $this->attributes['cle93'] = $value ?? "";
    }

    public function getCle94Attribute($value)
    {
        return $value;
    }

    public function setCle94Attribute($value)
    {
        $this->attributes['cle94'] = $value ?? "";
    }

    public function getCle95Attribute($value)
    {
        return $value;
    }

    public function setCle95Attribute($value)
    {
        $this->attributes['cle95'] = $value ?? "";
    }

    public function getCle96Attribute($value)
    {
        return $value;
    }

    public function setCle96Attribute($value)
    {
        $this->attributes['cle96'] = $value ?? "";
    }

    public function getCle97Attribute($value)
    {
        return $value;
    }

    public function setCle97Attribute($value)
    {
        $this->attributes['cle97'] = $value ?? "";
    }

    public function getCle98Attribute($value)
    {
        return $value;
    }

    public function setCle98Attribute($value)
    {
        $this->attributes['cle98'] = $value ?? "";
    }

    public function getCle99Attribute($value)
    {
        return $value;
    }

    public function setCle99Attribute($value)
    {
        $this->attributes['cle99'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
    }

    public function getIdentifiantsSadgeAttribute($value)
    {
        return $value;
    }

    public function setIdentifiantsSadgeAttribute($value)
    {
        $this->attributes['identifiants_sadge'] = $value ?? "";
    }

    public function getSelectvalueAttribute()
    {
        $select = "";
        try {
            $select = $this->id;
        } catch (\Throwable $e) {

        }


        return trim($select);

    }

    public function getSelectlabelAttribute()
    {
        $select = "";
        try {
            $select = $this->libelle;
        } catch (\Throwable $e) {

        }


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

