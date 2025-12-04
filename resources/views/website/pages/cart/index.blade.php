<!DOCTYPE html>
<html dir="rtl" lang="ar"
    class="desktop win chrome chrome141 webkit oc30 is-customer route-checkout-cart store-0 skin-1 desktop-header-active mobile-sticky layout-7"
    data-jb="185b08f7" data-jv="3.1.13.1" data-ov="3.0.3.9">

<head typeof="og:website">
    @include('website.layout.cartHead')
</head>

<body class="">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WL756BVV" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->



    <div class="mobile-container mobile-main-menu-container">
        <div class="mobile-wrapper-header">
            <span>الاقسام</span>
            <a class="x"></a>
        </div>
        <div class="mobile-main-menu-wrapper">

        </div>
    </div>

    <div class="mobile-container mobile-filter-container">
        <div class="mobile-wrapper-header"></div>
        <div class="mobile-filter-wrapper"></div>
    </div>

    <div class="mobile-container mobile-cart-content-container">
        <div class="mobile-wrapper-header">
            <span>سلة مشترياتك</span>
            <a class="x"></a>
        </div>
        <div class="mobile-cart-content-wrapper cart-content"></div>
    </div>



    <div class="site-wrapper">

        <div class="notice-module module module-header_notice module-header_notice-56"
            data-options='{"cookie":"8dc5ed03","ease":"easeOutQuart","duration":"800"}'>
            <div class="module-body">
                <div class="hn-body">
                    <div class="hn-content">
                        <p><b>
                                <font color="#ff0000">شحن مجاني</font> عند الطلب بـ 229 ريال وأكثر
                            </b><br></p>
                    </div>
                </div>
                <div class="header-notice-close-button">
                    <button class="btn hn-close">
                    </button>
                </div>
            </div>
        </div>


        @include('website.layout.header')



        <ul class="breadcrumb">
            <li><a href="#?route=common/home"><i class="fa fa-home"></i></a></li>
            <li><a href="#?route=checkout/cart">سلة الشراء</a></li>
        </ul>

        <div id="checkout-cart" class="container">
            <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> نجاح: تم تعديل
                محتويات سلة الشراء !
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <div class="row">
                <div id="content" class="col-sm-12">
                    <h1 class="title page-title">سلة الشراء
                    </h1>

                    <div class="cart-page">
                        <form action="#?route=checkout/cart/edit" method="post"
                            enctype="multipart/form-data" class="cart-table">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td class="text-center td-image">صورة</td>
                                            <td class="text-left td-name">الاسم</td>
                                            <td class="text-center td-model">النوع</td>
                                            <td class="text-center td-qty">الكمية</td>
                                            <td class="text-center td-price">سعر الوحدة</td>
                                            <td class="text-center td-total">الاجمالي</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td class="text-center td-image"> <a
                                                    href="#?route=product/product&amp;product_id=212"><img
                                                        src="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%20ballon%20%20and%20mather%20day%2015-60x60.jpg"
                                                        alt="بالون هيليوم فضي" title="بالون هيليوم فضي" /></a> </td>
                                            <td class="text-left td-name"><a
                                                    href="#?route=product/product&amp;product_id=212">بالون
                                                    هيليوم فضي</a> </td>
                                            <td class="text-center td-model">balA0016</td>
                                            <td class="text-center td-qty">
                                                <div class="input-group btn-block">
                                                    <div class="stepper">
                                                        <input type="text" name="quantity[1911]" value="3"
                                                            size="1" class="form-control" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <span class="input-group-btn">
                                                        <button type="submit" data-toggle="tooltip"
                                                            title="تحديث الكمية" class="btn btn-update"><i
                                                                class="fa fa-refresh"></i></button>
                                                        <button type="button" data-toggle="tooltip" title="حذف"
                                                            class="btn btn-remove" onclick="cart.remove('1911');"><i
                                                                class="fa fa-times-circle"></i></button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center td-price">5 ر.س</td>
                                            <td class="text-center td-total">15 ر.س</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        <div class="cart-bottom">
                            <div class="panels-total">
                                <div class="cart-panels">
                                    <h2 class="title">الخيارات المتاحة في سلة الشراء</h2>
                                    <p>الرجاء الاختيار اذا كنت تمتلك رمز تخفيض أو نقاط مكافآت أو معاينة طرق الشحن
                                        المتوقعة لمنطقتك.</p>
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default panel-coupon">
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><a href="#collapse-coupon"
                                                        class="accordion-toggle" data-toggle="collapse"
                                                        data-parent="#accordion">استخدم قسيمة التخفيض <i
                                                            class="fa fa-caret-down"></i></a></h4>
                                            </div>
                                            <div id="collapse-coupon" class="panel-collapse collapse">
                                                <div class="panel-body form-group">
                                                    <label class="control-label" for="input-coupon">الرجاء ادخال رمز
                                                        قسيمة التخفيض</label>
                                                    <div class="input-group">
                                                        <input type="text" name="coupon" value=""
                                                            placeholder="الرجاء ادخال رمز قسيمة التخفيض"
                                                            id="input-coupon" class="form-control" />
                                                        <span class="input-group-btn">
                                                            <input type="button" value="اعتمد التخفيض"
                                                                id="button-coupon" data-loading-text="جاري ..."
                                                                class="btn btn-primary" />
                                                        </span>
                                                    </div>
                                                    <script type="text/javascript">
                                                        <!--
                                                        $('#button-coupon').on('click', function() {
                                                            $.ajax({
                                                                url: 'index.php?route=extension/total/coupon/coupon',
                                                                type: 'post',
                                                                data: 'coupon=' + encodeURIComponent($('input[name=\'coupon\']').val()),
                                                                dataType: 'json',
                                                                beforeSend: function() {
                                                                    $('#button-coupon').button('loading');
                                                                },
                                                                complete: function() {
                                                                    $('#button-coupon').button('reset');
                                                                },
                                                                success: function(json) {
                                                                    $('.alert-dismissible').remove();

                                                                    if (json['error']) {
                                                                        $('.container').prepend(
                                                                            '<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' +
                                                                            json['error'] +
                                                                            '<button type="button" class="close" data-dismiss="alert">&times;</button></div>'
                                                                            );

                                                                        $('html, body').animate({
                                                                            scrollTop: 0
                                                                        }, 'slow');
                                                                    }

                                                                    if (json['redirect']) {
                                                                        location = json['redirect'];
                                                                    }
                                                                },
                                                                error: function(xhr, ajaxOptions, thrownError) {
                                                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                                                }
                                                            });
                                                        });
                                                        //
                                                        -->
                                                    </script>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-shipping">
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><a href="#collapse-shipping"
                                                        class="accordion-toggle" data-toggle="collapse"
                                                        data-parent="#accordion">الشحن المتوقع <i
                                                            class="fa fa-caret-down"></i></a></h4>
                                            </div>
                                            <div id="collapse-shipping" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <p>ادخل بيانات الشحن الخاصة بك للحصول على الشحن المتوقع لطلبك.</p>
                                                    <div class="form-horizontal">
                                                        <div class="form-group required">
                                                            <label class="col-sm-2 control-label"
                                                                for="input-country">الدولة :</label>
                                                            <div class="col-sm-10">
                                                                <select name="country_id" id="input-country"
                                                                    class="form-control">
                                                                    <option value=""> --- الرجاء الاختيار ---
                                                                    </option>
                                                                    <option value="184" selected="selected">
                                                                        السعودية</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group required">
                                                            <label class="col-sm-2 control-label"
                                                                for="input-zone">المنطقة / المحافظة:</label>
                                                            <div class="col-sm-10">
                                                                <select name="zone_id" id="input-zone"
                                                                    class="form-control">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group required">
                                                            <label class="col-sm-2 control-label"
                                                                for="input-postcode">الرمز البريدي:</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="postcode" value=""
                                                                    placeholder="الرمز البريدي:" id="input-postcode"
                                                                    class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="buttons">
                                                            <div class="pull-right">
                                                                <button type="button" id="button-quote"
                                                                    data-loading-text="جاري ..."
                                                                    class="btn btn-primary">أرسل</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                        <!--
                                                        $('#button-quote').on('click', function() {
                                                            $.ajax({
                                                                url: 'index.php?route=extension/total/shipping/quote',
                                                                type: 'post',
                                                                data: 'country_id=' + $('select[name=\'country_id\']').val() + '&zone_id=' + $(
                                                                    'select[name=\'zone_id\']').val() + '&postcode=' + encodeURIComponent($(
                                                                    'input[name=\'postcode\']').val()),
                                                                dataType: 'json',
                                                                beforeSend: function() {
                                                                    $('#button-quote').button('loading');
                                                                },
                                                                complete: function() {
                                                                    $('#button-quote').button('reset');
                                                                },
                                                                success: function(json) {
                                                                    $('.alert-dismissible, .text-danger').remove();

                                                                    if (json['error']) {
                                                                        if (json['error']['warning']) {
                                                                            $('.container').prepend(
                                                                                '<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' +
                                                                                json['error']['warning'] +
                                                                                '<button type="button" class="close" data-dismiss="alert">&times;</button></div>'
                                                                                );

                                                                            $('html, body').animate({
                                                                                scrollTop: 0
                                                                            }, 'slow');
                                                                        }

                                                                        if (json['error']['country']) {
                                                                            $('select[name=\'country_id\']').after('<div class="text-danger">' + json[
                                                                                'error']['country'] + '</div>');
                                                                        }

                                                                        if (json['error']['zone']) {
                                                                            $('select[name=\'zone_id\']').after('<div class="text-danger">' + json[
                                                                                'error']['zone'] + '</div>');
                                                                        }

                                                                        if (json['error']['postcode']) {
                                                                            $('input[name=\'postcode\']').after('<div class="text-danger">' + json[
                                                                                'error']['postcode'] + '</div>');
                                                                        }
                                                                    }

                                                                    if (json['shipping_method']) {
                                                                        $('#modal-shipping').remove();

                                                                        html = '<div id="modal-shipping" class="modal">';
                                                                        html += '  <div class="modal-dialog">';
                                                                        html += '    <div class="modal-content">';
                                                                        html += '      <div class="modal-header">';
                                                                        html +=
                                                                            '        <h4 class="modal-title">الرجاء اختيار طريقة الشحن المناسبة لك.</h4>';
                                                                        html += '      </div>';
                                                                        html += '      <div class="modal-body">';

                                                                        for (i in json['shipping_method']) {
                                                                            html += '<p><strong>' + json['shipping_method'][i]['title'] +
                                                                                '</strong></p>';

                                                                            if (!json['shipping_method'][i]['error']) {
                                                                                for (j in json['shipping_method'][i]['quote']) {
                                                                                    html += '<div class="radio">';
                                                                                    html += '  <label>';

                                                                                    if (json['shipping_method'][i]['quote'][j]['code'] == '') {
                                                                                        html += '<input type="radio" name="shipping_method" value="' +
                                                                                            json['shipping_method'][i]['quote'][j]['code'] +
                                                                                            '" checked="checked" />';
                                                                                    } else {
                                                                                        html += '<input type="radio" name="shipping_method" value="' +
                                                                                            json['shipping_method'][i]['quote'][j]['code'] + '" />';
                                                                                    }

                                                                                    html += json['shipping_method'][i]['quote'][j]['title'] + ' - ' +
                                                                                        json['shipping_method'][i]['quote'][j]['text'] +
                                                                                        '</label></div>';
                                                                                }
                                                                            } else {
                                                                                html += '<div class="alert alert-danger alert-dismissible">' + json[
                                                                                    'shipping_method'][i]['error'] + '</div>';
                                                                            }
                                                                        }

                                                                        html += '      </div>';
                                                                        html += '      <div class="modal-footer">';
                                                                        html +=
                                                                            '        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>';

                                                                        html +=
                                                                            '        <input type="button" value="اعتمد الشحن" id="button-shipping" data-loading-text="جاري ..." class="btn btn-primary" disabled="disabled" />';

                                                                        html += '      </div>';
                                                                        html += '    </div>';
                                                                        html += '  </div>';
                                                                        html += '</div> ';

                                                                        $('body').append(html);

                                                                        $('#modal-shipping').modal('show');

                                                                        $('input[name=\'shipping_method\']').on('change', function() {
                                                                            $('#button-shipping').prop('disabled', false);
                                                                        });
                                                                    }
                                                                },
                                                                error: function(xhr, ajaxOptions, thrownError) {
                                                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                                                }
                                                            });
                                                        });

                                                        $(document).delegate('#button-shipping', 'click', function() {
                                                            $.ajax({
                                                                url: 'index.php?route=extension/total/shipping/shipping',
                                                                type: 'post',
                                                                data: 'shipping_method=' + encodeURIComponent($('input[name=\'shipping_method\']:checked')
                                                                    .val()),
                                                                dataType: 'json',
                                                                beforeSend: function() {
                                                                    $('#button-shipping').button('loading');
                                                                },
                                                                complete: function() {
                                                                    $('#button-shipping').button('reset');
                                                                },
                                                                success: function(json) {
                                                                    $('.alert-dismissible').remove();

                                                                    if (json['error']) {
                                                                        $('.container').prepend(
                                                                            '<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' +
                                                                            json['error'] +
                                                                            '<button type="button" class="close" data-dismiss="alert">&times;</button></div>'
                                                                            );

                                                                        $('html, body').animate({
                                                                            scrollTop: 0
                                                                        }, 'slow');
                                                                    }

                                                                    if (json['redirect']) {
                                                                        location = json['redirect'];
                                                                    }
                                                                },
                                                                error: function(xhr, ajaxOptions, thrownError) {
                                                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                                                }
                                                            });
                                                        });
                                                        //
                                                        -->
                                                    </script>
                                                    <script type="text/javascript">
                                                        <!--
                                                        $('select[name=\'country_id\']').on('change', function() {
                                                            $.ajax({
                                                                url: 'index.php?route=extension/total/shipping/country&country_id=' + this.value,
                                                                dataType: 'json',
                                                                beforeSend: function() {
                                                                    $('select[name=\'country_id\']').prop('disabled', true);
                                                                },
                                                                complete: function() {
                                                                    $('select[name=\'country_id\']').prop('disabled', false);
                                                                },
                                                                success: function(json) {
                                                                    if (json['postcode_required'] == '1') {
                                                                        $('input[name=\'postcode\']').parent().parent().addClass('required');
                                                                    } else {
                                                                        $('input[name=\'postcode\']').parent().parent().removeClass('required');
                                                                    }

                                                                    html = '<option value=""> --- الرجاء الاختيار --- </option>';

                                                                    if (json['zone'] && json['zone'] != '') {
                                                                        for (i = 0; i < json['zone'].length; i++) {
                                                                            html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                                                                            if (json['zone'][i]['zone_id'] == '') {
                                                                                html += ' selected="selected"';
                                                                            }

                                                                            html += '>' + json['zone'][i]['name'] + '</option>';
                                                                        }
                                                                    } else {
                                                                        html += '<option value="0" selected="selected"> --- لا يوجد --- </option>';
                                                                    }

                                                                    $('select[name=\'zone_id\']').html(html);
                                                                },
                                                                error: function(xhr, ajaxOptions, thrownError) {
                                                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                                                }
                                                            });
                                                        });

                                                        $('select[name=\'country_id\']').trigger('change');
                                                        //
                                                        -->
                                                    </script>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-voucher">
                                            <div class="panel-heading">
                                                <h4 class="panel-title"><a href="#collapse-voucher"
                                                        data-toggle="collapse" data-parent="#accordion"
                                                        class="accordion-toggle">استخدم قسائم الهدايا <i
                                                            class="fa fa-caret-down"></i></a></h4>
                                            </div>
                                            <div id="collapse-voucher" class="panel-collapse collapse">
                                                <div class="panel-body form-group">
                                                    <label class="control-label" for="input-voucher">الرجاء ادخال رمز
                                                        قسيمة الهدايا</label>
                                                    <div class="input-group">
                                                        <input type="text" name="voucher" value=""
                                                            placeholder="الرجاء ادخال رمز قسيمة الهدايا"
                                                            id="input-voucher" class="form-control" />
                                                        <span class="input-group-btn">
                                                            <input type="submit" value="أرسل" id="button-voucher"
                                                                data-loading-text="جاري ..."
                                                                class="btn btn-primary" />
                                                        </span>
                                                    </div>
                                                    <script type="text/javascript">
                                                        <!--
                                                        $('#button-voucher').on('click', function() {
                                                            $.ajax({
                                                                url: 'index.php?route=extension/total/voucher/voucher',
                                                                type: 'post',
                                                                data: 'voucher=' + encodeURIComponent($('input[name=\'voucher\']').val()),
                                                                dataType: 'json',
                                                                beforeSend: function() {
                                                                    $('#button-voucher').button('loading');
                                                                },
                                                                complete: function() {
                                                                    $('#button-voucher').button('reset');
                                                                },
                                                                success: function(json) {
                                                                    $('.alert-dismissible').remove();

                                                                    if (json['error']) {
                                                                        $('.container').prepend(
                                                                            '<div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> ' +
                                                                            json['error'] +
                                                                            '<button type="button" class="close" data-dismiss="alert">&times;</button></div>'
                                                                            );

                                                                        $('html, body').animate({
                                                                            scrollTop: 0
                                                                        }, 'slow');
                                                                    }

                                                                    if (json['redirect']) {
                                                                        location = json['redirect'];
                                                                    }
                                                                },
                                                                error: function(xhr, ajaxOptions, thrownError) {
                                                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                                                }
                                                            });
                                                        });
                                                        //
                                                        -->
                                                    </script>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="cart-total">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td class="text-right"><strong>الاجمالي:</strong></td>
                                            <td class="text-right">15 ر.س</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right"><strong>الاجمالي النهائي:</strong></td>
                                            <td class="text-right">15 ر.س</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="tamara-promo" style="margin-bottom: 10px;"><tamara-widget
                                    id="tamara_promo_widget" type="tamara-summary" amount="15"
                                    inline-type="2"></tamara-widget>
                                <script>
                                    var tamaraWidgetConfig = {
                                        lang: "ar",
                                        country: "SA",
                                        publicKey: "dfc0cfd5-a0c6-4b07-b052-49335990a018"
                                    }
                                </script>
                                <script charset="utf-8" defer src="https://cdn.tamara.co/widget-v2/tamara-widget.js?t=1761676535"></script>
                            </div>
                            <style>
                                #tamara_promo_widget {
                                    text-align: right;
                                }
                            </style>
                            <div class="buttons clearfix">
                                <div class="pull-left"><a href="#?route=common/home"
                                        class="btn btn-default"><span>متابعة</span></a></div>
                                <div class="pull-right"><a
                                        href="#?route=checkout/checkout"
                                        class="btn btn-primary"><span>اتمام الطلب</span></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="bottom" class="bottom top-row">
            <div class="grid-rows">
                <div class="grid-row grid-row-bottom-1">
                    <div class="grid-cols">
                        <div class="grid-col grid-col-bottom-1-1">
                            <div class="grid-items">
                                <div class="grid-item grid-item-bottom-1-1-1">
                                    <div
                                        class="module module-products module-products-309 module-products-grid carousel-mode">
                                        <div class="module-body">
                                            <div class="module-item module-item-1 swiper-slide">
                                                <h3 class="title module-title">Purchased Together</h3>
                                                <div class="swiper"
                                                    data-items-per-row='{"c0":{"0":{"items":5,"spacing":20},"760":{"items":3,"spacing":20},"470":{"items":2,"spacing":10}},"c1":{"0":{"items":1,"spacing":20}},"c2":{"0":{"items":1,"spacing":20}},"sc":{"0":{"items":1,"spacing":20}}}'
                                                    data-options='{"speed":800,"autoplay":{"delay":4000},"pauseOnHover":true,"loop":false}'>
                                                    <div class="swiper-container">
                                                        <div class="swiper-wrapper product-grid">
                                                            <div class="product-layout swiper-slide has-extra-button">
                                                                <div class="product-thumb">
                                                                    <div class="image">
                                                                        <div class="quickview-button">
                                                                            <a class="btn btn-quickview"
                                                                                data-toggle="tooltip"
                                                                                data-tooltip-class="module-products-309 module-products-grid quickview-tooltip"
                                                                                data-placement="top" title="عرض سريع"
                                                                                onclick="quickview('201')"><span
                                                                                    class="btn-text">عرض
                                                                                    سريع</span></a>
                                                                        </div>

                                                                        <a href="#?route=product/product&amp;product_id=201"
                                                                            class="product-img ">
                                                                            <div>
                                                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/nnn/Untitled%20Project%20(7)-250x250.jpg"
                                                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/nnn/Untitled%20Project%20(7)-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/nnn/Untitled%20Project%20(7)-500x500.jpg 2x"
                                                                                    width="250" height="250"
                                                                                    alt="بالون هيليوم احمر"
                                                                                    title="بالون هيليوم احمر"
                                                                                    class="img-responsive img-first" />


                                                                            </div>
                                                                        </a>

                                                                        <div class="product-labels">
                                                                            <span
                                                                                class="product-label product-label-31 product-label-default"><b>الأكثر
                                                                                    طلباً</b></span>
                                                                        </div>

                                                                    </div>

                                                                    <div class="caption">

                                                                        <div class="name"><a
                                                                                href="#?route=product/product&amp;product_id=201">بالون
                                                                                هيليوم احمر</a></div>

                                                                        <div class="description">بالون هيليوم احمر..
                                                                        </div>

                                                                        <div class="price">
                                                                            <div>
                                                                                <span class="price-normal">5 ر.س</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="rating no-rating rating-hover">
                                                                            <div class="rating-stars">
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="buttons-wrapper">
                                                                            <div class="button-group">
                                                                                <div class="cart-group">
                                                                                    <div class="stepper">
                                                                                        <input type="text"
                                                                                            name="quantity"
                                                                                            value="1"
                                                                                            data-minimum="1"
                                                                                            class="form-control" />
                                                                                        <input type="hidden"
                                                                                            name="product_id"
                                                                                            value="201" />
                                                                                        <span>
                                                                                            <i
                                                                                                class="fa fa-angle-up"></i>
                                                                                            <i
                                                                                                class="fa fa-angle-down"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <a class="btn btn-cart"
                                                                                        onclick="cart.add('201', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                                                            class="btn-text">اضافة
                                                                                            للسلة</span></a>
                                                                                </div>

                                                                                <div class="wish-group">
                                                                                    <a class="btn btn-wishlist"
                                                                                        data-toggle="tooltip"
                                                                                        data-tooltip-class="module-products-309 module-products-grid wishlist-tooltip"
                                                                                        data-placement="top"
                                                                                        title="إضافة لرغباتي"
                                                                                        onclick="wishlist.add('201')"><span
                                                                                            class="btn-text">إضافة
                                                                                            لرغباتي</span></a>

                                                                                    <a class="btn btn-compare"
                                                                                        data-toggle="tooltip"
                                                                                        data-tooltip-class="module-products-309 module-products-grid compare-tooltip"
                                                                                        data-placement="top"
                                                                                        title="اضافة للمقارنة"
                                                                                        onclick="compare.add('201')"><span
                                                                                            class="btn-text">اضافة
                                                                                            للمقارنة</span></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="extra-group">
                                                                            <div>
                                                                                <a class="btn btn-extra btn-extra-46"
                                                                                    onclick="cart.add('201', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                                                    <span class="btn-text">اشتري
                                                                                        الآن</span>
                                                                                </a>
                                                                                <a class="btn btn-extra btn-extra-93"
                                                                                    href="javascript:open_popup(22)"
                                                                                    data-product_id="201"
                                                                                    data-product_url="#?route=product/product&amp;product_id=201"
                                                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                                                    <span class="btn-text">ارسال
                                                                                        استفسار</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-layout swiper-slide has-extra-button">
                                                                <div class="product-thumb">
                                                                    <div class="image">
                                                                        <div class="quickview-button">
                                                                            <a class="btn btn-quickview"
                                                                                data-toggle="tooltip"
                                                                                data-tooltip-class="module-products-309 module-products-grid quickview-tooltip"
                                                                                data-placement="top" title="عرض سريع"
                                                                                onclick="quickview('105')"><span
                                                                                    class="btn-text">عرض
                                                                                    سريع</span></a>
                                                                        </div>

                                                                        <a href="#?route=product/product&amp;product_id=105"
                                                                            class="product-img ">
                                                                            <div>
                                                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%202-3-250x250.jpg"
                                                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%202-3-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%202-3-500x500.jpg 2x"
                                                                                    width="250" height="250"
                                                                                    alt=" بوكيه البهجة"
                                                                                    title=" بوكيه البهجة"
                                                                                    class="img-responsive img-first" />


                                                                            </div>
                                                                        </a>

                                                                        <div class="product-labels">
                                                                            <span
                                                                                class="product-label product-label-31 product-label-default"><b>الأكثر
                                                                                    طلباً</b></span>
                                                                        </div>

                                                                    </div>

                                                                    <div class="caption">

                                                                        <div class="name"><a
                                                                                href="#?route=product/product&amp;product_id=105">
                                                                                بوكيه البهجة</a></div>

                                                                        <div class="description">بوكيه البهجة"أضف لمسة
                                                                            من البهجة إلى يومك أو يوم من تحب مع بوكيه
                                                                            البهجة، باقة مفعمة بالألوان
                                                                            والحياة."&nbsp;ملاحظة - الزهور موسمية نسبة
                                                                            التطابق من ٩٠ ا..</div>

                                                                        <div class="price">
                                                                            <div>
                                                                                <span class="price-normal">80
                                                                                    ر.س</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="rating no-rating rating-hover">
                                                                            <div class="rating-stars">
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="buttons-wrapper">
                                                                            <div class="button-group">
                                                                                <div class="cart-group">
                                                                                    <div class="stepper">
                                                                                        <input type="text"
                                                                                            name="quantity"
                                                                                            value="1"
                                                                                            data-minimum="1"
                                                                                            class="form-control" />
                                                                                        <input type="hidden"
                                                                                            name="product_id"
                                                                                            value="105" />
                                                                                        <span>
                                                                                            <i
                                                                                                class="fa fa-angle-up"></i>
                                                                                            <i
                                                                                                class="fa fa-angle-down"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <a class="btn btn-cart"
                                                                                        onclick="cart.add('105', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                                                            class="btn-text">اضافة
                                                                                            للسلة</span></a>
                                                                                </div>

                                                                                <div class="wish-group">
                                                                                    <a class="btn btn-wishlist"
                                                                                        data-toggle="tooltip"
                                                                                        data-tooltip-class="module-products-309 module-products-grid wishlist-tooltip"
                                                                                        data-placement="top"
                                                                                        title="إضافة لرغباتي"
                                                                                        onclick="wishlist.add('105')"><span
                                                                                            class="btn-text">إضافة
                                                                                            لرغباتي</span></a>

                                                                                    <a class="btn btn-compare"
                                                                                        data-toggle="tooltip"
                                                                                        data-tooltip-class="module-products-309 module-products-grid compare-tooltip"
                                                                                        data-placement="top"
                                                                                        title="اضافة للمقارنة"
                                                                                        onclick="compare.add('105')"><span
                                                                                            class="btn-text">اضافة
                                                                                            للمقارنة</span></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="extra-group">
                                                                            <div>
                                                                                <a class="btn btn-extra btn-extra-46"
                                                                                    onclick="cart.add('105', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                                                    <span class="btn-text">اشتري
                                                                                        الآن</span>
                                                                                </a>
                                                                                <a class="btn btn-extra btn-extra-93"
                                                                                    href="javascript:open_popup(22)"
                                                                                    data-product_id="105"
                                                                                    data-product_url="#?route=product/product&amp;product_id=105"
                                                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                                                    <span class="btn-text">ارسال
                                                                                        استفسار</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-layout swiper-slide has-extra-button">
                                                                <div class="product-thumb">
                                                                    <div class="image">
                                                                        <div class="quickview-button">
                                                                            <a class="btn btn-quickview"
                                                                                data-toggle="tooltip"
                                                                                data-tooltip-class="module-products-309 module-products-grid quickview-tooltip"
                                                                                data-placement="top" title="عرض سريع"
                                                                                onclick="quickview('90')"><span
                                                                                    class="btn-text">عرض
                                                                                    سريع</span></a>
                                                                        </div>

                                                                        <a href="#?route=product/product&amp;product_id=90"
                                                                            class="product-img ">
                                                                            <div>
                                                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/Store%202-16.jpg%20%20لحن%20الحب%20والورد-250x250.jpg"
                                                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/Store%202-16.jpg%20%20لحن%20الحب%20والورد-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/Store%202-16.jpg%20%20لحن%20الحب%20والورد-500x500.jpg 2x"
                                                                                    width="250" height="250"
                                                                                    alt="لحن الحب والورد"
                                                                                    title="لحن الحب والورد"
                                                                                    class="img-responsive img-first" />


                                                                            </div>
                                                                        </a>

                                                                        <div class="product-labels">
                                                                            <span
                                                                                class="product-label product-label-31 product-label-default"><b>الأكثر
                                                                                    طلباً</b></span>
                                                                        </div>

                                                                    </div>

                                                                    <div class="caption">

                                                                        <div class="name"><a
                                                                                href="#?route=product/product&amp;product_id=90">لحن
                                                                                الحب والورد</a></div>

                                                                        <div class="description">لحن الحب
                                                                            والورد&nbsp;&nbsp;باقة رائعة تعزف ألحان الحب
                                                                            والعاطفة من خلال زهورها المفعمة بالرومانسية
                                                                            والجمال.تصفح المزيد من باقات الورد من متجرنا
                                                                            تلال ال..</div>

                                                                        <div class="price">
                                                                            <div>
                                                                                <span class="price-normal">99
                                                                                    ر.س</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="rating no-rating rating-hover">
                                                                            <div class="rating-stars">
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="buttons-wrapper">
                                                                            <div class="button-group">
                                                                                <div class="cart-group">
                                                                                    <div class="stepper">
                                                                                        <input type="text"
                                                                                            name="quantity"
                                                                                            value="1"
                                                                                            data-minimum="1"
                                                                                            class="form-control" />
                                                                                        <input type="hidden"
                                                                                            name="product_id"
                                                                                            value="90" />
                                                                                        <span>
                                                                                            <i
                                                                                                class="fa fa-angle-up"></i>
                                                                                            <i
                                                                                                class="fa fa-angle-down"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <a class="btn btn-cart"
                                                                                        onclick="cart.add('90', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                                                            class="btn-text">اضافة
                                                                                            للسلة</span></a>
                                                                                </div>

                                                                                <div class="wish-group">
                                                                                    <a class="btn btn-wishlist"
                                                                                        data-toggle="tooltip"
                                                                                        data-tooltip-class="module-products-309 module-products-grid wishlist-tooltip"
                                                                                        data-placement="top"
                                                                                        title="إضافة لرغباتي"
                                                                                        onclick="wishlist.add('90')"><span
                                                                                            class="btn-text">إضافة
                                                                                            لرغباتي</span></a>

                                                                                    <a class="btn btn-compare"
                                                                                        data-toggle="tooltip"
                                                                                        data-tooltip-class="module-products-309 module-products-grid compare-tooltip"
                                                                                        data-placement="top"
                                                                                        title="اضافة للمقارنة"
                                                                                        onclick="compare.add('90')"><span
                                                                                            class="btn-text">اضافة
                                                                                            للمقارنة</span></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="extra-group">
                                                                            <div>
                                                                                <a class="btn btn-extra btn-extra-46"
                                                                                    onclick="cart.add('90', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                                                    <span class="btn-text">اشتري
                                                                                        الآن</span>
                                                                                </a>
                                                                                <a class="btn btn-extra btn-extra-93"
                                                                                    href="javascript:open_popup(22)"
                                                                                    data-product_id="90"
                                                                                    data-product_url="#?route=product/product&amp;product_id=90"
                                                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                                                    <span class="btn-text">ارسال
                                                                                        استفسار</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-layout swiper-slide has-extra-button">
                                                                <div class="product-thumb">
                                                                    <div class="image">
                                                                        <div class="quickview-button">
                                                                            <a class="btn btn-quickview"
                                                                                data-toggle="tooltip"
                                                                                data-tooltip-class="module-products-309 module-products-grid quickview-tooltip"
                                                                                data-placement="top"
                                                                                title="عرض سريع"
                                                                                onclick="quickview('252')"><span
                                                                                    class="btn-text">عرض
                                                                                    سريع</span></a>
                                                                        </div>

                                                                        <a href="#?route=product/product&amp;product_id=252"
                                                                            class="product-img ">
                                                                            <div>
                                                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/21.8/Untitled%20Project-250x250.jpg"
                                                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/21.8/Untitled%20Project-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/21.8/Untitled%20Project-500x500.jpg 2x"
                                                                                    width="250" height="250"
                                                                                    alt="باقة الورد الكلاسيكية"
                                                                                    title="باقة الورد الكلاسيكية"
                                                                                    class="img-responsive img-first" />


                                                                            </div>
                                                                        </a>

                                                                        <div class="product-labels">
                                                                            <span
                                                                                class="product-label product-label-29 product-label-default"><b>جديد</b></span>
                                                                        </div>

                                                                    </div>

                                                                    <div class="caption">

                                                                        <div class="name"><a
                                                                                href="#?route=product/product&amp;product_id=252">باقة
                                                                                الورد الكلاسيكية</a></div>

                                                                        <div class="description">مجموعة من الورود
                                                                            الوردية ذات الحواف الكريمية داخل تغليف أنيق
                                                                            باللونين الأبيض والأسود مع ربطة قوسية راقية،
                                                                            تصميم بسيط ومثالي لكل المناسبات&nbsp;ملاحظة
                                                                            ..</div>

                                                                        <div class="price">
                                                                            <div>
                                                                                <span class="price-normal">120
                                                                                    ر.س</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="rating no-rating rating-hover">
                                                                            <div class="rating-stars">
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="buttons-wrapper">
                                                                            <div class="button-group">
                                                                                <div class="cart-group">
                                                                                    <div class="stepper">
                                                                                        <input type="text"
                                                                                            name="quantity"
                                                                                            value="1"
                                                                                            data-minimum="1"
                                                                                            class="form-control" />
                                                                                        <input type="hidden"
                                                                                            name="product_id"
                                                                                            value="252" />
                                                                                        <span>
                                                                                            <i
                                                                                                class="fa fa-angle-up"></i>
                                                                                            <i
                                                                                                class="fa fa-angle-down"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <a class="btn btn-cart"
                                                                                        onclick="cart.add('252', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                                                            class="btn-text">اضافة
                                                                                            للسلة</span></a>
                                                                                </div>

                                                                                <div class="wish-group">
                                                                                    <a class="btn btn-wishlist"
                                                                                        data-toggle="tooltip"
                                                                                        data-tooltip-class="module-products-309 module-products-grid wishlist-tooltip"
                                                                                        data-placement="top"
                                                                                        title="إضافة لرغباتي"
                                                                                        onclick="wishlist.add('252')"><span
                                                                                            class="btn-text">إضافة
                                                                                            لرغباتي</span></a>

                                                                                    <a class="btn btn-compare"
                                                                                        data-toggle="tooltip"
                                                                                        data-tooltip-class="module-products-309 module-products-grid compare-tooltip"
                                                                                        data-placement="top"
                                                                                        title="اضافة للمقارنة"
                                                                                        onclick="compare.add('252')"><span
                                                                                            class="btn-text">اضافة
                                                                                            للمقارنة</span></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="extra-group">
                                                                            <div>
                                                                                <a class="btn btn-extra btn-extra-46"
                                                                                    onclick="cart.add('252', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                                                    <span class="btn-text">اشتري
                                                                                        الآن</span>
                                                                                </a>
                                                                                <a class="btn btn-extra btn-extra-93"
                                                                                    href="javascript:open_popup(22)"
                                                                                    data-product_id="252"
                                                                                    data-product_url="#?route=product/product&amp;product_id=252"
                                                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                                                    <span class="btn-text">ارسال
                                                                                        استفسار</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-layout swiper-slide has-extra-button">
                                                                <div class="product-thumb">
                                                                    <div class="image">
                                                                        <div class="quickview-button">
                                                                            <a class="btn btn-quickview"
                                                                                data-toggle="tooltip"
                                                                                data-tooltip-class="module-products-309 module-products-grid quickview-tooltip"
                                                                                data-placement="top"
                                                                                title="عرض سريع"
                                                                                onclick="quickview('206')"><span
                                                                                    class="btn-text">عرض
                                                                                    سريع</span></a>
                                                                        </div>

                                                                        <a href="#?route=product/product&amp;product_id=206"
                                                                            class="product-img ">
                                                                            <div>
                                                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%20ballon%20%20and%20mather%20day%207-250x250.jpg"
                                                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%20ballon%20%20and%20mather%20day%207-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%20ballon%20%20and%20mather%20day%207-500x500.jpg 2x"
                                                                                    width="250" height="250"
                                                                                    alt="بالون أحرف ٣٢ انش كبير ذهبي - نفخ هواء"
                                                                                    title="بالون أحرف ٣٢ انش كبير ذهبي - نفخ هواء"
                                                                                    class="img-responsive img-first" />


                                                                            </div>
                                                                        </a>


                                                                    </div>

                                                                    <div class="caption">

                                                                        <div class="name"><a
                                                                                href="#?route=product/product&amp;product_id=206">بالون
                                                                                أحرف ٣٢ انش كبير ذهبي - نفخ هواء</a>
                                                                        </div>

                                                                        <div class="description">بالون أحرف ٣٢ انش
                                                                            كبير ذهبي - نفخ هواء..</div>

                                                                        <div class="price">
                                                                            <div>
                                                                                <span class="price-normal">10
                                                                                    ر.س</span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="rating no-rating rating-hover">
                                                                            <div class="rating-stars">
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                                <span class="fa fa-stack"><i
                                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="buttons-wrapper">
                                                                            <div class="button-group">
                                                                                <div class="cart-group">
                                                                                    <div class="stepper">
                                                                                        <input type="text"
                                                                                            name="quantity"
                                                                                            value="1"
                                                                                            data-minimum="1"
                                                                                            class="form-control" />
                                                                                        <input type="hidden"
                                                                                            name="product_id"
                                                                                            value="206" />
                                                                                        <span>
                                                                                            <i
                                                                                                class="fa fa-angle-up"></i>
                                                                                            <i
                                                                                                class="fa fa-angle-down"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <a class="btn btn-cart"
                                                                                        onclick="cart.add('206', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                                                            class="btn-text">اضافة
                                                                                            للسلة</span></a>
                                                                                </div>

                                                                                <div class="wish-group">
                                                                                    <a class="btn btn-wishlist"
                                                                                        data-toggle="tooltip"
                                                                                        data-tooltip-class="module-products-309 module-products-grid wishlist-tooltip"
                                                                                        data-placement="top"
                                                                                        title="إضافة لرغباتي"
                                                                                        onclick="wishlist.add('206')"><span
                                                                                            class="btn-text">إضافة
                                                                                            لرغباتي</span></a>

                                                                                    <a class="btn btn-compare"
                                                                                        data-toggle="tooltip"
                                                                                        data-tooltip-class="module-products-309 module-products-grid compare-tooltip"
                                                                                        data-placement="top"
                                                                                        title="اضافة للمقارنة"
                                                                                        onclick="compare.add('206')"><span
                                                                                            class="btn-text">اضافة
                                                                                            للمقارنة</span></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="extra-group">
                                                                            <div>
                                                                                <a class="btn btn-extra btn-extra-46"
                                                                                    onclick="cart.add('206', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                                                    <span class="btn-text">اشتري
                                                                                        الآن</span>
                                                                                </a>
                                                                                <a class="btn btn-extra btn-extra-93"
                                                                                    href="javascript:open_popup(22)"
                                                                                    data-product_id="206"
                                                                                    data-product_url="#?route=product/product&amp;product_id=206"
                                                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                                                    <span class="btn-text">ارسال
                                                                                        استفسار</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="swiper-buttons">
                                                        <div class="swiper-button-prev"></div>
                                                        <div class="swiper-button-next"></div>
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        @include('website.layout.footer')

    </div><!-- .site-wrapper -->







@include('website.layout.script')



    @include('website.layout.up')

</body>

</html>
