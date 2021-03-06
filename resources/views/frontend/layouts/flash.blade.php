@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show pl-4 pr-0" role="alert">
        @foreach ($errors->all() as $error)
            <div class="my-3">
                {{ $error }}
            </div>
            <button type="button" class="close pt-2" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        @endforeach
    </div>
@endif