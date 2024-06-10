<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\EmailConfiguration;
use Illuminate\Support\Facades\Storage;

class UserSettingsController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'fullName' => 'required|string',
                'emailAddress' => 'required|email',
                'signature' => 'nullable|string',
                'appKey' => 'required|string',
            ]);



            $userId = Auth::id();
            $user = User::find($userId);

            $user->name = $validatedData['fullName'];
            $user->email = $validatedData['emailAddress'];
            $user->signature = $validatedData['signature'];


            $user->save();


            $emailConfig = EmailConfiguration::updateOrCreate(
                ['user_id' => $userId],
                [
                    'mail_username' => $validatedData['emailAddress'],
                    'mail_password' => $validatedData['appKey'],
                    'mail_from_address' => $validatedData['emailAddress'],
                ]
            );

            return response()->json(['message' => 'User data saved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }



    public function getUserData(Request $request)
    {

        $user = Auth::user();


        if ($user) {

            $emailConfig = EmailConfiguration::where('user_id', $user->id)->first();


            $userData = [
                'fullName' => $user->name,
                'emailAddress' => $user->email,
                'signature' => $user->signature,
                'appKey' => $emailConfig ? $emailConfig->mail_password : null
            ];


            return response()->json($userData, 200);
        } else {

            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('uploads', 'public');

        $user = auth()->user();

        if ($user) {

            $user->update(['img_path' => $filePath]);

            return response()->json(['filePath' => $filePath]);
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }

    public function getPhoto(Request $request)
{
    $user = auth()->user();

    if ($user) {
        $photoPath = $user->img_path;
        return response()->json(['photoPath' => $photoPath]);
    } else {
        return response()->json(['error' => 'User not authenticated'], 401);
    }
}

}
