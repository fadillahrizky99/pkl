@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">File Public Key</h1>
    </div>

    @if (session()->has('success'))
      <div class="alert alert-success col-lg-8" role="alert">
        {{ session('success') }}
      </div> 
    @endif

    <div class="table-responsive col-lg-8">
      <a href="/dashboard/keys/create" class="btn btn-primary mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload">Unggah Public Key</a>
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">No. </th>
              <th scope="col">Nama</th>
              <th scope="col">Lokasi File</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($keys as $key)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $key->name }}</td>
                <td>{{ $key->path }}</td>
                <td>
                  <form action="/dashboard/keys/{{ $key->name }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><span data-feather="x-circle"></span> DELETE</button>
                  </form>
                </td>
              </tr>    
              @endforeach
          </tbody>
        </table>
      </div>
@endsection