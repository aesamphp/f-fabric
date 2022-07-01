<form class="col s12" method="POST" action="{{ Request::url() }}">
    {{ csrf_field() }}
    {{ method_field('PATCH') }}
    <div class="row">
        <div class="input-field col s12 m6">
            <select id="category_id" name="category_id" class="material-select">
                <option value="" disabled>Choose your option</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}"@if ($category->id === $product->category_id) selected @endif>{{ $category->title }}</option>
                @endforeach
            </select>
            <label for="category_id">Category</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="title" type="text" name="title" class="validate" value="{{ $product->title }}" />
            <label for="title">Title</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="sku" type="text" name="sku" class="validate" value="{{ $product->sku }}" />
            <label for="sku">SKU</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="width" type="text" name="width" class="validate" value="{{ $product->width }}" />
            <label for="width">Width</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="width_text" type="text" name="width_text" class="validate" value="{{ $product->width_text }}" />
            <label for="width_text">Width Text</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="height" type="text" name="height" class="validate" value="{{ $product->height }}" />
            <label for="height">Height</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="height_text" type="text" name="height_text" class="validate" value="{{ $product->height_text }}" />
            <label for="height_text">Height Text</label>
        </div>
        <div class="input-field col s12 m6">
            <input id="weight" type="text" name="weight" class="validate" value="{{ $product->weight }}" />
            <label for="weight">Weight</label>
        </div>
        <div class="input-field col s12">
            <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
            <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.products') }}">Cancel</a>
        </div>
    </div>
</form>