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


use App\Models\Programmation;


use App\Models\User;


use App\Models\Programme;


use App\Models\Programmesronde;


class Programmationsuser extends Model
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
        'user_id',
        'programmation_id',
        'extra_attributes',
        'created_at',
        'updated_at',
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


        'programmation',


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
        $this->table = 'programmationsusers';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsuserObservers') &&
                method_exists('\App\Observers\ProgrammationsuserObservers', 'creating')
            ) {

                try {
                    \App\Observers\ProgrammationsuserObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsuserObservers') &&
                method_exists('\App\Observers\ProgrammationsuserObservers', 'created')
            ) {

                try {
                    \App\Observers\ProgrammationsuserObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsuserObservers') &&
                method_exists('\App\Observers\ProgrammationsuserObservers', 'updating')
            ) {

                try {
                    \App\Observers\ProgrammationsuserObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsuserObservers') &&
                method_exists('\App\Observers\ProgrammationsuserObservers', 'updated')
            ) {

                try {
                    \App\Observers\ProgrammationsuserObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsuserObservers') &&
                method_exists('\App\Observers\ProgrammationsuserObservers', 'deleting')
            ) {

                try {
                    \App\Observers\ProgrammationsuserObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\ProgrammationsuserObservers') &&
                method_exists('\App\Observers\ProgrammationsuserObservers', 'deleted')
            ) {

                try {
                    \App\Observers\ProgrammationsuserObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function programmation()
    {
        return $this->belongsTo(Programmation::class, 'programmation_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function programmes()
    {
        return $this->hasMany(Programme::class, 'programmationsuser_id', 'id');
    }

    public function programmesrondes()
    {
        return $this->hasMany(Programmesronde::class, 'programmationsuser_id', 'id');
    }

    public function getProgrammationIdAttribute($value)
    {
        return $value;
    }

    public function setProgrammationIdAttribute($value)
    {
        $this->attributes['programmation_id'] = $value ?? "";
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

