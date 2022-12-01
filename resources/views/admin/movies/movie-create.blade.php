@extends('admin.layouts.base')
@section('title', 'Create-Movie')
@section('content')
<div class="row">
  <div class="col-md-12">

    {{-- Alert Here --}}
    {{-- @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif --}}
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Create Movie</h3>
      </div>
      <!-- /.card-header -->
      <!-- form start -->
      <form enctype="multipart/form-data" method="POST" action="{{ route('admin.movie.store') }}">
        @csrf
        <div class="card-body">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g Guardian of The Galaxy" autofocus>
            @error('title')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="trailer">Trailer</label>
            <input type="text" class="form-control @error('trailer') is-invalid @enderror" id="trailer" name="trailer" value="{{ old('trailer') }}" placeholder="Video url">
            @error('trailer')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="movie">Movie</label>
            <input type="text" class="form-control @error('movie') is-invalid @enderror" id="movie" name="movie" value="{{ old('movie') }}" placeholder="Video url">
            @error('movie')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="duration">Duration</label>
            <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" placeholder="1h 39m">
            @error('duration')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label>Date:</label>
            <div class="input-group date" id="release-date" data-target-input="nearest">
              {{-- <input type="text" name="release_date" class="form-control datetimepicker-input" data-target="#release-date"/> --}}
              <input type="date" name="release_date" value="{{ old('release_date') }}" class="form-control @error('release_date') is-invalid @enderror"/>
              {{-- <div class="input-group-append" data-target="#release-date" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div> --}}
              @error('release_date')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="form-group">
            <label for="short-about">Casts</label>
            <input type="text" class="form-control @error('casts') is-invalid @enderror" id="casts" name="casts" value="{{ old('casts') }}" placeholder="Jackie Chan">
            @error('casts')
                <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="categories">Categories</label>
            <input type="text" class="form-control @error('categories') is-invalid @enderror" id="categories" name="categories" value="{{ old('categories') }}" placeholder="Action, Fantasy">
            @error('categories')
                <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="small-thumbnail">Small Thumbnail</label>
            <input type="file" class="form-control @error('small_thumbnail') is-invalid @enderror" name="small_thumbnail">
            @error('small_thumbnail')
                <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="large-thumbnail">Large Thumbnail</label>
            <input type="file" class="form-control @error('large_thumbnail') is-invalid @enderror" name="large_thumbnail">
            @error('large_thumbnail')
                <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="short-about">Short About</label>
            <input type="text" class="form-control @error('short_about') is-invalid @enderror" id="short-about" name="short_about" value="{{ old('short_about') }}" placeholder="Awesome Movie">
            @error('short_about')
                <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="about">About</label>
            <input type="text" class="form-control @error('about') is-invalid @enderror" id="about" name="about" value="{{ old('about') }}" placeholder="Awesome Movie">
            @error('about')
                <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label>Featured</label>
            <select class="custom-select" name="featured">
              <option value="0" {{ old('featured') == '0' ? 'selected' : '' }}>No</option>
              <option value="1" {{ old('featured') == '1' ? 'selected' : '' }}>Yes</option>
            </select>
          </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
  <script>
    // $('#release_date').datetimepicker({
    //   format: 'YYYY-MM-DD'
    // });
    console.log('Hello World');
  </script>
@endsection