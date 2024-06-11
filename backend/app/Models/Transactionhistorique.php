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


use App\Models\Transaction;


class Transactionhistorique extends Model
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
        'depuis',
        'transaction_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'extra_attributes',
        'identifiants_sadge',
        'creat_by',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


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
        $this->table = 'transactionhistoriques';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TransactionhistoriqueObservers') &&
                method_exists('\App\Observers\TransactionhistoriqueObservers', 'creating')
            ) {

                try {
                    \App\Observers\TransactionhistoriqueObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TransactionhistoriqueObservers') &&
                method_exists('\App\Observers\TransactionhistoriqueObservers', 'created')
            ) {

                try {
                    \App\Observers\TransactionhistoriqueObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TransactionhistoriqueObservers') &&
                method_exists('\App\Observers\TransactionhistoriqueObservers', 'updating')
            ) {

                try {
                    \App\Observers\TransactionhistoriqueObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TransactionhistoriqueObservers') &&
                method_exists('\App\Observers\TransactionhistoriqueObservers', 'updated')
            ) {

                try {
                    \App\Observers\TransactionhistoriqueObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TransactionhistoriqueObservers') &&
                method_exists('\App\Observers\TransactionhistoriqueObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TransactionhistoriqueObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TransactionhistoriqueObservers') &&
                method_exists('\App\Observers\TransactionhistoriqueObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TransactionhistoriqueObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function getDepuisAttribute($value)
    {
        return $value;
    }

    public function setDepuisAttribute($value)
    {
        $this->attributes['depuis'] = $value ?? "";
    }

    public function getTransactionIdAttribute($value)
    {
        return $value;
    }

    public function setTransactionIdAttribute($value)
    {
        $this->attributes['transaction_id'] = $value ?? "";
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

