@if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors as $error)
                <li>{{ $error[0] }}</li>
            @endforeach
        </ul>
    </div>
@endif