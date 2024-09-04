<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Post;
use App\Models\User;
use App\Models\Footer;
use App\Models\Profil;
use App\Models\Category;
use App\Models\ImageProperty;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfilController;

class PostController extends Controller
{
    public function index()
    {
        $profileData = Profil::getProfileData();
        $title ='';
        if(request('category')){
            $category = Category::firstWhere('slug', request('category'));
            $title = ' in ' . $category->name;
        }

        if(request('author')){
            $author = User::firstWhere('username', request('author'));
            $title = ' by ' . $author->name;
        }

        return view('posts', array_merge([
            "title" => "Semua Postingan" . $title,
            "active" => 'posts',
            "includeHero" => false,
            'categories' => Category::all(),
            'propertiez'  => ImageProperty::where('property', 'Banner')->latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
            "posts" => Post::where('published', true)->latest()->filter(request(['search', 'category', 'author']))->paginate(5)->withQueryString(),
        ], $profileData));
    }

    public function show(Post $post)
    {   
        $profileData = Profil::getProfileData();
        return view('post', array_merge([
            "title" => "Postingan",
            "active" => 'posts',
            "includeHero" => false,
            'categories' => Category::all(), 
            'propertiez'  => ImageProperty::where('property', 'Banner')->latest()->get(),
            'properties' => ImageProperty::where('property', 'Logo')->latest()->get(),
            "post" => $post,
        ], $profileData));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Post $post)
    // {
    //     //
    // }

    
}
