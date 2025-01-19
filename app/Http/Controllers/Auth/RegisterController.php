<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
        protected function validator(array $data)
        {
            return Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'gender' => 'required|string|in:male,female,other',
                'field_of_work' => 'required|string|max:255',
                'social_link' => 'required|url',
                'phone_number' => 'required|numeric|digits_between:10,15',
                'coins' => 'required|numeric',
                'registration_fee' => 'required|numeric',
            ]);
        }


        
        protected function create(array $data)
        {
            $registrationFee = (int)$data['registration_fee'];
            $coins = (int)$data['coins'];
        
            if ($coins < $registrationFee) {
                // Underpayment handling
                session()->flash('error', 'You have underpaid. Registration requires ' . $registrationFee . ' coins.');
                return redirect()->back();
            }
        
            $remainingCoins = $coins - $registrationFee;
        
            // Notify the user of overpayment or remaining balance
            if ($remainingCoins > 0) {
                session()->flash('success', 'Registration successful! You have ' . $remainingCoins . ' coins remaining.');
            } else {
                session()->flash('success', 'Registration successful!');
            }
        
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'gender' => $data['gender'],
                'field_of_work' => $data['field_of_work'],
                'social_link' => $data['social_link'],
                'phone_number' => $data['phone_number'],
                'coins' => $remainingCoins, // Save remaining coins
                'isVisible' => true,
                'avatar_id' => null,
            ]);
        }
        
        

    
}
