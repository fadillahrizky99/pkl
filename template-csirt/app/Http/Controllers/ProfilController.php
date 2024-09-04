<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Requests\StoreProfilRequest;
use App\Http\Requests\UpdateProfilRequest;
use App\Models\Footer;
use App\Models\Profil;
use App\Models\Category;
use App\Models\File;
use App\Models\Key;
use App\Models\ImageProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function create()
    {
        return view('dashboard.profils.create', [
            'profils' => Profil::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    public function store(StoreProfilRequest $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'content' => 'required',
            'link' => 'required'
        ]);

        $validatedData['value'] = Str::value($validatedData['name'],'-');
        Profil::create($validatedData);
        return redirect('/dashboard/profils')->with('success', 'New Profile has been added!');
    }

    public function show(Profil $profil)
    {
        return view('dashboard.profils.show', [
            'profils' => Profil::latest()->get(),
            'profil' => $profil,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ]);
    }

    public function index(Profil $profil)
    {
        $profileData = Profil::getProfileData();
        return view('dashboard.profils.edit', array_merge([
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
        ], $profileData));
    }

    public function destroy(Profil $profil)
    {
        $profil->delete();

        return redirect('/dashboard/profils')->with('success', 'Profile has been deleted!');
    }

    public function index1() {
        $profileData = Profil::getProfileData();
        return view('profil', array_merge([
            "includeHero" => false,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
            'propertiez' => ImageProperty::where('property', 'Banner')->latest()->get(),
            'gambar' => ImageProperty::where('property', 'Profil')->latest()->get()
        ], $profileData));
    }

    public function editLatest()
    {
        $profileData = Profil::getProfileData();
    
        return view('dashboard.profils.edit', array_merge([
            'includeHero' => false,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
            'propertiez' => ImageProperty::where('property', 'Banner')->latest()->get()
        ], $profileData));
    }
    
    public function update(Request $request, $name)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'telp' => 'required|max:255',
            'email' => 'required|max:255',
            'maps' => 'required|max:255',
            'fb' => 'required|max:255',
            'ig' => 'required|max:255',
            'instance1' => 'required|max:255',
            'instance2' => 'required|max:255',
            'instance3' => 'required|max:255',
            'deskripsi_home' => 'required|max:1000',
            'deskripsi_profil' => 'required|max:1000',
        ]);
    
        foreach ($validatedData as $key => $value) {
            $option = Profil::where('name', $key)->first();
            if ($option) {
                $option->value = $value;
                $option->touch(); // This will update the updated_at timestamp
                $option->save();
            }
        }
    
        return redirect('/dashboard/profils')->with('success', 'Profil berhasil diubah!');
    }
}

// public function update(UpdateImagePropertyRequest $request, ImageProperty $property)
// {
//     $rules = [
//         'property' => 'required|max:255',
//         'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
//     ];

//     if($request->name != $property->name){
//         $rules['name'] = 'required|max:255|unique:image_properties';
//     }

//     $validatedData = $request->validate($rules);

//     if($request->file('image')) {
//         if($property->image){
//             Storage::delete($property->image);
//         }
//         $validatedData['image'] = $request->file('image')->store('image-property');
//     }

//     $validatedData['slug'] = Str::slug($request->name,'-');

//     ImageProperty::where('id', $property->id)->update($validatedData);

//     return redirect('/dashboard/properties')->with('success', 'Property has been updated!');
// }