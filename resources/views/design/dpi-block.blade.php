<div class="input-text clearfix">
  <h3 class="input-text__hdr hdr-input">1. Design Size <a id="btn-show-dpi" href="#">Change DPI</a></h3>
  <button id="" class="btn" type="button" onclick="App.functions.smaller();">Smaller</button>
  <button id="rep_bigger" class="btn" type="button" onclick="App.functions.bigger();">Bigger</button>
  <p class="input-text__info">
    <span id="sum_rep_size">0.00cm x 0.00cm</span>,
    <span id="rep_dpi">
      {{ isset($basket) ? $basket->dpi : DesignImage::DPI_ACTUAL_MIN }}
    </span>
    pixels/inch,
    <span id="des_rep"></span>
    <span id="x150_warning" style="display: none;">
      at {{ DesignImage::DPI_ACTUAL_MIN }} dpi minimum
    </span>
  </p>
  <div id="dpi-input-block" class="hidden">
    <input id="change_dpi" type="tel" class="input-dpi__dropdown number" name="dpi"
      value="@if(isset($design_images_dpi)){{ $design_images_dpi }}@elseif(isset($basket)){{ $basket->dpi }}@elseif(isset($design)){{ $design->dpi }}@else{{ DesignImage::DPI_ACTUAL_MIN }}@endif"/>
    <button id="rep_new_dpi" class="btn" type="button" onclick="App.functions.newDpi();">Change</button>
    <button id="btn-hide-dpi" class="btn" type="button">Hide</button>
  </div>
</div>