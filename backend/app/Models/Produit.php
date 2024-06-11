<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Produit extends Model
{


    /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'statut',
        'extra_attributes',
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
    protected $appends = [

    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'produits';
    }

    public function attribut()
    {

        return $this->belongsToMany(Attribut::class, 'produit_attribut');
    }

    public function getStatutAttribute($value)
    {
        return $value;
    }

    public function setStatutAttribute($value)
    {
        $this->attributes['statut'] = $value ?? "";
    }


}

