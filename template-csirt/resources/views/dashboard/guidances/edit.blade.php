@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Perbarui Panduan</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/guidances/{{ $guidance->slug }}" class="mb-5" enctype="multipart/form-data">
            @method('put')
            @csrf
            

            <div class="mb-3">
                <label for="name" class="form-label">Nama Panduan</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus value="{{ old('name', $guidance->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" value="{{ old('file', $guidance->name) }}" >
                @error('file')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
    </div>
@endsection


