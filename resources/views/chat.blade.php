@extends('layouts.app')

@section('content')
    <h1 class="mt-5">Chat with AI</h1>

    <!-- Chat Interface -->
    <div class="card mt-3">
        <div class="card-body">
            <!-- Display Chat Messages -->
            <div id="chat-box" class="mb-3">
                @foreach ($chatMessages as $message)
                    <div class="chat-message">
                        <strong>{{ $message['role'] }}:</strong>
                        <p>{{ $message['content'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Chat Input Form -->
            <form method="POST" action="{{ route('generateResponse') }}">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" id="query" name="query" rows="3" placeholder="Ask a question..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
@endsection
