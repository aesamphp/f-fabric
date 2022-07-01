<canvas id="design_preview" width="448" height="700"></canvas>
<canvas id="design_preview_zoom" width="448" height="700" style="display: none;"></canvas>
<div class="wallpaper-mask" style="display: none;"></div>
<script type="text/javascript">
    var retinaMultiplier = 2.5;
    var previewImage = new Image();
    var highresImage = new Image();
    var compositeMirrorImage = new Image();
    var compositeBrickImage = new Image();
    var compositeDropImage = new Image();
    var compositeCenterImage = new Image();
    var composite_repeats = 0;
    var fabricSizes = {@foreach ($products as $product) {{ $product->id }}:
    [App.functions.convertMillimeterToCentimetre({{ ($product->width) ? $product->width : 0 }}), App.functions.convertMillimeterToCentimetre({{ $product->height }})], @endforeach}
    ;
    var materialWidths = {@foreach ($materials as $material) {{ $material->id }}:
    App.functions.convertMillimeterToCentimetre({{ $material->max_width }}), @endforeach}
    ;
    var image = {
        width: App.functions.convertInchesToCentimetre(App.functions.convertPixelsToInches({{ getImageWidth($designImages->actualImagePath) }})),
        height: App.functions.convertInchesToCentimetre(App.functions.convertPixelsToInches({{ getImageHeight($designImages->actualImagePath) }}))
    };
    var previewCanvas = document.getElementById("design_preview");
    previewCanvas.style.width = previewCanvas.width / retinaMultiplier + 'px';
    var zoomCanvas = document.getElementById("design_preview_zoom");
    zoomCanvas.width = previewCanvas.width;
    zoomCanvas.style.width = previewCanvas.width / retinaMultiplier + 'px';
    var zoomCtx = zoomCanvas.getContext('2d');
    zoomCtx.scale(retinaMultiplier, retinaMultiplier);
    var zoomImage = new Image();
    var iMouseX, iMouseY = 1;
    var bMouseDown = false;
    var iZoomRadius = 100;
    var iZoomPower = 2.5;
    var iZoomLens = 300 * retinaMultiplier;

    var makePreview = function () {
        var fabricSizeId = $("select#product_id").val(),
            fabricSizeIndex,
            fabricId = 10,
            fabricIndex,
            repeat = 0,
            user_dpi = ($("input[name*=dpi]").val() > App.config.imageDPI) ? $("input[name*=dpi]").val() : App.config.imageDPI,
            user_ppc = App.functions.convertDPIToPPC(user_dpi),
            wallpaper_view = $("input[name=wallpaper_view]:checked").val(),
            gift_wrap_view = $("input[name=gift_wrap_view]:checked").val(),
            apron_view = null,
            towel_view = null,
            cushion_view = null,
            wall = false;

        handleDesignPreviewZoom(false);
        $('a.btn-design-preview-zoom').removeClass('enabled').text('Enable Zoom');

        $('#design-repeat-types .type-image-single').each(function () {
            var $this = $(this),
                $btn = $this.find('a');
            if ($btn.hasClass('active')) {
                repeat = $btn.data('code');
                $('input#design_type_id, form#design-edit-form input[name=type_id]').val($btn.data('id'));
            }
        });

        if (fabricSizeId == 9 || fabricSizeId == 10) {
            $('.apron-toggle-btns').removeClass('hidden');
        } else {
            $('.apron-toggle-btns').addClass('hidden');
            $('input#apron_view_design').prop('checked', true);
        }

        if (fabricSizeId == 11) {
            $('.towel-toggle-btns').removeClass('hidden');
        } else {
            $('.towel-toggle-btns').addClass('hidden');
            $('input#towel_view_design').prop('checked', true);
        }

        if (fabricSizeId == 12 || fabricSizeId == 13) {
            $('.cushion-toggle-btns').removeClass('hidden');
        } else {
            $('.cushion-toggle-btns').addClass('hidden');
            $('input#cushion_view_design').prop('checked', true);
        }

        apron_view = $("input[name=apron_view]:checked").val();
        towel_view = $("input[name=towel_view]:checked").val();
        cushion_view = $("input[name=cushion_view]:checked").val();

        if (wallpaper_view === "room") {
            wall = true;
        }

        if (fabricSizeId == 1) {
            fabricSizes[fabricSizeId][0] = materialWidths[$('select[name*=material_id]').val()];
        }

        var h_conversion = (App.functions.convertDPIToPPC(App.config.imageDPI) / user_ppc),
            w_conversion = (App.functions.convertDPIToPPC(App.config.imageDPI) / user_ppc);

        fabricHeight = 0;
        if (typeof (fabricSizeId) == "undefined") {
            console.log("Fabric Size undefined, setting to first item");
            fabricSizeId = 0;
        }

        if ((fabricSizeId == 1 || fabricSizeId == 7)) {
            var meter = (parseInt($('input[name="quantity"]').val()) > 0) ? $('input[name="quantity"]').val() : 1;
            if (meter > 5) {
                meter = 5;
            }
            fabricHeight = fabricSizes[fabricSizeId][1] * meter;
        } else {
            fabricHeight = fabricSizes[fabricSizeId][1];
        }

        if (wall) {
            if (fabricSizeId == 4) {
                makeRepeatCounts(24, 24, w_conversion * image.width, h_conversion * image.height);
            } else {
                makeRepeatCounts(48, 48, w_conversion * image.width, h_conversion * image.height);
            }
        } else {
            makeRepeatCounts(fabricSizes[fabricSizeId][0], fabricHeight, w_conversion * image.width, h_conversion * image.height);
        }

        if (image.width < App.functions.convertInchesToCentimetre(4) || image.height < App.functions.convertInchesToCentimetre(4)) {
            if (repeat == 4) {
                compositeImage = compositeMirrorImage;
            }
            if (repeat == 3) {
                compositeImage = compositeBrickImage;
            }
            if (repeat == 2) {
                compositeImage = compositeDropImage;
            }
            if (repeat == 1) {
                compositeImage = previewImage;
            }
            if (repeat == 0) {
                compositeImage = compositeCenterImage;
            }
        } else {
            compositeImage = previewImage;
            composite_repeats = 0;
        }

        WaterMark = 0;

        if (wall) {
            $('.design-selected-image').addClass('mask-container').removeClass('apron-height');
            $('.wallpaper-mask').removeClass('bg-cover apron-mask apron-child towel-mask cushion-45-mask cushion-60-mask gift-wrap-mask').show();
            App.functions.drawPreview(previewImage, highresImage, compositeImage,
                250,
                250,
                w_conversion * image.width,
                h_conversion * image.height,
                repeat, composite_repeats, user_dpi, WaterMark, "wall", fabricSizeId);
        } else {
            var wallText = "";
            if (apron_view === "apron") {
                wallText = "wall";
                $('.design-selected-image').addClass('mask-container apron-height');
                if (fabricSizeId == 10) {
                    $('.wallpaper-mask').removeClass('towel-mask cushion-45-mask cushion-60-mask gift-wrap-mask').addClass('bg-cover apron-mask apron-child').show();
                } else {
                    $('.wallpaper-mask').addClass('bg-cover apron-mask').removeClass('apron-child towel-mask cushion-45-mask cushion-60-mask gift-wrap-mask').show();
                }
            } else if (towel_view === "towel") {
                wallText = "wall";
                $('.design-selected-image').addClass('mask-container apron-height');
                $('.wallpaper-mask').removeClass('apron-mask apron-child cushion-45-mask cushion-60-mask gift-wrap-mask').addClass('bg-cover towel-mask').show();
            } else if (cushion_view === "cushion") {
                wallText = "wall";
                $('.design-selected-image').addClass('mask-container apron-height');
                if (fabricSizeId == 12) {
                    $('.wallpaper-mask').removeClass('apron-mask apron-child towel-mask cushion-60-mask gift-wrap-mask').addClass('bg-cover cushion-45-mask').show();
                } else {
                    $('.wallpaper-mask').removeClass('apron-mask apron-child towel-mask cushion-45-mask gift-wrap-mask').addClass('bg-cover cushion-60-mask').show();
                }
            } else if (gift_wrap_view === "gift_wrap") {
                fabricHeight = 75;
                wallText = "wall";
                $('.design-selected-image').addClass('mask-container apron-height');
                $('.wallpaper-mask').removeClass('apron-mask apron-child towel-mask cushion-45-mask cushion-60-mask').addClass('bg-cover gift-wrap-mask').show();
            } else {
                $('.wallpaper-mask').hide().removeClass('bg-cover apron-mask apron-child towel-mask cushion-45-mask cushion-60-mask gift-wrap-mask');
                $('.design-selected-image').removeClass('mask-container apron-height');
            }
            App.functions.drawPreview(previewImage, highresImage, compositeImage,
                fabricSizes[fabricSizeId][0],
                fabricHeight,
                w_conversion * image.width,
                h_conversion * image.height,
                repeat, composite_repeats, user_ppc, WaterMark, wallText, fabricSizeId);
        }
    };

    var changeProduct = function () {
        if ($("select#product_id").val() == 9 || $("select#product_id").val() == 10) {
            $('input#apron_view_apron').prop('checked', true);
        } else if ($("select#product_id").val() == 11) {
            $('input#towel_view_towel').prop('checked', true);
        } else if ($("select#product_id").val() == 12 || $("select#product_id").val() == 13) {
            $('input#cushion_view_cushion').prop('checked', true);
        }
        $('.btn-add-to-cart').prop('disabled', false);
        makePreview();
    };

    previewImage.onload = function () {
        $("input#design_type_id").bind('click', makePreview);
        $("input[name=wallpaper_view]").bind('change', makePreview);
        $("input[name=apron_view]").bind('change', makePreview);
        $("input[name=towel_view]").bind('change', makePreview);
        $("input[name=cushion_view]").bind('change', makePreview);
        $("input[name=gift_wrap_view]").bind('change', makePreview);

        if ((image.width > App.functions.convertInchesToCentimetre(10)) || (image.height > App.functions.convertInchesToCentimetre(10))) {
            highresImage.src = '{{ asset($designImages->highResolutionImagePath) }}';
        } else {
            highresImage = previewImage;
        }

        if ((image.width < App.functions.convertInchesToCentimetre(4)) || (image.height < App.functions.convertInchesToCentimetre(4))) {
            compositeMirrorImage.src = '{{ asset($designImages->mirrorImagePath) }}';
            compositeBrickImage.src = '{{ asset($designImages->halfBrickRepeatedImagePath) }}';
            compositeDropImage.src = '{{ asset($designImages->halfDropRepeatedImagePath) }}';
            compositeCenterImage.src = '{{ asset($designImages->filePath) }}';
        }

        $('.design-selected-image').removeClass('loading-container').find('.icon-loading').remove();
        changeProduct();

        setTimeout(function () {
            App.functions.newDpi();
        }, 500);
    };

    if ((image.width > App.functions.convertInchesToCentimetre(72)) || (image.height > App.functions.convertInchesToCentimetre(72))) {
        console.log("preview Image > than 72");
        highresImage.src = '{{ asset($designImages->highResolutionImagePath) }}';
        previewImage.src = '{{ asset($designImages->simpleMirrorImage) }}';
    } else {
        console.log("preview Image < than 72");
        previewImage.src = '{{ asset($designImages->simpleMirrorImage) }}';
    }

    var makeFabricSizes = function () {
        var fabric;
        console.log("Inside makeFabricSizes");
        makePreview();
    };

    var makeRepeatCounts = function (fabricWidth, fabricHeight, imageWidth, imageHeight) {
        /**
         * THIS FUNCTION IS USED WITH THE BIGGER/SMALLER RESULUTION TOOL
         * IT CALCULATES THE APPROXIMATE NUMBER OF REPEATS CURRENTLY ON
         * THE PREVIEW CANVAS IN THE X AND Y DIMENSION AND UPDATES FIELDS
         * ON THE PAGE WITH THIS DATA, WHICH ARE THEN USED BY THE
         * BIGGER AND SMALLER FUNCTIONS IN REPCHANGES.JS
         */

        // factor = 0.965;
        factor = 1.0;
        xReps = fabricWidth / (imageWidth * factor);
        yReps = fabricHeight / (imageHeight * factor);
        document.getElementById('fabric_width').firstChild.data = fabricWidth;
        document.getElementById('fabric_height').firstChild.data = fabricHeight;
        document.getElementById('image_width').firstChild.data = (image.width * factor);
        document.getElementById('image_height').firstChild.data = (image.height * factor);
        if (Math.abs(xReps - parseFloat(parseInt(xReps + 0.04))) < 0.04) {
            xReps = parseInt(xReps + 0.04);
        } else {
            xReps = Math.round(xReps * 1000) / 1000;
        }
        document.getElementById('x_rep_count').firstChild.data = xReps;
        if (Math.abs(yReps - parseFloat(parseInt(yReps + 0.04))) < 0.04) {
            yReps = parseInt(yReps + 0.04);
        } else {
            yReps = Math.round(yReps * 1000) / 1000;
        }
        document.getElementById('y_rep_count').firstChild.data = yReps;
    };

    var handleDesignPreviewZoom = function (zoom) {
        if (zoom === true) {
            zoomCanvas.height = previewCanvas.height;
            zoomCanvas.width = previewCanvas.width;
            zoomCanvas.style.height = previewCanvas.style.height;
            zoomCanvas.style.width = previewCanvas.style.width;
            zoomImage.src = previewCanvas.toDataURL();
            zoomImage.onload = function () {
                drawZoomPreview();
                $(zoomCanvas).show();
            };
        } else {
            $(zoomCanvas).hide();
        }
    };

    var drawZoomPreview = function () {
        zoomCtx.clearRect(0, 0, zoomCtx.canvas.width, zoomCtx.canvas.height);
        if (bMouseDown) {
            zoomCtx.drawImage(zoomImage, 0 - iMouseX * (iZoomPower - 1), 0 - iMouseY * (iZoomPower - 1), zoomCtx.canvas.width * iZoomPower, zoomCtx.canvas.height * iZoomPower);
            zoomCtx.globalCompositeOperation = 'destination-atop';

            zoomCtx.beginPath();
            zoomCtx.rect(iMouseX - (iZoomLens / 2), iMouseY - (iZoomLens / 2), iZoomLens, iZoomLens);
            zoomCtx.closePath();
            zoomCtx.fill();
            var thickness = 16;
            zoomCtx.fillStyle = '#a0a0a0';
            zoomCtx.fillRect(iMouseX - (iZoomLens / 2) - thickness, iMouseY - (iZoomLens / 2) - thickness, iZoomLens + (thickness * 2), iZoomLens + (thickness * 2));
        }
        zoomCtx.drawImage(zoomImage, 0, 0, zoomCtx.canvas.width, zoomCtx.canvas.height);
    };

    previewCanvas.addEventListener("mouseover", function () {
        $('a.btn-design-preview-zoom').click();
    });

    zoomCanvas.addEventListener("mousemove", function (event) {
        var canvasOffset = $(zoomCanvas).offset();
        iMouseX = Math.floor(event.pageX - canvasOffset.left) * retinaMultiplier;
        iMouseY = Math.floor(event.pageY - canvasOffset.top) * retinaMultiplier;
        bMouseDown = true;
        drawZoomPreview();
    });

    zoomCanvas.addEventListener("mouseout", function () {
        bMouseDown = false;
        drawZoomPreview();
        $('a.btn-design-preview-zoom').click();
    });

    var resizeDesignPreviewCanvas = function (drawPreview) {
        var parentWidth = $(previewCanvas).parent().width(),
            minWidth = 448;

        zoomCanvas.width = previewCanvas.width = (parentWidth > minWidth ? parentWidth : minWidth) * retinaMultiplier;
        zoomCanvas.style.width = previewCanvas.style.width = previewCanvas.width / retinaMultiplier + 'px';
        if (drawPreview) {
            makePreview();
        }
    }

    resizeDesignPreviewCanvas(false);
    $(window).on('resize', function () {
        resizeDesignPreviewCanvas(true);
    });
</script>