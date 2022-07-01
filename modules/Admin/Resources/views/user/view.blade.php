@section('page_title', $user->getFullName())
@section('page_class', 'admin-users sticky-footer')

@extends('admin::layouts.master')

@section('content')
@include('admin::includes.header')

<main class="sticky-footer">
    <div class="container">
        <div class="row">

            <table class="responsive-table data-table">
                <thead>
                    <tr>
                        <th>Label</th>
                        <td>Value</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID</td>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td>Friendly ID</td>
                        <td>{{ $user->friendly_id }}</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{ $user->getFullName() }}</td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <td>Email Address</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td>Role</td>
                        <td>{{ $user->role->title }}</td>
                    </tr>
                </tbody>
            </table>
            
            @if ($user->hasRole(getUserRoleType('TYPE_CONTRIBUTOR')))
            <hr />
            <h5>Orders</h5>
                @if (count($orders) > 0)
                <table class="responsive-table data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Friendly ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Currency</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('admin::order.order-row')
                    </tbody>
                </table>
                @else
                <p>I don't have any records!</p>
                @endif
            @endif

        </div>
    </div>
</main>

@include('admin::includes.footer')
@stop