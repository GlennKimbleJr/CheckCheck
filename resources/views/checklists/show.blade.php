@extends('layout.app')

<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <h1>{{ $checklist->name }}</h1>
            <ul>
              @foreach ($checklist->items as $item)
                <li>{{ $item->name }}</li>
              @endforeach
            </ul>
        </div>


        <div class="col-8 offset-2">
            <hr>
            <form action="{{ route('checklists.items.store', $checklist) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                </div>

                <button class="btn btn-success">Add Item</button>
            </form>
        </div>
    </div>
</div>
