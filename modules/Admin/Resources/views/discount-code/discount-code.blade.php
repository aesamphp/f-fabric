@section('page_title', 'Discount Code #' . $discountCode->code)
@section('page_class', 'admin-promotions sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')

            <form class="col s12" method="POST" action="{{ Request::url() }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="code" type="text" class="validate" value="{{ $discountCode->code }}" disabled />
                        <label for="code">Code</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="min_value" type="text" name="min_value" class="validate" value="{{ $discountCode->min_value }}" />
                        <label for="min_value">Minimum Value</label>
                    </div>
                    <div class="input-radio col s12">
                        <label class="heading">Date Limit</label>
                        <input class="with-gap" name="date_limit_id" type="radio" id="date-limit-1" value="1"@if ($discountCode->date_limit_id == 1) checked @endif />
                        <label for="date-limit-1">Limited</label>
                        <input class="with-gap" name="date_limit_id" type="radio" id="date-limit-2" value="2"@if ($discountCode->date_limit_id == 2) checked @endif />
                        <label for="date-limit-2">Unlimited</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="from_date" type="date" name="from_date" value="{{ ($discountCode->from_date) ? formatDate($discountCode->from_date, 'd-m-Y') : null }}" class="datepicker" placeholder="From Date" />
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="to_date" type="date" name="to_date" value="{{ ($discountCode->to_date) ? formatDate($discountCode->to_date, 'd-m-Y') : null }}" class="datepicker" placeholder="To Date" />
                    </div>
                    <div class="col s12 no-padding">
                        <div class="input-radio col s12 m6">
                            <label class="heading">Value Type</label>
                            <input class="with-gap" name="value_type_id" type="radio" id="value-type-1" value="1"@if ($discountCode->value_type_id == 1) checked @endif />
                            <label for="value-type-1">Amount</label>
                            <input class="with-gap" name="value_type_id" type="radio" id="value-type-2" value="2"@if ($discountCode->value_type_id == 2) checked @endif />
                            <label for="value-type-2">Percentage</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="value" type="text" name="value" class="validate" value="{{ $discountCode->value }}" />
                            <label for="value">Value</label>
                        </div>
                    </div>
                    <div class="col s12 no-padding discount-quantity-rules">
                        <div class="input-field label-field col s12">
                            <label>Quantity Rules</label>
                            <a class="btn-add" href="#" title="Add"><i class="material-icons teal-icon">add</i></a>
                        </div>
                        @if ($discountCode->hasQuantityRules())
                            @foreach ($discountCode->quantity as $key => $quantityRule)
                            <div class="input-field quantity-rule col s12">
                                <div class="input-field col s7">
                                    <input id="rule-quantity-{{ $key + 1 }}" type="text" name="quantity[{{ $key }}][quantity]" class="validate" value="{{ $quantityRule->quantity }}" />
                                    <label for="rule-quantity-{{ $key + 1 }}">Quantity</label>
                                </div>
                                <div class="input-field col s3">
                                    <input id="rule-value-{{ $key + 1 }}" type="tel" name="quantity[{{ $key }}][value]" class="validate" value="{{ $quantityRule->value }}" />
                                    <label for="rule-value-{{ $key + 1 }}">Value</label>
                                </div>
                                <div class="col s2">
                                    <a class="btn-remove" href="#" title="Remove"><i class="material-icons material-icon-close teal-icon">add</i></a>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.discount.codes') }}">Cancel</a>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop