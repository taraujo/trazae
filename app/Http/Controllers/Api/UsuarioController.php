<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UsuarioRequest;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioRequest $request)
    {
        try {
            $data = $request->only([
                "name",
                "email",
                "password"
            ]);

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            return response()->json($user);
        } catch (Exception $exception) {
            Log::info($exception->getMessage() . $exception->getTraceAsString());
            return response()->json($exception->getMessage(), 400);
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
            $user = User::find($id);

            if (!isset($user)) {
                return response()->json(["error" => "Data not found"], 400);
            }

            return response()->json($user);

        } catch (Exception $exception) {
            Log::info($exception->getMessage() . $exception->getTraceAsString());
            return response()->json($exception->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioRequest $request)
    {
        try {
            $id = $request->get('id');

            $data = $request->only([
                "name",
                "email",
                "password"
            ]);

            $data['password'] = Hash::make($data['password']);

            $user = User::find($id);
            if (!isset($user)) {
                return response()->json(["error" => "Data not found"], 400);
            }

            $user->update($data);

            return response()->json($user);
        } catch (Exception $exception) {
            Log::info($exception->getMessage() . $exception->getTraceAsString());
            return response()->json($exception->getMessage(), 400);
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
            $user = User::find($id);
            if (!isset($user)) {
                return response()->json(["error" => "Data not found"], 400);
            }
            $user->delete();

            return response()->json([ "message" => "Data was deleted!" ]);
        } catch (Exception $exception) {
            Log::info($exception->getMessage() . $exception->getTraceAsString());
            return response()->json($exception->getMessage(), 400);
        }
    }
}
