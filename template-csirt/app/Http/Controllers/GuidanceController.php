<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Profil;
use App\Models\Guidance;
use App\Models\Footer;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ImageProperty;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreGuidanceRequest;
use App\Http\Requests\UpdateGuidanceRequest;
use Ramsey\Uuid\Guid\Guid;

class GuidanceController extends Controller
{
    public function index()
    {
        $profileData = Profil::getProfileData();
        return view('dashboard.guidances.index', array_merge([
            'files' => File::latest()->get(),
            'guidances' => Guidance::all(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ], $profileData));
    }

    public function create()
    {
        $profileData = Profil::getProfileData();
        return view('dashboard.guidances.create', array_merge([
            'files' => File::latest()->get(),
            'guidances' => Guidance::all(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ], $profileData));
    }

    public function store(StoreGuidanceRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|unique:guidances,file_name'
            ]);
    
            $fileModel = new Guidance;
    
            if($request->file()) {
                $fileName = $request->file->getClientOriginalName();
                $filePath = $request->file('file')->storeAs('uploads-guidances', $fileName, 'public');
                $fileSize = $request->file->getSize();
                $fileSlug = Str::slug($request->name,'-');
                    
                $fileModel->name = $request->name;
                $fileModel->file_name = $fileName;
                $fileModel->slug = $fileSlug;
                $fileModel->size = $fileSize;
                $fileModel->path = $filePath;
                $fileModel->save();
    
                return redirect('/dashboard/guidances')->with('success', 'File Has been uploaded !');
            }
    }

    public function edit(Guidance $guidance)
    {
        $profileData = Profil::getProfileData();

        return view('dashboard.guidances.edit', array_merge([
            'files' => File::latest()->get(),
            'guidances' => Guidance::all(),
            'guidance' => $guidance,
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get()
        ], $profileData));
    }
    
    public function update(UpdateGuidanceRequest $request, Guidance $guidance)
    {
        $rules = [
            'file' => 'mimes:pdf|unique:guidances, file_name'
        ];

        if($request->name != $guidance->name){
            $rules['name'] = 'required|string|max:255|unique:name';
        }

        $validatedData = $request->validate($rules);

        if($request->file('file')) {
            if($guidance->path){
                Storage::delete($guidance->path);
            }
            $validatedData['file_name'] = $request->file->getClientOriginalName();
            $validatedData['path'] = $request->file('file')->storeAs('uploads-guidances', $validatedData['file_name'], 'public');
            $validatedData['size'] = $request->file->getSize();
            $validatedData['slug'] = Str::slug($request->name,'-');
        }
        Guidance::where('id', $guidance->id)->update($validatedData);
        return redirect('/dashboard/guidances')->with('success', 'Panduan telah diperbarui!');
    }

    public function destroy(Guidance $guidance)
    {
        if($guidance->path) {
            Storage::delete($guidance->path);
         }
         Guidance::destroy($guidance->id);
         return redirect('/dashboard/guidances')->with('success', 'Panduan has been deleted!');
    }

    public function index1 () {
        $profileData = Profil::getProfileData();
        return view('guidance', array_merge([
            "includeHero" => false,
            'posts' => Post::where('published', true)->latest()->get(),
            'files' => File::latest()->get(),
            'guidances' => Guidance::paginate(7),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
            'propertiez' => ImageProperty::where('property', 'Banner')->latest()->get()
        ], $profileData));
    }

}
