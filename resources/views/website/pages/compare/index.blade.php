<!DOCTYPE html>
<html dir="rtl" lang="ar"
    class="desktop win chrome chrome141 webkit oc30 is-customer route-product-compare store-0 skin-1 desktop-header-active mobile-sticky layout-12"
    data-jb="185b08f7" data-jv="3.1.13.1" data-ov="3.0.3.9">

<head typeof="og:website">
    @include('website.layout.head')
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
            <li><a href="#?route=product/compare">مقارنة المنتجات</a></li>
        </ul>

        <div id="product-compare" class="container">
            <div class="alert alert-success alert-dismissible"><i class="fa fa-check-circle"></i> نجاح : لقد تم تعديل
                قائمة المقارنة !
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <div class="row">
                <div id="content" class="col-sm-12">
                    <h1 class="title page-title">مقارنة المنتجات</h1>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td colspan="3"><strong>تفاصيل المنتج</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="compare-name">
                                    <td>المنتج</td>
                                    <td><a
                                            href="#?route=product/product&amp;product_id=94"><strong>باقة
                                                الجمال الطبيعي</strong></a></td>
                                    <td><a
                                            href="#?route=product/product&amp;product_id=79"><strong>باقة
                                                العاطفة والورد</strong></a></td>
                                </tr>
                                <tr class="compare-image">
                                    <td>صورة</td>
                                    <td class="text-left"> <img
                                            src="https://rosehills.sa/image/cache/catalog/images/products/Store%202-19.jpg%20باقة%20الجمال%20الطبيعي-90x90.jpg"
                                            alt="باقة الجمال الطبيعي" title="باقة الجمال الطبيعي"
                                            class="img-thumbnail" /> </td>
                                    <td class="text-left"> <img
                                            src="https://rosehills.sa/image/cache/catalog/images/products/Store%202-6.jpg%20%20باقة%20العاطفة%20والورد-90x90.jpg"
                                            alt="باقة العاطفة والورد" title="باقة العاطفة والورد"
                                            class="img-thumbnail" /> </td>
                                </tr>
                                <tr class="compare-price">
                                    <td>السعر</td>
                                    <td class=""> 400 ر.س
                                    </td>
                                    <td class=""> 60 ر.س
                                    </td>
                                </tr>
                                <tr class="compare-model">
                                    <td>النوع</td>
                                    <td>BouqA0021</td>
                                    <td>BouqA0035</td>
                                </tr>
                                <tr class="compare-manufacturer">
                                    <td>الشركة</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="compare-availability">
                                    <td>حالة التوفر</td>
                                    <td>متوفر</td>
                                    <td>متوفر</td>
                                </tr>
                                <tr class="compare-rating">
                                    <td>التقييم</td>
                                    <td class="rating"> <span class="fa fa-stack"><i
                                                class="fa fa-star-o fa-stack-2x"></i></span> <span
                                            class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> <span
                                            class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> <span
                                            class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> <span
                                            class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> <br />
                                        (0 التقييمات)</td>
                                    <td class="rating"> <span class="fa fa-stack"><i
                                                class="fa fa-star-o fa-stack-2x"></i></span> <span
                                            class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> <span
                                            class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> <span
                                            class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> <span
                                            class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span> <br />
                                        (0 التقييمات)</td>
                                </tr>
                                <tr class="compare-summary">
                                    <td>الخلاصة</td>
                                    <td class="description">باقة الجمال الطبيعي&nbsp;زهور جميلة مستوحاة من جمال الطبيعة
                                        البكر، تجمع بين الرقي والعفوية في تصميم واحد.تصفح المزيد من باقات الورد من
                                        متجرنا تلال الورد للهدايا عن طريق الضغط هنا..</td>
                                    <td class="description">باقة العاطفة والورد&nbsp;توليفة ساحرة من الزهور التي تعبر
                                        عن الشغف والعاطفة، مما يجعلها هدية مثالية لمن نحب.تصفح المزيد من باقات الورد من
                                        متجرنا تلال الورد للهدايا عن طريق الضغط هنا..</td>
                                </tr>
                                <tr class="compare-weight">
                                    <td>الوزن</td>
                                    <td>0.00كلغ</td>
                                    <td>0.00كلغ</td>
                                </tr>
                                <tr class="compare-dimensions">
                                    <td>الابعاد (الطول x العرض x الارتفاع)</td>
                                    <td>0.00سم x 0.00سم x 0.00سم</td>
                                    <td>0.00سم x 0.00سم x 0.00سم</td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td class=" out-of-stock">
                                        <div class="compare-buttons">
                                            <button class="btn btn-primary btn-cart"
                                                onclick="cart.add('94', '1');"><span>اضافة للسلة</span></button>
                                            <a href="#?route=product/compare&amp;remove=94"
                                                class="btn btn-danger btn-remove"><span>حذف</span></a>
                                        </div>
                                    </td>
                                    <td class=" out-of-stock">
                                        <div class="compare-buttons">
                                            <button class="btn btn-primary btn-cart"
                                                onclick="cart.add('79', '1');"><span>اضافة للسلة</span></button>
                                            <a href="#?route=product/compare&amp;remove=79"
                                                class="btn btn-danger btn-remove"><span>حذف</span></a>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
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
