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


use App\Models\User;


class Historiquemodelslisting extends Model
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
        'action',
        'ancien',
        'nouveau',
        'modelisting_id',
        'user_id',
        'created_at',
        'updated_at',
        'extra_attributes',
        'deleted_at',
        'identifiants_sadge',
        'creat_by',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'user',


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
        $this->table = 'historiquemodelslistings';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\HistoriquemodelslistingObservers') &&
                method_exists('\App\Observers\HistoriquemodelslistingObservers', 'creating')
            ) {

                try {
                    \App\Observers\HistoriquemodelslistingObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\HistoriquemodelslistingObservers') &&
                method_exists('\App\Observers\HistoriquemodelslistingObservers', 'created')
            ) {

                try {
                    \App\Observers\HistoriquemodelslistingObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\HistoriquemodelslistingObservers') &&
                method_exists('\App\Observers\HistoriquemodelslistingObservers', 'updating')
            ) {

                try {
                    \App\Observers\HistoriquemodelslistingObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\HistoriquemodelslistingObservers') &&
                method_exists('\App\Observers\HistoriquemodelslistingObservers', 'updated')
            ) {

                try {
                    \App\Observers\HistoriquemodelslistingObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\HistoriquemodelslistingObservers') &&
                method_exists('\App\Observers\HistoriquemodelslistingObservers', 'deleting')
            ) {

                try {
                    \App\Observers\HistoriquemodelslistingObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\HistoriquemodelslistingObservers') &&
                method_exists('\App\Observers\HistoriquemodelslistingObservers', 'deleted')
            ) {

                try {
                    \App\Observers\HistoriquemodelslistingObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getActionAttribute($value)
    {
        return $value;
    }

    public function setActionAttribute($value)
    {
        $this->attributes['action'] = $value ?? "";
    }

    public function getAncienAttribute($value)
    {
        return $value;
    }

    public function setAncienAttribute($value)
    {
        $this->attributes['ancien'] = $value ?? "";
    }

    public function getNouveauAttribute($value)
    {
        return $value;
    }

    public function setNouveauAttribute($value)
    {
        $this->attributes['nouveau'] = $value ?? "";
    }

    public function getModelistingIdAttribute($value)
    {
        return $value;
    }

    public function setModelistingIdAttribute($value)
    {
        $this->attributes['modelisting_id'] = $value ?? "";
    }

    public function getIdentifiantsSadgeAttribute($value)
    {
        return $value;
    }

    public function setIdentifiantsSadgeAttribute($value)
    {
        $this->attributes['identifiants_sadge'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
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


        $select .= "" . $this->action . " ";


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

