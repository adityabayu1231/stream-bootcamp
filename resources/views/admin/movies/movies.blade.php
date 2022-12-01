@extends('admin.layouts.base')
@section('title', 'Home Movies')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Movies</h3>
      </div>
    
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <a href="{{ route('admin.movie.create'); }}" class="btn btn-warning my-3">Create Movie</a>
          </div>
        </div>
        @if (session()->has('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
        <div class="row">
          <div class="col-md-12">
            <table id="movie" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Small Thumbnail</th>
                  <th>Large Thumbnail</th>
                  <th>Categories</th>
                  <th>Casts</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($movies as $movie)
                  <tr>
                    <td>{{ $movie['id']; }}</td>
                    <td>{{ $movie['title']; }}</td>
                    <td>
                      <img src="{{ asset('storage/thumbnail/'.$movie['small_thumbnail']) ; }}" alt="" srcset="" width="40%">
                    </td>
                    <td>
                      <img src="{{ asset('storage/thumbnail/'.$movie['large_thumbnail']) ; }}" alt="" srcset="" width="45%">
                    </td>
                    <td>{{ $movie['categories']; }}</td>
                    <td>{{ $movie['casts']; }}</td>
                    <td>
                      <a href="{{ route('admin.movie.edit',$movie->id); }}" class="btn btn-warning mb-2">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form action="{{ route('admin.movie.delete',$movie->id); }}" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger btn-sm" name="delete" onclick="return confirm('Are You Sure?')"><i class="fas fa-trash-alt"></i></button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
  <script>
    $('#movie').DataTable();
  </script>
@endsection