<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'locale' => 'required|in:' . implode(',', array_keys(config('app.available_locales'))),
        ]);

        $request->session()->put('locale', $validated['locale']);

        if ($request->user()) {
            $request->user()->update(['locale' => $validated['locale']]);
        }

        return redirect()->back();
    }
}
