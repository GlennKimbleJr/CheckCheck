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
                    <span data-edit-item data-id="{{ $item->id }}">{{ $item->name }}</span>
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
    });

    $('body').on('click', '[data-edit-item]', function() {
        var $el = $(this);
        var id = $(this).data('id');

        var $input = $('<input/>').val($el.text());
        $el.replaceWith($input);

        var save = function() {
            var input = $.trim($input.val());

            if (! input) {
                var route = '{{ route("checklists.items.destroy", ':id') }}'.replace(':id', id);

                $.ajax({
                    url: route,
                    type: 'DELETE',
                    success: function (data) {
                        $input.closest('div').remove();
                    }
                });

                return;
            }

            var route = '{{ route("checklists.items.update", ':id') }}'.replace(':id', id);

            $.ajax({
                url: route,
                type: 'PUT',
                data: {
                    name: input
                },
                success: function (data) {
                    var $span = $('<span data-edit-item data-id="' + id + '"/>').text(input);

                    $input.replaceWith($span);
                }
            });
        };

        $input.on('blur', save);

        $input.keypress(function(e) {
            if (e.which == 13) {
                save();
            }
        });
    });
</script>
@endsection
