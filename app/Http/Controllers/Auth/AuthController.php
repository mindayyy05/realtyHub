<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;



class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        return rescue(function () use ($request) {
            // Validate the request data
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'phoneNumber' => 'required|string',
                'password' => 'required|string',
                'profile_image' => 'nullable|image|max:2048', // Validate image
                'user_role' => 'required|integer|in:0,1,2', // Validate user_role
            ]);

            $profilePhotoPath = null;
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');


                $filename = 'uploads/profilephotos/' . time() . '.jpg';


                $profilePhotoPath = $file->storeAs('', $filename, 'public');
            }

            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phoneNumber' => $request->phoneNumber,
                'password' => bcrypt($request->password),
                'profile_photo_path' => $profilePhotoPath,
                'user_role' => $request->user_role,
            ]);

            // Return the response
            return response()->json([
                'status' => 'true',
                'payload' => $user,
            ], 200);
        }, function (Exception $exception) {
            // Handle exceptions
            return response()->json([
                'message' => $exception->getMessage()
            ], 500);
        });
    }


    public function LoginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'token' => 'required|string',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $token = $request->input('token');

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {

            $sanctumToken = $user->createToken('login-token')->plainTextToken;


            DB::table('personal_access_tokens')->insert([
                'tokenable_type' => User::class,
                'tokenable_id' => $user->id,
                'name' => 'flutter-token',
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'sanctum_token' => $sanctumToken,
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
    }





    public function LoginAdmin(Request $request)
    {
       
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

      
        $user = User::where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
           
            if ($user->user_role == 0) {
               
                Auth::login($user);
                return redirect()->route('dashboard'); 
            } else {
                
                return back()->withErrors([
                    'error' => 'Only admins can log in.',
                ]);
            }
        } else {
           
            return back()->withErrors([
                'error' => 'Invalid email or password.',
            ]);
        }
    }

    public function destroy($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Delete the user
        $user->delete();

        // Optionally, you can recalculate the total users here
        $totalUsers = User::count();

        // Redirect back to the dashboard with the updated total users
        return redirect()->route('dashboard')->with('totalUsers', $totalUsers)->with('success', 'User deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->phoneNumber = $request->phoneNumber;
        $user->email = $request->email;
        $user->save();

        return response()->json(['success' => true]);
    }
}
