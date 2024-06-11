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


class Transactionsuserssynthese extends Model
{

    use SchemalessAttributesTrait;
    use SoftDeletes;


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = '';
    protected $fillable = [
        'transactions_totals',
        'transactions_id',
        'transactions_heures',
        'matricule',
        'date',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


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
        $this->table = 'transactionsuserssyntheses';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsuserssyntheseObservers') &&
                method_exists('\App\Observers\TransactionsuserssyntheseObservers', 'creating')
            ) {

                try {
                    \App\Observers\TransactionsuserssyntheseObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsuserssyntheseObservers') &&
                method_exists('\App\Observers\TransactionsuserssyntheseObservers', 'created')
            ) {

                try {
                    \App\Observers\TransactionsuserssyntheseObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsuserssyntheseObservers') &&
                method_exists('\App\Observers\TransactionsuserssyntheseObservers', 'updating')
            ) {

                try {
                    \App\Observers\TransactionsuserssyntheseObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsuserssyntheseObservers') &&
                method_exists('\App\Observers\TransactionsuserssyntheseObservers', 'updated')
            ) {

                try {
                    \App\Observers\TransactionsuserssyntheseObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsuserssyntheseObservers') &&
                method_exists('\App\Observers\TransactionsuserssyntheseObservers', 'deleting')
            ) {

                try {
                    \App\Observers\TransactionsuserssyntheseObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\TransactionsuserssyntheseObservers') &&
                method_exists('\App\Observers\TransactionsuserssyntheseObservers', 'deleted')
            ) {

                try {
                    \App\Observers\TransactionsuserssyntheseObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function getTransactionsTotalsAttribute($value)
    {
        return $value;
    }

    public function setTransactionsTotalsAttribute($value)
    {
        $this->attributes['transactions_totals'] = $value ?? "";
    }

    public function getTransactionsIdAttribute($value)
    {
        return $value;
    }

    public function setTransactionsIdAttribute($value)
    {
        $this->attributes['transactions_id'] = $value ?? "";
    }

    public function getTransactionsHeuresAttribute($value)
    {
        return $value;
    }

    public function setTransactionsHeuresAttribute($value)
    {
        $this->attributes['transactions_heures'] = $value ?? "";
    }

    public function getMatriculeAttribute($value)
    {
        return $value;
    }

    public function setMatriculeAttribute($value)
    {
        $this->attributes['matricule'] = $value ?? "";
    }

    public function getDateAttribute($value)
    {
        return $value;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ?? "";
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

