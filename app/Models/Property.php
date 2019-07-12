<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;
    
    protected $table = 'properties';

    public $timestamps = true;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 
                            'description', 
                            'cost_of_building', 
                            'cost', 
                            'market_value', 
                            'forced_sale_value', 
                            'return_on_investment', 
                            'property_type_id', 
                            'publisher_id', 
                            'sponsor'];
                            
     /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
