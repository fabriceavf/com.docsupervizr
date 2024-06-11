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


use App\Models\Intervention;


use App\Models\User;


use App\Models\Interventiondetail;


class Interventionuser extends Model
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
        'intervention_id',
        'user_id',
        'statut',
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


        'intervention',


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
        $this->table = 'interventionusers';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\InterventionuserObservers') &&
                method_exists('\App\Observers\InterventionuserObservers', 'creating')
            ) {

                try {
                    \App\Observers\InterventionuserObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\InterventionuserObservers') &&
                method_exists('\App\Observers\InterventionuserObservers', 'created')
            ) {

                try {
                    \App\Observers\InterventionuserObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\InterventionuserObservers') &&
                method_exists('\App\Observers\InterventionuserObservers', 'updating')
            ) {

                try {
                    \App\Observers\InterventionuserObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\InterventionuserObservers') &&
                method_exists('\App\Observers\InterventionuserObservers', 'updated')
            ) {

                try {
                    \App\Observers\InterventionuserObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\InterventionuserObservers') &&
                method_exists('\App\Observers\InterventionuserObservers', 'deleting')
            ) {

                try {
                    \App\Observers\InterventionuserObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\InterventionuserObservers') &&
                method_exists('\App\Observers\InterventionuserObservers', 'deleted')
            ) {

                try {
                    \App\Observers\InterventionuserObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function intervention()
    {
        return $this->belongsTo(Intervention::class, 'intervention_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function interventiondetails()
    {
        return $this->hasMany(Interventiondetail::class, 'interventionuser_id', 'id');
    }

    public function getInterventionIdAttribute($value)
    {
        return $value;
    }

    public function setInterventionIdAttribute($value)
    {
        $this->attributes['intervention_id'] = $value ?? "";
    }

    public function getStatutAttribute($value)
    {
        return $value;
    }

    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = $value ?? "";
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

