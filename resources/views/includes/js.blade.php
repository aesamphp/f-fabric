<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/touch-punch.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/spectrum.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/placeholder.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sly.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tab.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/browserdetect.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/iframe-transport.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/history.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/functions.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/image.manipulate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/manipulate.functions.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/facebook.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/widgets.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/intercom.js') }}"></script>
<script type="text/javascript">
    App.config.csrfToken = "{{ csrf_token() }}";
    App.config.routes.baseURL = "{{ route('home') }}";
    App.config.imageDPI = {{ getClassConstantValue('App\Models\DesignImage::DPI_ACTUAL_MIN') }};
    App.device.browser = "{{ $clientDetails->browser }}";
    App.device.version = parseInt("{{ $clientDetails->version }}");
    App.device.OS = "{{ $clientDetails->os }}";
    App.config.countries = {!! App\Models\Country::all(['id', 'title', 'code'])->toJson() !!};
    App.config.currencies = {!! App\Models\Currency::all(['id', 'title', 'code'])->toJson() !!};
    App.config.EUCountryCodes = [@foreach (App\Models\PaymentDetail::getEUCountryCodes() as $code) "{{ $code }}", @endforeach];
    App.config.spectrum.palette = [@foreach (App\Models\DesignColour::getColourPalettes() as $colour) [@foreach ($colour['values'] as $value) '{{ $value }}', @endforeach], @endforeach];
    App.config.routes.searchAddressURL = "{{ route('search.address') }}";
    App.config.routes.getProductMaterialPrice = "{{ route('view.product.material.price') }}";
    App.config.routes.getProductMaterialQuantityDiscounts = "{{ route('view.product.material.quantity.discounts') }}";
</script>