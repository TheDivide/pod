<?php

namespace App\Http\Controllers;

use Exception;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Models\Property as AppProperty;
use App\Http\Resources\Property as PropertyResource;

class PropertiesController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = AppProperty::all(); //Get all users

        $transform = PropertyResource::collection($properties);

        return $this->successResponse($transform, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'description' => 'required|string',
                'cost_of_building' => 'integer',
                'cost' => 'string',
                'market_value' => 'string',
                'forced_sale_value' => 'string',
                'return_on_investment' => 'string',
                'property_type_id' => 'required|integer',
                'publisher_id' => 'required|integer',
                'sponsor' => 'string',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 400);
            }

            $property = new AppProperty([
                'name' => $request->name,
                'description' => $request->description,
                'cost_of_building' => $request->cost_of_building,
                'cost' => $request->cost,
                'market_value' => $request->market_value,
                'forced_sale_value' => $request->forced_sale_value,
                'return_on_investment' => $request->return_on_investment,
                'property_type_id' => $request->property_type_id,
                'publisher_id' => $request->publisher_id,
                'sponsor' => $request->sponsor,
            ]);

            $property->save();

            // notification here attach resources

            $transform = new PropertyResource($property);

            return $this->showMessage($transform, 201);
        } catch (Exception $e) 
        {
            return $this->errorResponse('Error occured', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $property = AppProperty::findOrFail($id);
            $transform = new PropertyResource($property);

            return $this->successResponse($transform, 200);
        }
        // catch(Exception $e) catch any exception
        catch (ModelNotFoundException $e) {
            return $this->errorResponse('Property not found', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'cost_of_building' => 'integer',
            'cost' => 'string',
            'market_value' => 'string',
            'forced_sale_value' => 'string',
            'return_on_investment' => 'string',
            'property_type_id' => 'required|integer',
            'publisher_id' => 'required|integer',
            'sponsor' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        try {
            $property = AppProperty::findOrFail($id);

            $property->name = $request->input('name');
            $property->description = $request->input('description');
            $property->cost_of_building = $request->input('cost_of_building');
            $property->cost = $request->input('cost');
            $property->market_value = $request->input('market_value');
            $property->forced_sale_value = $request->input('forced_sale_value');
            $property->return_on_investment = $request->input('return_on_investment');
            $property->property_type_id = $request->input('property_type_id');
            $property->publisher_id = $request->input('publisher_id');
            $property->sponsor = $request->input('sponsor');

           

            $property->update();
            $transform = new PropertyResource($property);

            return $this->successResponse($transform, 200);
        }
        catch (ModelNotFoundException $e) 
        {
            return $this->errorResponse('Property could not found', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $property = AppProperty::findOrFail($id);

            $property->delete(); //Delete the property

            return $this->singleMessage('Property Deleted', 201);
        }
        catch (ModelNotFoundException $e) 
        {
            return $this->errorResponse('Property does not exist', 400);
        }
    }
}
