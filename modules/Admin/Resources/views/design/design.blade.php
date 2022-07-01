@section('page_title', $design->title)
@section('page_class', 'admin-catalog sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">
            
            @include('includes.flash')
            
            <form class="col s12 no-padding" method="POST" action="{{ Request::url() }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <table class="responsive-table data-table">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <td>Value</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Image</td>
                            <td>
                                <img class="materialboxed" src="{{ asset($design->getThumbnailImagePath()) }}" alt="Image" />
                                <a href="{{ route('admin::download.design.file', ['id' => $design->id]) }}" title="Download File">
                                    <i class="material-icons teal-icon">play_for_work</i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>DPI</td>
                            <td>{{ $design->dpi }}</td>
                        </tr>
                        <tr>
                            <td>Friendly ID</td>
                            <td>{{ $design->friendly_id }}</td>
                        </tr>
                        <tr>
                            <td>Designer</td>
                            <td>{{ $design->user->username }}</td>
                        </tr>
                        <tr>
                            <td>Title</td>
                            <td>{{ $design->title }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>{{ $design->type->title }}</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>{{ $design->getCategoriesString() }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{{ $design->description }}</td>
                        </tr>
                        <tr>
                            <td>Additional Details</td>
                            <td>{{ $design->additional_details }}</td>
                        </tr>
                        @if ($design->isPublic())
                        <tr>
                            <td>Labels</td>
                            <td>
                                <ul>
                                    @foreach ($design->labels as $label)
                                    <li>{{ $label->title }} ({{ $label->getTypeTitle() }})</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endif
                        @if ($design->isPublic())
                        <tr>
                            <td>Colours</td>
                            <td>
                                <ul>
                                    @foreach ($design->colours as $colour)
                                    <li>{{ $colour->value }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td>Weekly Contest</td>
                            <td>{{ ($design->inWeeklyContest()) ? 'Yes' : 'No' }}</td>
                        </tr>
                        <tr>
                            <td>Private</td>
                            <td>
                                <div class="input-field col s12 m6">
                                    <select id="private" name="private" class="material-select auto-select" data-value="{{ $design->private }}">
                                        <option value="" disabled>Choose your option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Public</td>
                            <td>
                                <div class="input-field col s12 m6">
                                    <select id="public" name="public" class="material-select auto-select" data-value="{{ $design->public }}">
                                        <option value="" disabled>Choose your option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Sample Purchased</td>
                            <td>
                                <div class="input-field col s12 m6">
                                    <select id="swatch_purchased" name="swatch_purchased" class="material-select auto-select" data-value="{{ $design->swatch_purchased }}">
                                        <option value="" disabled>Choose your option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Dispatch Approved</td>
                            <td>
                                <div class="input-field col s12 m6">
                                    <select id="dispatch_approved" name="dispatch_approved" class="material-select auto-select" data-value="{{ $design->dispatch_approved }}">
                                        <option value="" disabled>Choose your option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Admin Approved</td>
                            <td>
                                <div class="input-field col s12 m6">
                                    <select id="approved" name="approved" class="material-select auto-select" data-value="{{ $design->approved }}">
                                        <option value="" disabled>Choose your option</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="input-field col s12">
                    <button class="btn teal waves-effect waves-light right" type="submit">Save</button>
                </div>
            </form>
            
        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop