@section('page_title', 'Add Discount Code')
@section('page_class', 'admin-promotions sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')

            <form class="col s12" method="POST" action="{{ Request::url() }}" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div>The prefix to the discount code e.g FF so the codes will look like FF-001, FF-002, FF-003...</div>
                    <div class="input-field col s12">
                        <input id="prefix" type="text" name="prefix" class="validate" value="{{ old('prefix') }}" />
                        <label for="prefix">Prefix</label>
                    </div>

                    <div>Enter how many codes you want created, the maximum is 500.</div>
                    <div class="input-field col s12">
                        <input id="quantity" type="number" name="quantity" class="validate" value="{{ old('quantity') }}" />
                        <label for="quantity">Quantity</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <input id="min_value" type="text" name="min_value" class="validate" value="{{ old('min_value') }}" />
                        <label for="min_value">Minimum Value</label>
                    </div>
                    <div class="col s12 no-padding">
                        <div class="input-radio col s12 m6">
                            <label class="heading">Use Type</label>
                            <input class="with-gap" name="use_limit_id" type="radio" id="use-limit-1" value="1"@if (old('use_limit_id') == 1) checked @endif />
                            <label for="use-limit-1">Single</label>
                            <input class="with-gap" name="use_limit_id" type="radio" id="use-limit-2" value="2"@if (old('use_limit_id') == 2) checked @endif />
                            <label for="use-limit-2">Multiple</label>
                            <input class="with-gap" name="use_limit_id" type="radio" id="use-limit-3" value="3"@if (old('use_limit_id') == 3) checked @endif />
                            <label for="use-limit-3">Unlimited</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="use_limit" type="text" name="use_limit" class="validate" value="{{ old('use_limit') }}" />
                            <label for="use_limit">Use Limit</label>
                        </div>
                    </div>
                    <div class="input-radio col s12">
                        <label class="heading">Date Limit</label>
                        <input class="with-gap" name="date_limit_id" type="radio" id="date-limit-1" value="1"@if (old('date_limit_id') == 1) checked @endif />
                        <label for="date-limit-1">Limited</label>
                        <input class="with-gap" name="date_limit_id" type="radio" id="date-limit-2" value="2"@if (old('date_limit_id') == 2) checked @endif />
                        <label for="date-limit-2">Unlimited</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="from_date" type="date" name="from_date" value="{{ old('from_date') }}" class="datepicker" placeholder="From Date" />
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="to_date" type="date" name="to_date" value="{{ old('to_date') }}" class="datepicker" placeholder="To Date" />
                    </div>
                    <div class="col s12 no-padding">
                        <div class="input-radio col s12 m6">
                            <label class="heading">Value Type</label>
                            <input class="with-gap" name="value_type_id" type="radio" id="value-type-1" value="1"@if (old('value_type_id') == 1) checked @endif />
                            <label for="value-type-1">Amount</label>
                            <input class="with-gap" name="value_type_id" type="radio" id="value-type-2" value="2"@if (old('value_type_id') == 2) checked @endif />
                            <label for="value-type-2">Percentage</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input id="value" type="text" name="value" class="validate" value="{{ old('value') }}" />
                            <label for="value">Value</label>
                        </div>
                    </div>
                    <div class="col s12 no-padding discount-quantity-rules">
                        <div class="input-field label-field col s12">
                            <label>Quantity Rules</label>
                            <a class="btn-add" href="#" title="Add"><i class="material-icons teal-icon">add</i></a>
                        </div>
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