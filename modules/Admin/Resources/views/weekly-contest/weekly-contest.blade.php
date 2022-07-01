@section('page_title', $weeklyContest->title)
@section('page_class', 'admin-promotions sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            @include('includes.flash')
            
            @if ($weeklyContest->isFinishedContest())
            <div class="col s12">
                <div class="row">
                    <a class="btn teal waves-effect waves-light right" href="{{ route('admin::download.weekly.contest.report', ['id' => $weeklyContest->id]) }}">Download Report</a>
                </div>
            </div>
            @endif

            <form class="col s12" method="POST" action="{{ Request::url() }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="row">
                    <div class="input-field col s12 no-padding">
                        <div class="input-field col s12 m6">
                            <input id="title" type="text" name="title" class="validate" value="{{ $weeklyContest->title }}" />
                            <label for="title">Title</label>
                        </div>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="from_date" type="date" value="{{ formatDate($weeklyContest->from_date, 'd-m-Y') }}" class="datepicker" placeholder="From Date" {{ ($weeklyContest->isUpcomingContest()) ? 'name=from_date' : 'disabled' }} />
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="to_date" type="date" value="{{ formatDate($weeklyContest->to_date, 'd-m-Y') }}" class="datepicker" placeholder="To Date" {{ ($weeklyContest->isUpcomingContest()) ? 'name=to_date' : 'disabled' }} />
                    </div>
                    <div class="input-field col s12">
                        <textarea id="excerpt" name="excerpt" class="materialize-textarea height-10">{{ $weeklyContest->excerpt }}</textarea>
                        <label for="excerpt">Excerpt</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="description" name="description" class="tinymce-editor">{{ $weeklyContest->description }}</textarea>
                        <label for="description">Description</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                        <a class="btn grey lighten-1 waves-effect waves-light right btn-push-left" href="{{ route('admin::view.weekly.contests') }}">Cancel</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop