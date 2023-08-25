<?php
namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService {

    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request) {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string'
        ]);

        $user = $this->userRepository->create($data);
        return $user;
    }

    public function signIn(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = ['email' => $data['email'], 'password' => $data['password']];
        if (!$token = JWTAuth::attempt($credentials)) {
            throw new Exception('The provided credentials are incorrect.' , 401);
        }
        return $this->respondWithToken($token);
    }

    public function recoverPassword(Request $request)
    {
        $data = $request->validate(['email' => 'required|string|email']);

        $user = $this->userRepository->getByEmail($data['email']);

        if (!$user) {
            throw new Exception ('User not found.', 404);
        }

        $token = $user->createToken('password_reset')->plainTextToken;

        Mail::send('emails.password_reset', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Password Reset Request');
        });

        return response()->json(['message' => 'Password reset link sent to email.']);
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }


}
