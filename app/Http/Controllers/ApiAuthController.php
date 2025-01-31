<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Parser\Value;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:255',
            "email" => 'required|email|max:255|unique:users,email',
            "password" => "required|min:8|confirmed"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 301);
        }

        // Generate a random 7-digit code
        $plainCode = mt_rand(1000000, 9999999); // 7-digit random code

        // Hash the code
        $hashedCode = Hash::make($plainCode);

        // Hash the password
        $password = Hash::make($request->password);
        $access_token = Str::random(64);

        // Create user with hashed code
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $password,
            "access_token" => $access_token,
            "code" => $hashedCode // Store the hashed code
        ]);

        // Return response with the plain code
        return response()->json([
            "success" => "You registered successfully",
            "access_token" => $access_token,
            "code" => $plainCode // Return the plain code
        ], 201);
    }

    public function login(Request $request)
     {
      $validator =  Validator::make($request->all(),[
        "email"=>'required|email|max:255',
        "password"=>"required|min:8"
        ]);
        if($validator->fails()){
        return response()->json([
        "errors"=>$validator->errors()
        ],300);
        }
    // check (email , password)
         $user = User::where("email","=",$request->email)->first();
        if($user !== null){
             $oldpassword = $user->password;
             $access_token=Str::random(64);
        // hashed
          $isverified = Hash::check($request->password,$oldpassword);
         if($isverified)
        {
          $user->update([
            "access_token"=>$access_token
          ]);
            return response()->json([
            "msg"=>"you loged in succesfuly",
            "access_token"=>$access_token
             ],200);

            }else{
            return response()->json([
                "msg"=>"credintials not correct"
            ],404);
            }
         }else{
             return response()->json([
            "msg"=>"this account not exit"
          ],404);
         }

     }

     public function logout(Request $request)
     {
        $access_token = $request->header("access_token");
        if($access_token !== null){
             $user =User::where("access_token","=",$access_token)->first();
           if($user !==null){
               $user->update([
                "access_token"=>null
               ]);
               return response()->json([
              "msg"=>"you logged out successfuly"
              ],200);
           }else{
            return response()->json([
                "msg"=>"access token not correct"
              ],404);
           }

        }else{
            return response()->json([
                "msg"=>"access token not found"
              ],404);
        }
        // access_token
        // founded
        // update access_token
     }
     public function updatePassword(Request $request)
     {
         // Validate the request inputs
         $validator = Validator::make($request->all(), [
             "name" => 'required|string|max:255',
             "email" => 'required|email|max:255',
             "code" => 'required|numeric|digits:7',
             "new_password" => "required|min:8|confirmed"
         ]);

         if ($validator->fails()) {
             return response()->json([
                 "errors" => $validator->errors()
             ], 400);
         }

         // Check if the user with the provided email exists
         $user = User::where("email", $request->email)->first();

         if ($user && $user->name === $request->name) {
             // Verify the code using Hash::check
             if (Hash::check($request->code, $user->code)) {
                 // Hash the new password and update it
                 $user->update([
                     "password" => Hash::make($request->new_password),
                 ]);

                 return response()->json([
                     "success" => "Password updated successfully"
                 ], 200);
             } else {
                 return response()->json([
                     "msg" => "Incorrect code"
                 ], 404);
             }
         } else {
             return response()->json([
                 "msg" => "User not found or incorrect credentials"
             ], 404);
         }
     }


    }

