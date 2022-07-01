<script type="text/javascript">

  @if(isset($basket))
    App.config.routes.designPreviewURL = "{{ route('edit.design.preview', ['basketId' => $basket->id]) }}";
  @else
    App.config.routes.designPreviewURL = "{{ route('create.design.preview') }}";
  @endif

  $(function () {
    App.functions.initializeManipulateFunctions();
    $(document).on('click', '#btn-show-dpi', function (event) {
      event.preventDefault();
      $('#dpi-input-block').removeClass('hidden');
    });
    $(document).on('click', '#btn-hide-dpi', function () {
      $('#dpi-input-block').addClass('hidden');
    });
    $('input[name=design_public]').click(function () {
      var $this = $(this);
      if ($this.attr('id') === 'design_private') {
        $('input#private').val(1);
        $('input#public').val(0);
      } else {
        $('input#private').val(0);
        $('input#public').val($('input[name=design_public]:checked').val());
      }
    });
    $(document).on('keypress', 'input#change_dpi', function (event) {
      if (event.which === 13) {
        event.preventDefault();
        App.functions.newDpi();
      }
    });
    $('.btn-select-sample').click(function () {
      $('.sell-public-popup').removeClass('active');
      $('input#public_popup').prop('checked', true);
      $('select#product_id').val(2).trigger('change');
      $('input#design_request_public').val(1);
    });
    $('a.btn-design-preview-zoom').click(function (event) {
      event.preventDefault();
      var $zoomBtn = $(this),
        $loading = $('.design-selected-image .icon-loading');
      if ($loading.length) {
        alert('Please wait while the design preview is loading!');
        return false;
      }
      if ($zoomBtn.hasClass('enabled')) {
        $zoomBtn.removeClass('enabled').text('Enable Zoom');
        handleDesignPreviewZoom(false);
      } else {
        $zoomBtn.addClass('enabled').text('Disable Zoom');
        handleDesignPreviewZoom(true);
      }
    });
  });
</script>
<div class="hidden">
  <input id="fabric_item_dpi_150" name="fabric_item[dpi]" type="radio" value="150"/>
  <label for="fabric_item_fabric_dpi_150">Base Size (150 DPI)</label>
  <br/><span id="image_width">1</span>
  <br/><span id="image_height">1</span>
  <br/><span id="fabric_width">1</span>
  <br/><span id="fabric_height">1</span><br/>
  <span style="float: left; width: 80px;">Horizontal: </span>
  <strong><span id="x_rep_count" style="width: 150px;">1</span></strong><br/>
  <span style="float: left; width: 80px;">Vertical: </span>
  <strong><span id="y_rep_count" style="width: 150px;">1</span></strong>
</div>