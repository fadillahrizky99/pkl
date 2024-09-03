@extends('dashboard.layouts.main')

@section('container')

<div class="container">
    <div class="row my-3">
        <div class="col-lg-8">
            <h1 class="mb-3">{{ $post->title }}</h1>

            <a href="/dashboard/posts" class="btn btn-success"><span data-feather="arrow-left"></span> Kembali ke Daftar Postingan Ku</a>
            @can('admin')
                <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-warning"><span data-feather="edit"></span> Edit</a>  
                <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" onclick="return confirm('Apakah anda yakin?')"><span data-feather="x-circle"></span> Hapus</button>
                </form>  
            @endcan           
              <div style="max-height: 400px; overflow:hidden">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->category->name }}" class="img-fluid mt-3"> 
              </div>
           
            <article class="my-3 fs-6">
                {!! $post->body !!}
            </article>

        </div>
    </div>
</div>
@endsection

