<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Equipement;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use App\Models\CategoryLogement;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        $users = User::all();

        $users->map(function ($user) {
            $user->role = $user->getRoleNames()->first();
        });

        return view('admin.users', compact('users'));
    }

    public function usersEdit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userRole = $user->roles->first();

        return view('admin.users-edit', compact('user', 'roles', 'userRole'));
    }

    public function usersUpdate(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|string|exists:roles,name',
        ]);

        if ($request->hasFile('profile_photo_path')) {
            if ($user->profile_photo_path) {
                Storage::delete($user->profile_photo_path);
            }

            $path = $request->file('profile_photo_path')->store('profile_photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->syncRoles([$request->input('role')]);

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function deleteProfilePhoto($id)
    {
        $user = User::find($id);

        if ($user && $user->profile_photo_path) {
            Storage::delete($user->profile_photo_path);
            $user->profile_photo_path = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Photo de profil supprimée avec succès.');
    }

    public function userDelete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.users');
    }

    public function listingLogements()
    {
        $logements = Logement::all();

        return view('admin.logements', compact('logements'));
    }

    public function createLogement()
    {
        return view('admin.logement-create');
    }

    public function storeLogement(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'capacity' => 'required|integer',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pet_allowed' => 'nullable|string',
            'smoker_allowed' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'rating' => 'nullable|integer',
        ]);

        $logement = new Logement($validatedData);
        $logement->user_id = auth()->id();
        $logement->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageSize = getimagesize($image);
            $imageType = $imageSize['mime'];

            if (!in_array($imageType, ['image/jpeg', 'image/png', 'image/gif'])) {
                return redirect()
                    ->back()
                    ->withErrors(['image' => 'Le format de l\'image doit être jpeg, png, jpg, gif.']);
            }

            if ($image->getSize() > 2048 * 1024) {
                return redirect()
                    ->back()
                    ->withErrors(['image' => 'L\'image est trop volumineuse. La taille maximale est de 2 Mo.']);
            }

            $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $logement->image_url = 'storage/images/' . $filename;

            $logement->save();
        }

        return redirect()->route('admin.logements.index')->with('success', 'Logement créé avec succès.');
    }

    public function editLogement($id)
    {
        $logement = Logement::find($id);

        return view('admin.logement-edit', compact('logement'));
    }

    public function logementUpdate(Request $request, $id)
    {
        $logement = Logement::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|nullable',
            'description' => 'required|string|nullable',
            'price' => 'required|integer|nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'capacity' => 'required|integer|nullable',
            'bedrooms' => 'required|integer|nullable',
            'bathrooms' => 'required|integer|nullable',
            'pet_allowed' => 'nullable|string',
            'smoker_allowed' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
        ]);

        $logement->title = $request->input('title');
        $logement->short_description = $request->input('short_description');
        $logement->description = $request->input('description');
        $logement->price = $request->input('price');
        $logement->capacity = $request->input('capacity');
        $logement->bedrooms = $request->input('bedrooms');
        $logement->bathrooms = $request->input('bathrooms');
        $logement->pet_allowed = $request->input('pet_allowed');
        $logement->smoker_allowed = $request->input('smoker_allowed');
        $logement->city = $request->input('city');
        $logement->country = $request->input('country');
        $logement->street = $request->input('street');
        $logement->postal_code = $request->input('postal_code');

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imageSize = getimagesize($image);
            $imageType = $imageSize['mime'];

            if (!in_array($imageType, ['image/jpeg', 'image/png', 'image/gif'])) {
                return redirect()
                    ->back()
                    ->withErrors(['image' => 'Le format de l\'image doit être jpeg, png, jpg, gif.']);
            }

            if ($image->getSize() > 2048 * 1024) {
                return redirect()
                    ->back()
                    ->withErrors(['image' => 'L\'image est trop volumineuse. La taille maximale est de 2 Mo.']);
            }

            $filename = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $filename);
            $logement->image_url = 'storage/images/' . $filename;
        }

        $logement->save();

        return redirect()->route('admin.logements.index')->with('success', 'Logement mis à jour avec succès.');
    }

    public function destroyLogement($id)
    {
        $logement = Logement::find($id);

        if ($logement) {
            $logement->delete();
        }

        return redirect()->route('admin.logements.index')->with('success', 'Logement supprimé avec succès.');
    }

    public function listingHotes()
    {
        $users = User::whereHas('logements')->with('logements')->get();

        return view('admin.hotes', compact('users'));
    }

    public function manageEquipements()
    {
        return view('admin.equipements.index');
    }
}
