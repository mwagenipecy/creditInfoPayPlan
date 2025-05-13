<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    protected $clientId = '646620969575-nro1e2807043hiiflm1trbmdbj4hbr5r.apps.googleusercontent.com';
    protected $clientSecret = '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';
    protected $redirectUrl = 'http://127.0.0.1:8000/login/google/callback_url';

  
    public function redirectToGoogle()
    {
        // Make sure this matches exactly what's in Google Cloud Console
        $redirectUri = 'http://127.0.0.1:8000/login/google/callback_url';
        
        Log::info('Google OAuth redirect URI: ' . $redirectUri);
        
        config([
            'services.google' => [
                'client_id' => $this->clientId, // env('GOOGLE_CLIENT_ID'),
                'client_secret' => $this->clientSecret, // env('GOOGLE_CLIENT_SECRET'),
                'redirect' => $redirectUri,
            ]
        ]);



        try {
            return Socialite::driver('google')
                ->redirectUrl($redirectUri)
                ->stateless() // Add stateless here too
                ->with([
                    'prompt' => 'select_account',
                    'access_type' => 'offline',
                    'include_granted_scopes' => 'true'
                ])
                ->scopes(['openid', 'profile', 'email'])
                ->redirect();
        } catch (Exception $e) {
            Log::error('Google redirect error: ' . $e->getMessage());
            dd("yes");

            return redirect('/login')->withErrors(['google' => 'Error initiating Google login.']);
        }
    }



  
    public function handleGoogleCallback(Request $request)
    {
        config([
            'services.google' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect' => $this->redirectUrl,
            ]
        ]);

        try {
            // Check for error response from Google
            if ($request->has('error')) {

                dd($request->all());
                return redirect('/login')
                    ->withErrors(['google' => 'Google authentication failed: ' . $request->get('error')]);
            }
            
            $user = Socialite::driver('google')->stateless()->user();
            
            // Check if they're an existing user
            $existingUser = User::where('email', $user->email)->first();
            
            if($existingUser) {
                // User exists, update their google_id if needed
                if (empty($existingUser->google_id)) {
                  //  $existingUser->google_id = $user->id;
                    $existingUser->profile_photo_path = $user->avatar;
                    $existingUser->save();
                }
                
                Auth::login($existingUser);
                return redirect()->intended('/dashboard')->with('success', 'Successfully logged in with Google!');
            } else {
                // Create a new user
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                   // 'role'=>'client',
                  //  'google_id' => $user->id,
                    'profile_photo_path' => $user->avatar,
                    'password' => bcrypt(Str::random(16)),
                ]);
                
                Auth::login($newUser);
                return redirect('/dashboard')->with('success', 'Account successfully created and logged in!');
            }
            
        } catch (Exception $e) {
            // Log the actual error for debugging
            \Log::error('Google login error: ' . $e->getMessage());


            dd($e->getMessage());
            
            return redirect('/login')
                ->withErrors(['google' => 'Something went wrong with Google login. Please try again.']);
        }
    }
}
