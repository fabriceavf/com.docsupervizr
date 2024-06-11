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


class Listingsvalider0stat extends Model
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

    ];
    protected $casts = [
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
        $this->table = 'listingsvalider0stats';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\Listingsvalider0statObservers') &&
                method_exists('\App\Observers\Listingsvalider0statObservers', 'creating')
            ) {

                try {
                    \App\Observers\Listingsvalider0statObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\Listingsvalider0statObservers') &&
                method_exists('\App\Observers\Listingsvalider0statObservers', 'created')
            ) {

                try {
                    \App\Observers\Listingsvalider0statObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\Listingsvalider0statObservers') &&
                method_exists('\App\Observers\Listingsvalider0statObservers', 'updating')
            ) {

                try {
                    \App\Observers\Listingsvalider0statObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\Listingsvalider0statObservers') &&
                method_exists('\App\Observers\Listingsvalider0statObservers', 'updated')
            ) {

                try {
                    \App\Observers\Listingsvalider0statObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\Listingsvalider0statObservers') &&
                method_exists('\App\Observers\Listingsvalider0statObservers', 'deleting')
            ) {

                try {
                    \App\Observers\Listingsvalider0statObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\Listingsvalider0statObservers') &&
                method_exists('\App\Observers\Listingsvalider0statObservers', 'deleted')
            ) {

                try {
                    \App\Observers\Listingsvalider0statObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
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

