@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 offset-2 d-flex flex-wrap">
            @foreach ($checklists as $checklist)
                <div class="w-50 p-2">
                    <div class="card w-100 text-center {{ $checklist->isComplete() ? 'bg-dark text-success' : '' }}">
                        <div class="card-header text-right small">
                            @if ($checklist->isComplete())
                                <span class="badge badge-success">COMPLETE</span>
                            @else
                                {{ $checklist->items->completed()->count() }} / {{ $checklist->items->count() }}
                            @endif
                        </div>

                        <div class="card-body">
                            {{ $checklist->name }}
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('checklists.show', $checklist) }}" class="btn btn-sm btn-secondary">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row my-4">
        <div class="col-8 offset-2 text-center border-top pt-3">
            <button data-toggle="modal" data-target=".modal" class="btn btn-sm btn-primary">Add Checklist</button>
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
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
