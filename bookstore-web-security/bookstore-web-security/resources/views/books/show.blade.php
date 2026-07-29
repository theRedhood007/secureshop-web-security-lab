@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $book->title }}</h1>
    <p><strong>Author:</strong> {{ $book->author }}</p>
    <p><strong>Description:</strong> {{ $book->description }}</p>
    <p><strong>Price:</strong> ${{ $book->price }}</p>

    <a href="{{ route('cart.add', $book->id) }}" class="btn btn-primary">Add to Cart</a>
    <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Books</a>
</div>
@endsection