<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if (!$user) {
            return redirect()->route('login')->withErrors('You need to log in.');
        }
    
        return view('dashboard', [
            'user' => $user,
            'addresses' => $user->addresses 
        ]);
    }
    


    public function updateProfile(Request $request)
    {
        $request->validate([
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
        ]);

        $profile = UserProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            ['father_name' => $request->father_name, 'mother_name' => $request->mother_name]
        );

        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function listAddresses()
    {
        $addresses = Auth::user()->addresses;
        return response()->json($addresses);
    }

    public function addAddress(Request $request)
    {
        $request->validate([
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'pincode' => 'required|string',
        ]);

        Auth::user()->addresses()->create($request->all());

        return response()->json(['message' => 'Address added successfully']);
    }

    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'pincode' => 'required|string',
        ]);

        $address = UserAddress::findOrFail($id);
        $address->update($request->all());

        return view('dashboard');
        }
}
