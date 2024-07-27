<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the user profile page.
     *
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('profile.show');
    }

    /**
     * Show the user profile settings page.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }
}
