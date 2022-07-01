<form class="col s12" method="POST" action="{{ Request::url() }}">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="row">
        <div class="input-field col s12 m6">
            <input id="price" type="text" name="price" class="validate" value="{{ $productMaterial->price }}" />
            <label for="price">Price</label>
        </div>
        <div class="input-field col s12">
            <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
            <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.product', ['id' => $productMaterial->product_id]) }}">Cancel</a>
        </div>
    </div>
</form>