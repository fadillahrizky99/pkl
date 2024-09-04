<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use App\Models\Service;
use Illuminate\Support\Str;
use App\Models\ImageProperty;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Footer;
use App\Models\Category;
use App\Models\Post;
use App\Models\File;
use App\Models\Key;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $profileData = Profil::getProfileData();
        return view('dashboard.services.index', array_merge([
            'services' => Service::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ], $profileData));
    }

    public function create()
    {
        $profileData = Profil::getProfileData();
        return view('dashboard.services.create', array_merge([
            'services' => Service::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ], $profileData));
    }

    public function store(StoreServiceRequest $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'content' => 'required'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name'],'-');
        Service::create($validatedData);
        return redirect('/dashboard/services')->with('success', 'Layanan baru telah ditambah!');
    }

    public function show(Service $service)
    {
        $profileData = Profil::getProfileData();
        return view('dashboard.services.show', array_merge([
            'service' => $service,
            'services' => Service::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ], $profileData));
    }

    public function edit(Service $service)
    {
        $profileData = Profil::getProfileData();
        return view('dashboard.services.edit', array_merge([
            'service' => $service,
            'services' => Service::latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ], $profileData));
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'content' => 'required'
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name'],'-');
        Service::where('id', $service->id)->update($validatedData);
        return redirect('/dashboard/services')->with('success', 'Layanan telah diperbarui!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect('/dashboard/services')->with('success', 'Layanan telah dihapus!');
    }

    public function index1 ()
    {
        $profileData = Profil::getProfileData();
        return view('service', array_merge([
            "includeHero" => false,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
            'propertiez' => ImageProperty::where('property', 'Banner')->latest()->get(),
            'services' => Service::latest()->get()
        ], $profileData));
    }
}
