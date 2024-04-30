<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    
    // public function edit()
    // {
    //     $addresses = auth()->user()->addresses;

    //     return view('profile', compact('addresses'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'address' => 'required|string|max:255',
    //     ]);

    //     $address = new Address([
    //         'address' => $request->input('address'),
    //     ]);

    //     $address->user()->associate(auth()->user());
    //     $address->save();

    //     return redirect()->back()->with('success', 'Address added successfully.');
    // }
    public function update(Request $request, $id)
    {
        // $request->address()->fill($request->validated());

        // $request->address()->update($request->only('address'));

        // $request->address()->save();

        // return Redirect::route('profile.edit')->with('success', 'Address updated successfully.');

        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $address = Address::findOrFail($id);

        $address->address = $request->input('address');
        // echo $request->input('address');
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

    // public function destroy(Address $address)
    // {
    //     $address->delete();

    //     return redirect()->route('addresses.index')->with('success', 'Address deleted successfully.');
    // }
}
