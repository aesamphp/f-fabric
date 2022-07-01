<div class="row single-row">
    <div class="col-xs-0 col-sm-1 js-container-magnific">
        <a href="{{ asset(getPlainFabricImagePath()) }}">
            <div class="body-col image" style="background-image: url('{{ asset(getPlainFabricImagePath()) }}');">
            </div>
        </a>            												
    </div>
    <div class="col-xs-11">
        <div class="row">
            <div class="col-xs-4">
                <div class="body-col first">
                    <div class="col-xs-12">
                        <div class="body-col-textarea">
                            <p class="body-col-textarea__item">{{ $item->product->title }}</p>
                            <p class="body-col-textarea__type">{{ $item->material->title }}</p>
                            <div class="js-container-magnific mobile-only-image">
                                <a href="{{ asset(getPlainFabricImagePath()) }}">
                                    <div class="mobile-only-image__img" style="background-image: url('{{ asset(getPlainFabricImagePath()) }}');"></div>
                                </a>
                                <div class="mobile-only-text">
                                    <p class="body-col-textarea__item">{{ $item->product->title }}</p>
                                    <p class="body-col-textarea__type">{{ $item->material->title }}</p>
                                </div>                                       
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-5 col-sm-3 col-md-4">
                <div class="body-col second">
                    <form class="item-update-form" method="POST" action="{{ route('update.basket.item', ['id' => $item->id]) }}" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <input class="body-col__input field-secondary" type="tel" name="quantity" maxlength="3" value="{{ $item->quantity }}" />
                        <button class="body-col__link" type="submit">Update</button>
                    </form><span class="hidden-xs">|</span>
                    <form class="item-delete-form delete-form" method="POST" action="{{ route('delete.basket.item', ['id' => $item->id]) }}" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="body-col__link" type="submit">Remove</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="body-col third">
                    <p class="body-col__type">{{ $item->category->title }}</p>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="body-col fourth">
                    <p class="body-col__total">{{ $item->formatted_gross_total }}</p>
                </div>
            </div>  
        </div>
    </div>             							
</div>