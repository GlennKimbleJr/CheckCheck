@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <h1>{{ $checklist->name }}</h1>

              @foreach ($checklist->items as $item)
                <div
                    @if ($item->isCompleted())
                        class="completed"
                    @endif
                >
                    <input class="toggleComplete" type="checkbox" data-id="{{ $item->id }}"
                        @if ($item->isCompleted())
                            checked
                        @endif
                    >
                    {{ $item->name }}
                </div>
              @endforeach

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
@endsection

@section('scripts')
<script>
    $('.toggleComplete').on('click', function() {
        var id = $(this).data('id');

        var route = '{{ route("checklists.items.complete.toggle", ':id') }}'.replace(':id', id);

        var $item = $(this).closest('div');

        $.ajax({
            url: route,
            type: 'PUT',
            success: function (data) {
                $item.toggleClass('completed')
            }
        });
    })
</script>
@endsection
