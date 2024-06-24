<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\userModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required|min:5|confirmed',
            'level_id' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048'
        ]);

        if($validator->fails()) return response()->json($validator->errors(), 422);
        
        // Store image
        $image = $request->file('image');
        $imageName = $image->hashName();
        $image->storeAs('public/posts', $imageName);

        $user = userModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
            'image' => $imageName,
        ]);

        if($user) return response()->json([
            'success' => true,
            'user' => $user
        ], 201);

        return response()->json([
            'success' => false
        ], 409);
    }
}
