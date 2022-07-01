@section('page_title', $menu->title)
@section('page_class', 'admin-cms sticky-footer')

@extends('admin::layouts.master')

@section('content')
  @include('admin::includes.header')

  <main class="sticky-footer">
    <div class="container">
      <div class="row">
        @include('includes.flash')

        <h4>Menu Items</h4>

        @if(count($menu->menuSections) > 0)
          <h5>Add new item</h5>
          @include('admin::menu.create')

          <form method="POST" action="{{ route('admin::update.menuitem', ['id' => $menu->id]) }}">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            @foreach($menu->menuSections as $section)
              <div class="section">
                <h5>
                  <span>{{ $section->title }}</span>
                </h5>

                @include('admin::menu.items', ['menuItems' => $section->menuItems])
              </div>
            @endforeach
          </form>
        @endif

        <div class="clearfix"></div>
      </div>
    </div>
  </main>

  @include('admin::includes.footer')
@stop