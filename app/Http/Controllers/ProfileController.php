<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->clearMediaCollection('avatar');
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function avatar(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'avatar' => 'required|mimes:png,jpg|image|max:1024'
        ]);
        if($request->hasFile('avatar')){
            if($user->hasMedia('avatar')){
                $user->clearMediaCollection('avatar');
            }
            $user->addMedia($request->avatar)->toMediaCollection('avatar');
            
        }
        return Redirect::route('profile.edit')->with('status', 'avatar-updated');
    }

    public function search(Request $request)
    {
        $users = User::query()
            ->when(
            $request->search,
            function(Builder $builder) use ($request){
                $builder->where('name', 'like', "%{$request->search}%")
                    ->orWhere('username', 'like' , "%{$request->search}%")
                    ->orWhere('email' , 'like', "%{$request->search}%");
            })
            ->simplePaginate(2);
            
        return view('barta.search.profiles', compact('users'));
    }
}
