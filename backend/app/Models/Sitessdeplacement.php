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


use App\Models\Deplacement;


use App\Models\Site;


class Sitessdeplacement extends Model
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
        'deplacement_id',
        'site_id',
        'durees',
        'creat_by',
        'extra_attributes',
        'created_at',
        'updated_at',
        'deleted_at',
        'date',

    ];
    protected $casts = [

        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];
    protected $with = [


        'deplacement',


        'site',


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
        $this->table = 'sitessdeplacements';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (
                class_exists('\App\Observers\SitessdeplacementObservers') &&
                method_exists('\App\Observers\SitessdeplacementObservers', 'creating')
            ) {

                try {
                    \App\Observers\SitessdeplacementObservers::creating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::created(function ($model) {
            if (
                class_exists('\App\Observers\SitessdeplacementObservers') &&
                method_exists('\App\Observers\SitessdeplacementObservers', 'created')
            ) {

                try {
                    \App\Observers\SitessdeplacementObservers::created($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updating(function ($model) {
            if (
                class_exists('\App\Observers\SitessdeplacementObservers') &&
                method_exists('\App\Observers\SitessdeplacementObservers', 'updating')
            ) {

                try {
                    \App\Observers\SitessdeplacementObservers::updating($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::updated(function ($model) {
            if (
                class_exists('\App\Observers\SitessdeplacementObservers') &&
                method_exists('\App\Observers\SitessdeplacementObservers', 'updated')
            ) {

                try {
                    \App\Observers\SitessdeplacementObservers::updated($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleting(function ($model) {
            if (
                class_exists('\App\Observers\SitessdeplacementObservers') &&
                method_exists('\App\Observers\SitessdeplacementObservers', 'deleting')
            ) {

                try {
                    \App\Observers\SitessdeplacementObservers::deleting($model);

                } catch (\Throwable $e) {

                }
            }
        });

        self::deleted(function ($model) {
            if (
                class_exists('\App\Observers\SitessdeplacementObservers') &&
                method_exists('\App\Observers\SitessdeplacementObservers', 'deleted')
            ) {

                try {
                    \App\Observers\SitessdeplacementObservers::deleted($model);

                } catch (\Throwable $e) {

                }
            }
        });
    }

    public function deplacement()
    {
        return $this->belongsTo(Deplacement::class, 'deplacement_id', 'id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function getDeplacementIdAttribute($value)
    {
        return $value;
    }

    public function setDeplacementIdAttribute($value)
    {
        $this->attributes['deplacement_id'] = $value ?? "";
    }

    public function getSiteIdAttribute($value)
    {
        return $value;
    }

    public function setSiteIdAttribute($value)
    {
        $this->attributes['site_id'] = $value ?? "";
    }

    public function getDureesAttribute($value)
    {
        return $value;
    }

    public function setDureesAttribute($value)
    {
        $this->attributes['durees'] = $value ?? "";
    }

    public function getCreatByAttribute($value)
    {
        return $value;
    }

    public function setCreatByAttribute($value)
    {
        $this->attributes['creat_by'] = $value ?? "";
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

