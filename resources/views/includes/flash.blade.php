<div class="alert-container">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">{!! session('error') !!}</div>
    @elseif (session('status'))
        <div class="alert alert-success">{!! session('status') !!}</div>
    @endif
</div>