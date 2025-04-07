@extends('app')

@section('content')

@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
    <h1 class="mt-5">Post a Document</h1>

    <!-- Form to post a document -->
    <form method="POST" action="{{ route('document.store') }}">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter document title" required>
        </div>
        <div class="form-group">
            <label for="title">Group</label>
            <input type="text" class="form-control" id="group" name="group" placeholder="Group" required> 
            
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" id="content" name="content" rows="4" placeholder="Enter document content" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
