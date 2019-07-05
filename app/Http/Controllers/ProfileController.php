<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $profile = Auth::guard()->user();

        return view('dashboard.profile', [
            'profile' => $profile
        ]);
    }

    public function update(UpdateProfile $request)
    {
        $user = Auth::guard()->user();
        $user->fill(Arr::only($request->all(), [
            'first_name', 'last_name'
        ]));
        $user->save();

        return redirect()
            ->route('dashboard.profile')
            ->with(['message' => __('Successfully updated')]);
    }

}