<?php

namespace App\Http\Controllers;

use Validator; 
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Notifications\NewUser;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Permission;
use App\Http\Resources\User as UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersController extends Controller
{
    use ApiResponses;

    protected $user;

    public function __construct(Request $request)
    {

        $this->user = $request->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); //Get all users

        $transform = UserResource::collection($users);

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
     * Store a newly created User in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] phone
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'fname' => 'required|string',
                'lname' => 'required|string',
                'phone' => 'required|integer',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed',
                'role' => 'required|string|exists:roles,name',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 400);
            }

            $user = new User([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $user->save();
            $user->assignRole($request->role);

            // Send email creation notification
            // $user->notify(new NewUser($user));

            $transform = new UserResource($user);

            return $this->showMessage($transform, 201);
        } catch (ModelNotFoundException $e) 
        {
            return $this->errorResponse('User not found', 400);
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
            $user = User::findOrFail($id);
            $transform = new UserResource($user);

            return $this->successResponse($transform, 200);
        }
        // catch(Exception $e) catch any exception
        catch (ModelNotFoundException $e) {
            return $this->errorResponse('User not found', 400);
        }
    }
/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { }

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
            'fname' => 'required|string',
            'lname' => 'required|string',
            'phone' => 'required|string',
            'edit_password' => 'required|boolean',
            'email' => 'required|string|email',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        try {
            $user = User::findOrFail($id);
            $user->fname = $request->input('fname');
            $user->lname = $request->input('lname');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');

            if ($request->input('edit_password')) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->role_id = $request->input('role_id');

            $user->save();
            $transform = new UserResource($user);
            return $this->successResponse($transform, 200);
        }
        catch (ModelNotFoundException $e) 
        {
            return $this->errorResponse('User not found', 400);
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
            $user = User::findOrFail($id);
            // DB::table('role_users')->where('user_id', $id)->delete(); //Delete role_user associated

            $user->delete(); //Delete the user
            return $this->singleMessage('User Deleted', 201);
        }
        catch (ModelNotFoundException $e) 
        {
            return $this->errorResponse('User not found', 400);
        }
    }

}
