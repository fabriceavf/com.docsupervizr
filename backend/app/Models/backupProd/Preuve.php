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


use App\Models\Programme;


use App\Models\Transaction;


class Preuve extends Model
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
        'programme_id',
        'transaction_id',
        'punch_time',
        'type',
        'role',
        'etats',
        'extra_attributes',
        'created_at',
        'updated_at',
        'valide',
        'remarque',
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


        'programme',


        'transaction',


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
        $this->table = 'preuves';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\PreuveObservers') &&
                method_exists('\App\Observers\PreuveObservers', 'creating')
            ) {

                try {
                    \App\Observers\PreuveObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\PreuveObservers') &&
                method_exists('\App\Observers\PreuveObservers', 'created')
            ) {

                try {
                    \App\Observers\PreuveObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\PreuveObservers') &&
                method_exists('\App\Observers\PreuveObservers', 'updating')
            ) {

                try {
                    \App\Observers\PreuveObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\PreuveObservers') &&
                method_exists('\App\Observers\PreuveObservers', 'updated')
            ) {

                try {
                    \App\Observers\PreuveObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\PreuveObservers') &&
                method_exists('\App\Observers\PreuveObservers', 'deleting')
            ) {

                try {
                    \App\Observers\PreuveObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\PreuveObservers') &&
                method_exists('\App\Observers\PreuveObservers', 'deleted')
            ) {

                try {
                    \App\Observers\PreuveObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'programme_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function getProgrammeIdAttribute($value)
    {
        return $value;
    }

    public function setProgrammeIdAttribute($value)
    {
        $this->attributes['programme_id'] = $value ?? "";
    }

    public function getTransactionIdAttribute($value)
    {
        return $value;
    }

    public function setTransactionIdAttribute($value)
    {
        $this->attributes['transaction_id'] = $value ?? "";
    }

    public function getPunchTimeAttribute($value)
    {
        return $value;
    }

    public function setPunchTimeAttribute($value)
    {
        $this->attributes['punch_time'] = $value ?? "";
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?? "";
    }

    public function getRoleAttribute($value)
    {
        return $value;
    }

    public function setRoleAttribute($value)
    {
        $this->attributes['role'] = $value ?? "";
    }

    public function getEtatsAttribute($value)
    {
        return $value;
    }

    public function setEtatsAttribute($value)
    {
        $this->attributes['etats'] = $value ?? "";
    }

    public function getValideAttribute($value)
    {
        return $value;
    }

    public function setValideAttribute($value)
    {
        $this->attributes['valide'] = $value ?? "";
    }

    public function getRemarqueAttribute($value)
    {
        return $value;
    }

    public function setRemarqueAttribute($value)
    {
        $this->attributes['remarque'] = $value ?? "";
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

