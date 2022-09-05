@if ($message = session()->pull('message'))
    <div class="alert alert-{{ ($type = session()->pull('type')) ?? 'success' }} alert-dismissible fade show"
        role="alert">
        <strong class="d-flex align-items-center"> <i class="fe fe-{{ $type ? 'slash' : 'check-circle' }}"></i>
            {!! $message !!}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
    </div>
@endif

{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}
