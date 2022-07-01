<div class="header-menu">
  <div class="container container-global">
    <div class="row">
      <div class="col-sm-12 no-pad clearfix">
        <ul class="header-menu-list hidden-sm hidden-xs clearfix">
          @foreach($menu->menuSections as $section)
            @include('includes.header-menu.menu-section', ['section' => $section])
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>