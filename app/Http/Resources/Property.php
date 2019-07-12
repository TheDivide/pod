<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Property extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'cost_of_building' => $this->cost_of_building,
            'cost' => $this->cost,
            'market_value' => $this->market_value,
            'forced_sale_value' => $this->forced_sale_value,
            'return_on_investment' => $this->return_on_investment,
            'property_type_id' => $this->property_type_id,
            'publisher_id' => $this->publisher_id,
            'sponsor' => $this->sponsor,

            ];
    }
}
