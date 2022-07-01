<li class="js-hover-info-container header-menu-list__item hover-init">
  <a class="link-bracket-hover" href="{{ url($section->url) }}">{{ $section->title }}</a>

  @if(!$section->menuItems->isEmpty())
    <div class="menu menu-sub">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="menu-sub__hdr">{{ $section->excerpt }}</h2>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12 no-pad full-height">
          <div class="col-xs-4">
            <ul class="menu-sub-list">
              @foreach($section->menuItems as $item)
                <li class="js-item item"><a href="{{ url($item->route) }}">{{ $item->title }}</a></li>
              @endforeach
            </ul>
          </div>
          <div class="col-xs-8 pull-right">
            @foreach($section->menuItems as $item)
              <div
                  class="js-hover-info menu-sub-content @if ($item->id === $section->menuItems->first()->id) active @endif">
                <h3 class="menu-sub-content__hdr">
                  {{ $item->title }}
                </h3>
                <div class="menu-sub-content__img" style="background-image: url({{ $item->image_path }});"></div>
                <p class="menu-sub-content__para">{{ $item->excerpt }}</p>
                <a href="{{ url($item->route) }}" class="menu-sub-content__link link-arrow-major">View Page</a>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endif
</li>