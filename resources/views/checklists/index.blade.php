@extends('layout.app')

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
            <a href="{{ route('checklists.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
</div>
