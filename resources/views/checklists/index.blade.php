@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <h1>Checklists</h1>
            @foreach ($checklists as $checklist)
                <div class="card w-50 text-center">
                    <div class="card-body">
                        {{ $checklist->name }}
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('checklists.show', $checklist) }}" class="btn btn-sm btn-primary">
                            View
                        </a>
                    </div>
                </div>
            @endforeach

            <hr>
            <button data-toggle="modal" data-target=".modal" class="btn btn-success">Add Checklist</button>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('checklists.store') }}" method="POST" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Add Checklist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" autofocus>
                    <div class="text-danger">{{ $errors->first('name') }}</div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
