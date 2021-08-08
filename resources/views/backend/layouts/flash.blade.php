@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}
            <button type="button" class="close pt-2" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        @endforeach
    </div>
@endif