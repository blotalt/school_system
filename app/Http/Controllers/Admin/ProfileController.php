<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('admin.profile', ['user' => $request->user()]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());
        $request->user()->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated.');
    }
}
