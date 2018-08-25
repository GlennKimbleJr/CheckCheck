@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <div class="row">
                <div class="col-10">
                    <h1 data-edit-name>{{ $checklist->name }}</h1>
                </div>

                <div class="col-2 text-right">
                    <button class="btn btn-sm btn-secondary" id="deleteChecklistBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8 offset-2">
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-8 offset-2">
            @forelse ($checklist->items as $item)
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
            @empty
                <i>Add items to your checklist.</i>
            @endforelse
        </div>
    </div>

    <div class="row">
        <div class="col-8 offset-2">
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-8 offset-2">
            <form action="{{ route('checklists.items.store', $checklist) }}" method="POST">
                @csrf

                <div class="form-group row">
                    <div class="col-10">
                        <input type="text" name="name" id="add-item-name" class="form-control" value="{{ old('name') }}" autofocus>
                        <div class="text-danger">{{ $errors->first('name') }}</div>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary">Add Item</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<form action="{{ route('checklists.destroy', $checklist) }}" method="post" id="deleteChecklistForm" class="d-none">
    @csrf
    @method('DELETE')
</form>
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
                $item.toggleClass('completed');

                $('#add-item-name').focus();
            }
        });
    });

    $('body').on('click', '[data-edit-name]', function() {
        var $el = $(this);

        var originalText = $el.text();

        var $input = $('<input/>').val(originalText);
        $el.replaceWith($input);

        var save = function() {
            var input = $.trim($input.val());

            if (! input) {
                input = originalText;
            }

            $.ajax({
                url: '{{ route("checklists.update", $checklist->id) }}',
                type: 'PUT',
                data: {
                    name: input
                },
                success: function (data) {
                    var $span = $('<h1 data-edit-name />').text(input);

                    $input.replaceWith($span);

                    $('#add-item-name').focus();
                }
            });
        };

        $input.on('blur', save).focus();

        $input.keypress(function(e) {
            if (e.which == 13) {
                save();
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

                        $('#add-item-name').focus();
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

                    $('#add-item-name').focus();
                }
            });
        };

        $input.on('blur', save).focus();

        $input.keypress(function(e) {
            if (e.which == 13) {
                save();
            }
        });
    });

    $('#deleteChecklistBtn').on('click', function () {
        if (confirm("Are you sure you want to delete this checklist?")) {
            $('#deleteChecklistForm').submit();
        }
    });
</script>
@endsection
