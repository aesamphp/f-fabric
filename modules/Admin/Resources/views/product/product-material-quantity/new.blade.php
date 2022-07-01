@section('page_title', 'Add Product Material Quantity')
@section('page_class', 'admin-catalog sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')
            
            <form class="col s12" method="POST" action="{{ Request::url() }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select id="product_quantity_id" name="product_quantity_id" class="material-select auto-select" data-value="{{ old('product_quantity_id') }}">
                            <option value="" disabled>Choose your option</option>
                            @foreach ($quantities as $quantity)
                            <option value="{{ $quantity->id }}">{{ $quantity->getTitle() }}</option>
                            @endforeach
                        </select>
                        <label for="product_quantity_id">Product Quantity</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="price" type="text" name="price" class="validate" value="{{ old('price') }}" />
                        <label for="price">Price</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.product.material', ['id' => $productMaterial->product_id, 'materialId' => $productMaterial->material_id]) }}">Cancel</a>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop