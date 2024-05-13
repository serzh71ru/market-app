<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => 'required|string|max:255',
        ]);
        $address = Address::findOrFail($id);
        $address->address = $request->input('address');
        $address->save();

        return redirect()->route('profile.edit')->with('success', 'Address updated successfully.');
    }
    public function show(Request $request)
    {
        $user = auth()->user();
        $addresses = $user->addresses;

        return redirect()->route('profile.edit', $request->user()->id);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $address = $user->addresses()->create($validatedData);

        return redirect()->route('profile.edit')->with('success', 'Address created successfully.');
    }

    public function destroy(Address $address, Request $request)
    {
        $address->delete();

        return redirect()->route('profile.edit', $request->user()->id);
    }
}
