@section('page_title', 'Payment Gateway Settings')
@section('page_class', 'admin-settings sticky-footer')

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
                    <ul class="collapsible col s12 no-padding teal-theme" data-collapsible="expandable">
                        @foreach ($gateways as $gateway)
                        <li class="col s12 no-padding">
                            <div class="collapsible-header collapsible-padding col s12 active">{{ $gateway->title }}</div>
                            <div class="collapsible-body collapsible-padding col s12">
                                <div class="input-field col s12 m6">
                                    <select id="active" name="gateway[{{ $gateway->id }}][active]" class="material-select auto-select" data-value="{{ $gateway->active }}">
                                        <option value="" disabled>Choose your option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    <label for="active">Enabled</label>
                                </div>
                                @include('admin::setting.setting-row', ['settings' => $gateway->options])
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop