<form class="col s12" method="POST" action="{{ Request::url() }}">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="row">
        <div class="input-field col s12 m6">
            <input id="title" type="text" name="title" class="validate" value="{{ $zone->title }}" />
            <label for="title">Title</label>
        </div>
        <div class="input-field col s12">
            <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
            <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.shipping.zones') }}">Cancel</a>
        </div>
    </div>
</form>