@extends('layout.app')

<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <h1>Add Checklist</h1>

            <form action="{{ route('checklists.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                </div>

                <button class="btn btn-block btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
