<!DOCTYPE html>
<html dir="rtl" lang="ar"
    class="desktop win chrome chrome141 webkit oc30 is-guest route-product-category category-107 store-0 skin-1 desktop-header-active mobile-sticky layout-3 one-column column-right"
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
            <li><a href=""><i class="fa fa-home"></i></a></li>
            <li><a href="#?route=product/category&amp;path=107">باقات ورد</a></li>
        </ul>

        <div class="container">
            <div class="row">
                <div id="content">
                    <h1 class="title page-title">باقات ورد</h1>

                    <div class="main-products-wrapper">
                        <div class="products-filter">
                            <div class="grid-list">
                                <button id="btn-grid-view" class="view-btn active" data-toggle="tooltip"
                                    title="شبكة" data-view="grid"></button>
                                <button id="btn-list-view" class="view-btn " data-toggle="tooltip" title="قائمة"
                                    data-view="list"></button>
                                <a href="#?route=product/compare" id="compare-total"
                                    class="compare-btn"><span class="links-text">مقارنة المنتج</span><span
                                        class="count-badge count-zero ">0</span></a>
                            </div>
                            <div class="select-group">
                                <div class="input-group input-group-sm sort-by">
                                    <label class="input-group-addon" for="input-sort">الفرز بواسطة:</label>
                                    <select id="input-sort" class="form-control" onchange="location = this.value;"
                                        data-filter-sort="" data-filter-order="">
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;sort=p.sort_order&amp;order=ASC">
                                            الافتراضي</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;sort=pd.name&amp;order=ASC">
                                            الإسم من أ - ي</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;sort=pd.name&amp;order=DESC">
                                            الإسم من ي - أ</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;sort=p.price&amp;order=ASC">
                                            حسب السعر (منخفض &gt; مرتفع)</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;sort=p.price&amp;order=DESC">
                                            حسب السعر (مرتفع &gt; منخفض)</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;sort=rating&amp;order=DESC">
                                            تقييم (مرتفع)</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;sort=rating&amp;order=ASC">
                                            تقييم (منخفض)</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;sort=p.model&amp;order=ASC">
                                            النوع (أ - ي)</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;sort=p.model&amp;order=DESC">
                                            النوع (ي - أ)</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-sm per-page">
                                    <label class="input-group-addon" for="input-limit">عرض:</label>
                                    <select id="input-limit" class="form-control" onchange="location = this.value;"
                                        data-filter-limit="">
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;limit=20"
                                            selected="selected">20</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;limit=25">
                                            25</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;limit=50">
                                            50</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;limit=75">
                                            75</option>
                                        <option
                                            value="#?route=product/category&amp;path=107&amp;limit=100">
                                            100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="main-products product-grid">
                            <div class="product-layout  has-extra-button">
                                <div class="product-thumb">
                                    <div class="image">
                                        <div class="quickview-button">
                                            <a class="btn btn-quickview" data-toggle="tooltip"
                                                data-tooltip-class="product-grid quickview-tooltip"
                                                data-placement="top" title="عرض سريع"
                                                onclick="quickview('106')"><span class="btn-text">عرض سريع</span></a>
                                        </div>

                                        <a href="#?route=product/product&amp;path=107&amp;product_id=106"
                                            class="product-img ">
                                            <div>
                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%204-4.-250x250.jpg"
                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%204-4.-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%204-4.-500x500.jpg 2x"
                                                    width="250" height="250" alt="ورود الفرح "
                                                    title="ورود الفرح " class="img-responsive img-first" />


                                            </div>
                                        </a>


                                    </div>

                                    <div class="caption">

                                        <div class="name"><a
                                                href="#?route=product/product&amp;path=107&amp;product_id=106">ورود
                                                الفرح </a></div>

                                        <div class="description">&nbsp; &nbsp;ورود الفرح&nbsp;&nbsp;لأن الفرح هو أجمل
                                            الهدايا بوكيه&nbsp; "ورود الفرح" هو اختيارك المثالي لنشر السعادة في قلوب
                                            الأحبة&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;..</div>

                                        <div class="price">
                                            <div>
                                                <span class="price-normal">100 ر.س</span>
                                            </div>
                                        </div>

                                        <div class="rating no-rating ">
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
                                                        <input type="text" name="quantity" value="1"
                                                            data-minimum="1" class="form-control" />
                                                        <input type="hidden" name="product_id" value="106" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <a class="btn btn-cart"
                                                        onclick="cart.add('106', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                            class="btn-text">اضافة للسلة</span></a>
                                                </div>

                                                <div class="wish-group">
                                                    <a class="btn btn-wishlist" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid wishlist-tooltip"
                                                        data-placement="top" title="إضافة لرغباتي"
                                                        onclick="wishlist.add('106')"><span class="btn-text">إضافة
                                                            لرغباتي</span></a>

                                                    <a class="btn btn-compare" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid compare-tooltip"
                                                        data-placement="top" title="اضافة للمقارنة"
                                                        onclick="compare.add('106')"><span class="btn-text">اضافة
                                                            للمقارنة</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="extra-group">
                                            <div>
                                                <a class="btn btn-extra btn-extra-46"
                                                    onclick="cart.add('106', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                    <span class="btn-text">اشتري الآن</span>
                                                </a>
                                                <a class="btn btn-extra btn-extra-93" href="javascript:open_popup(22)"
                                                    data-product_id="106"
                                                    data-product_url="#?route=product/product&amp;path=107&amp;product_id=106"
                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                    <span class="btn-text">ارسال استفسار</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-layout  has-extra-button">
                                <div class="product-thumb">
                                    <div class="image">
                                        <div class="quickview-button">
                                            <a class="btn btn-quickview" data-toggle="tooltip"
                                                data-tooltip-class="product-grid quickview-tooltip"
                                                data-placement="top" title="عرض سريع"
                                                onclick="quickview('109')"><span class="btn-text">عرض سريع</span></a>
                                        </div>

                                        <a href="#?route=product/product&amp;path=107&amp;product_id=109"
                                            class="product-img ">
                                            <div>
                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%202-7%20new-250x250.jpg"
                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%202-7%20new-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%202-7%20new-500x500.jpg 2x"
                                                    width="250" height="250" alt="ورد الأمسيات"
                                                    title="ورد الأمسيات" class="img-responsive img-first" />


                                            </div>
                                        </a>

                                        <div class="product-labels">
                                            <span class="product-label product-label-31 product-label-default"><b>الأكثر
                                                    طلباً</b></span>
                                        </div>

                                    </div>

                                    <div class="caption">

                                        <div class="name"><a
                                                href="#?route=product/product&amp;path=107&amp;product_id=109">ورد
                                                الأمسيات</a></div>

                                        <div class="description">ورد الأمسيات"أضف لمسة خاصة لأمسيتك مع بوكيه "ورد
                                            الأمسيات"، باقة زهرية مثالية لأجمل اللحظات."&nbsp;ملاحظة - الزهور موسمية
                                            نسبة التطابق من ٩٠ الى ٩٥ بالمئة- في حال عدم توفر&nbsp; لون الورد المطلوب
                                            راح يتم استبداله ب لون اخر مناسب&nbsp;..</div>

                                        <div class="price">
                                            <div>
                                                <span class="price-normal">70 ر.س</span>
                                            </div>
                                        </div>

                                        <div class="rating no-rating ">
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
                                                        <input type="text" name="quantity" value="1"
                                                            data-minimum="1" class="form-control" />
                                                        <input type="hidden" name="product_id" value="109" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <a class="btn btn-cart"
                                                        onclick="cart.add('109', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                            class="btn-text">اضافة للسلة</span></a>
                                                </div>

                                                <div class="wish-group">
                                                    <a class="btn btn-wishlist" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid wishlist-tooltip"
                                                        data-placement="top" title="إضافة لرغباتي"
                                                        onclick="wishlist.add('109')"><span class="btn-text">إضافة
                                                            لرغباتي</span></a>

                                                    <a class="btn btn-compare" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid compare-tooltip"
                                                        data-placement="top" title="اضافة للمقارنة"
                                                        onclick="compare.add('109')"><span class="btn-text">اضافة
                                                            للمقارنة</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="extra-group">
                                            <div>
                                                <a class="btn btn-extra btn-extra-46"
                                                    onclick="cart.add('109', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                    <span class="btn-text">اشتري الآن</span>
                                                </a>
                                                <a class="btn btn-extra btn-extra-93" href="javascript:open_popup(22)"
                                                    data-product_id="109"
                                                    data-product_url="#?route=product/product&amp;path=107&amp;product_id=109"
                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                    <span class="btn-text">ارسال استفسار</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-layout  has-extra-button">
                                <div class="product-thumb">
                                    <div class="image">
                                        <div class="quickview-button">
                                            <a class="btn btn-quickview" data-toggle="tooltip"
                                                data-tooltip-class="product-grid quickview-tooltip"
                                                data-placement="top" title="عرض سريع"
                                                onclick="quickview('250')"><span class="btn-text">عرض سريع</span></a>
                                        </div>

                                        <a href="#?route=product/product&amp;path=107&amp;product_id=250"
                                            class="product-img ">
                                            <div>
                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/032025/Untitled%20Project%20(10)-250x250.jpg"
                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/032025/Untitled%20Project%20(10)-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/032025/Untitled%20Project%20(10)-500x500.jpg 2x"
                                                    width="250" height="250" alt="هيبة عشق" title="هيبة عشق"
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
                                                href="#?route=product/product&amp;path=107&amp;product_id=250">هيبة
                                                عشق</a></div>

                                        <div class="description">هيبة عشقباقة ورد أحمر فاخر مُغلف بورق أسود أنيق،
                                            بتنسيق يجمع بين الرقي والجرأة&nbsp;ملاحظة - الزهور موسمية نسبة التطابق من
                                            ٨٠&nbsp; الى&nbsp; ٩٠ بالمئة&nbsp;في حال عدم توفر&nbsp; لون الورد المطلوب
                                            راح يتم استبداله ب لون اخر مناسب&nbsp;..</div>

                                        <div class="price">
                                            <div>
                                                <span class="price-normal">300 ر.س</span>
                                            </div>
                                        </div>

                                        <div class="rating no-rating ">
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
                                                        <input type="text" name="quantity" value="1"
                                                            data-minimum="1" class="form-control" />
                                                        <input type="hidden" name="product_id" value="250" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <a class="btn btn-cart"
                                                        onclick="cart.add('250', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                            class="btn-text">اضافة للسلة</span></a>
                                                </div>

                                                <div class="wish-group">
                                                    <a class="btn btn-wishlist" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid wishlist-tooltip"
                                                        data-placement="top" title="إضافة لرغباتي"
                                                        onclick="wishlist.add('250')"><span class="btn-text">إضافة
                                                            لرغباتي</span></a>

                                                    <a class="btn btn-compare" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid compare-tooltip"
                                                        data-placement="top" title="اضافة للمقارنة"
                                                        onclick="compare.add('250')"><span class="btn-text">اضافة
                                                            للمقارنة</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="extra-group">
                                            <div>
                                                <a class="btn btn-extra btn-extra-46"
                                                    onclick="cart.add('250', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                    <span class="btn-text">اشتري الآن</span>
                                                </a>
                                                <a class="btn btn-extra btn-extra-93" href="javascript:open_popup(22)"
                                                    data-product_id="250"
                                                    data-product_url="#?route=product/product&amp;path=107&amp;product_id=250"
                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                    <span class="btn-text">ارسال استفسار</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-layout  has-extra-button">
                                <div class="product-thumb">
                                    <div class="image">
                                        <div class="quickview-button">
                                            <a class="btn btn-quickview" data-toggle="tooltip"
                                                data-tooltip-class="product-grid quickview-tooltip"
                                                data-placement="top" title="عرض سريع"
                                                onclick="quickview('228')"><span class="btn-text">عرض سريع</span></a>
                                        </div>

                                        <a href="#?route=product/product&amp;path=107&amp;product_id=228"
                                            class="product-img ">
                                            <div>
                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/nnn/Copy%20of%20Store%20ballon%20%20and%20mather%20day%20-250x250.jpg"
                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/nnn/Copy%20of%20Store%20ballon%20%20and%20mather%20day%20-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/nnn/Copy%20of%20Store%20ballon%20%20and%20mather%20day%20-500x500.jpg 2x"
                                                    width="250" height="250" alt="همسات الغرام"
                                                    title="همسات الغرام" class="img-responsive img-first" />


                                            </div>
                                        </a>

                                        <div class="product-labels">
                                            <span
                                                class="product-label product-label-29 product-label-default"><b>جديد</b></span>
                                        </div>

                                    </div>

                                    <div class="caption">

                                        <div class="name"><a
                                                href="#?route=product/product&amp;path=107&amp;product_id=228">همسات
                                                الغرام</a></div>

                                        <div class="description">همسات الغرامباقة ساحرة تحمل في طياتها عشقًا نقيًا،
                                            تجمع بين الورود الحمراء الدافئة والوردية الرقيقة في تناغم يفيض بالمحبة.
                                            مثالية لتكون لغة قلبك في المناسبات الرومانسية&nbsp;ملاحظة - الزهور موسمية
                                            نسبة التطابق من ٨٠&nbsp; الى&nbsp; ٩٠ بالمئةفي حال عدم توفر&nbsp; لون الورد
                                            المطلوب راح يتم استبداله ب ..</div>

                                        <div class="price">
                                            <div>
                                                <span class="price-normal">90 ر.س</span>
                                            </div>
                                        </div>

                                        <div class="rating no-rating ">
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
                                                        <input type="text" name="quantity" value="1"
                                                            data-minimum="1" class="form-control" />
                                                        <input type="hidden" name="product_id" value="228" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <a class="btn btn-cart"
                                                        onclick="cart.add('228', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                            class="btn-text">اضافة للسلة</span></a>
                                                </div>

                                                <div class="wish-group">
                                                    <a class="btn btn-wishlist" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid wishlist-tooltip"
                                                        data-placement="top" title="إضافة لرغباتي"
                                                        onclick="wishlist.add('228')"><span class="btn-text">إضافة
                                                            لرغباتي</span></a>

                                                    <a class="btn btn-compare" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid compare-tooltip"
                                                        data-placement="top" title="اضافة للمقارنة"
                                                        onclick="compare.add('228')"><span class="btn-text">اضافة
                                                            للمقارنة</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="extra-group">
                                            <div>
                                                <a class="btn btn-extra btn-extra-46"
                                                    onclick="cart.add('228', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                    <span class="btn-text">اشتري الآن</span>
                                                </a>
                                                <a class="btn btn-extra btn-extra-93" href="javascript:open_popup(22)"
                                                    data-product_id="228"
                                                    data-product_url="#?route=product/product&amp;path=107&amp;product_id=228"
                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                    <span class="btn-text">ارسال استفسار</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-layout  has-extra-button">
                                <div class="product-thumb">
                                    <div class="image">
                                        <div class="quickview-button">
                                            <a class="btn btn-quickview" data-toggle="tooltip"
                                                data-tooltip-class="product-grid quickview-tooltip"
                                                data-placement="top" title="عرض سريع"
                                                onclick="quickview('245')"><span class="btn-text">عرض سريع</span></a>
                                        </div>

                                        <a href="#?route=product/product&amp;path=107&amp;product_id=245"
                                            class="product-img ">
                                            <div>
                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/032025/new,,,%20(3)-250x250.jpg"
                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/032025/new,,,%20(3)-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/032025/new,,,%20(3)-500x500.jpg 2x"
                                                    width="250" height="250" alt="نور فيوليت"
                                                    title="نور فيوليت" class="img-responsive img-first" />


                                            </div>
                                        </a>

                                        <div class="product-labels">
                                            <span
                                                class="product-label product-label-29 product-label-default"><b>جديد</b></span>
                                            <span class="product-label product-label-31 product-label-default"><b>الأكثر
                                                    طلباً</b></span>
                                        </div>

                                    </div>

                                    <div class="caption">

                                        <div class="name"><a
                                                href="#?route=product/product&amp;path=107&amp;product_id=245">نور
                                                فيوليت</a></div>

                                        <div class="description">نور فيوليتتنسيق فخم يجمع بين نور الورود&nbsp;وبريق
                                            الزهور البنفسجية، مغلف بغلاف أبيض نقي يضفي إحساسًا بالرقي والصفاء مع
                                            كيك&nbsp;&nbsp;ملاحظة - الزهور موسمية نسبة التطابق من ٨٠&nbsp; الى&nbsp; ٩٠
                                            بالمئة&nbsp;الكيكه&nbsp;ولون الكيكة قد يختلف بحسب المتوفرفي حال عدم
                                            توفر&nbsp; لون الورد المطلوب راح يتم..</div>

                                        <div class="price">
                                            <div>
                                                <span class="price-normal">190 ر.س</span>
                                            </div>
                                        </div>

                                        <div class="rating no-rating ">
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
                                                        <input type="text" name="quantity" value="1"
                                                            data-minimum="1" class="form-control" />
                                                        <input type="hidden" name="product_id" value="245" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <a class="btn btn-cart"
                                                        onclick="cart.add('245', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                            class="btn-text">اضافة للسلة</span></a>
                                                </div>

                                                <div class="wish-group">
                                                    <a class="btn btn-wishlist" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid wishlist-tooltip"
                                                        data-placement="top" title="إضافة لرغباتي"
                                                        onclick="wishlist.add('245')"><span class="btn-text">إضافة
                                                            لرغباتي</span></a>

                                                    <a class="btn btn-compare" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid compare-tooltip"
                                                        data-placement="top" title="اضافة للمقارنة"
                                                        onclick="compare.add('245')"><span class="btn-text">اضافة
                                                            للمقارنة</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="extra-group">
                                            <div>
                                                <a class="btn btn-extra btn-extra-46"
                                                    onclick="cart.add('245', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                    <span class="btn-text">اشتري الآن</span>
                                                </a>
                                                <a class="btn btn-extra btn-extra-93"
                                                    href="javascript:open_popup(22)" data-product_id="245"
                                                    data-product_url="#?route=product/product&amp;path=107&amp;product_id=245"
                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                    <span class="btn-text">ارسال استفسار</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-layout  has-extra-button">
                                <div class="product-thumb">
                                    <div class="image">
                                        <div class="quickview-button">
                                            <a class="btn btn-quickview" data-toggle="tooltip"
                                                data-tooltip-class="product-grid quickview-tooltip"
                                                data-placement="top" title="عرض سريع"
                                                onclick="quickview('107')"><span class="btn-text">عرض
                                                    سريع</span></a>
                                        </div>

                                        <a href="#?route=product/product&amp;path=107&amp;product_id=107"
                                            class="product-img ">
                                            <div>
                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%202-5%20new....-250x250.jpg"
                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%202-5%20new....-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/Copy%20of%20Store%202-5%20new....-500x500.jpg 2x"
                                                    width="250" height="250" alt="نور الورود"
                                                    title="نور الورود" class="img-responsive img-first" />


                                            </div>
                                        </a>

                                        <div class="product-labels">
                                            <span class="product-label product-label-31 product-label-default"><b>الأكثر
                                                    طلباً</b></span>
                                        </div>

                                    </div>

                                    <div class="caption">

                                        <div class="name"><a
                                                href="#?route=product/product&amp;path=107&amp;product_id=107">نور
                                                الورود</a></div>

                                        <div class="description">نور الورود"أشرق يومك مع بوكيه "نور الورود الذي يجلب
                                            الدفء والفرح لكل مناسبة."&nbsp;ملاحظة - الزهور موسمية نسبة التطابق من ٩٠ الى
                                            ٩٥ بالمئة- في حال عدم توفر&nbsp; لون الورد المطلوب راح يتم استبداله ب لون
                                            اخر مناسب..</div>

                                        <div class="price">
                                            <div>
                                                <span class="price-normal">70 ر.س</span>
                                            </div>
                                        </div>

                                        <div class="rating no-rating ">
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
                                                        <input type="text" name="quantity" value="1"
                                                            data-minimum="1" class="form-control" />
                                                        <input type="hidden" name="product_id" value="107" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <a class="btn btn-cart"
                                                        onclick="cart.add('107', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                            class="btn-text">اضافة للسلة</span></a>
                                                </div>

                                                <div class="wish-group">
                                                    <a class="btn btn-wishlist" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid wishlist-tooltip"
                                                        data-placement="top" title="إضافة لرغباتي"
                                                        onclick="wishlist.add('107')"><span class="btn-text">إضافة
                                                            لرغباتي</span></a>

                                                    <a class="btn btn-compare" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid compare-tooltip"
                                                        data-placement="top" title="اضافة للمقارنة"
                                                        onclick="compare.add('107')"><span class="btn-text">اضافة
                                                            للمقارنة</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="extra-group">
                                            <div>
                                                <a class="btn btn-extra btn-extra-46"
                                                    onclick="cart.add('107', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                    <span class="btn-text">اشتري الآن</span>
                                                </a>
                                                <a class="btn btn-extra btn-extra-93"
                                                    href="javascript:open_popup(22)" data-product_id="107"
                                                    data-product_url="#?route=product/product&amp;path=107&amp;product_id=107"
                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                    <span class="btn-text">ارسال استفسار</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-layout  has-extra-button">
                                <div class="product-thumb">
                                    <div class="image">
                                        <div class="quickview-button">
                                            <a class="btn btn-quickview" data-toggle="tooltip"
                                                data-tooltip-class="product-grid quickview-tooltip"
                                                data-placement="top" title="عرض سريع"
                                                onclick="quickview('249')"><span class="btn-text">عرض
                                                    سريع</span></a>
                                        </div>

                                        <a href="#?route=product/product&amp;path=107&amp;product_id=249"
                                            class="product-img ">
                                            <div>
                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/032025/Untitled%20Project%20(9)-250x250.jpg"
                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/032025/Untitled%20Project%20(9)-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/032025/Untitled%20Project%20(9)-500x500.jpg 2x"
                                                    width="250" height="250" alt="نوتة حب" title="نوتة حب"
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
                                                href="#?route=product/product&amp;path=107&amp;product_id=249">نوتة
                                                حب</a></div>

                                        <div class="description">نوتة حب"باقة نوتة حب" تجمع أجمل درجات الأحمر في تنسيق
                                            أنيق من الورود المختارة بعناية، تعبّر عن الشغف والحنين، وكأن كل وردة فيها
                                            تهمس بلحن حب لا يُنسى&nbsp;ملاحظة - الزهور موسمية نسبة التطابق من ٨٠&nbsp;
                                            الى&nbsp; ٩٠ بالمئة&nbsp;في حال عدم توفر&nbsp; لون الورد المطلوب راح يتم
                                            استبداله ب لون اخر مناسب..</div>

                                        <div class="price">
                                            <div>
                                                <span class="price-normal">180 ر.س</span>
                                            </div>
                                        </div>

                                        <div class="rating no-rating ">
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
                                                        <input type="text" name="quantity" value="1"
                                                            data-minimum="1" class="form-control" />
                                                        <input type="hidden" name="product_id" value="249" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <a class="btn btn-cart"
                                                        onclick="cart.add('249', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                            class="btn-text">اضافة للسلة</span></a>
                                                </div>

                                                <div class="wish-group">
                                                    <a class="btn btn-wishlist" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid wishlist-tooltip"
                                                        data-placement="top" title="إضافة لرغباتي"
                                                        onclick="wishlist.add('249')"><span class="btn-text">إضافة
                                                            لرغباتي</span></a>

                                                    <a class="btn btn-compare" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid compare-tooltip"
                                                        data-placement="top" title="اضافة للمقارنة"
                                                        onclick="compare.add('249')"><span class="btn-text">اضافة
                                                            للمقارنة</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="extra-group">
                                            <div>
                                                <a class="btn btn-extra btn-extra-46"
                                                    onclick="cart.add('249', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                    <span class="btn-text">اشتري الآن</span>
                                                </a>
                                                <a class="btn btn-extra btn-extra-93"
                                                    href="javascript:open_popup(22)" data-product_id="249"
                                                    data-product_url="#?route=product/product&amp;path=107&amp;product_id=249"
                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                    <span class="btn-text">ارسال استفسار</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-layout  has-extra-button">
                                <div class="product-thumb">
                                    <div class="image">
                                        <div class="quickview-button">
                                            <a class="btn btn-quickview" data-toggle="tooltip"
                                                data-tooltip-class="product-grid quickview-tooltip"
                                                data-placement="top" title="عرض سريع"
                                                onclick="quickview('76')"><span class="btn-text">عرض سريع</span></a>
                                        </div>

                                        <a href="#?route=product/product&amp;path=107&amp;product_id=76"
                                            class="product-img ">
                                            <div>
                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/Store%202-3.jpg%20%20نسيم%20الورود%20العذب-250x250.jpg"
                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/Store%202-3.jpg%20%20نسيم%20الورود%20العذب-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/Store%202-3.jpg%20%20نسيم%20الورود%20العذب-500x500.jpg 2x"
                                                    width="250" height="250" alt="نسيم الورود العذب"
                                                    title="نسيم الورود العذب" class="img-responsive img-first" />


                                            </div>
                                        </a>


                                    </div>

                                    <div class="caption">

                                        <div class="name"><a
                                                href="#?route=product/product&amp;path=107&amp;product_id=76">نسيم
                                                الورود العذب</a></div>

                                        <div class="description">نسيم الورود العذب&nbsp;تشكيلة مميزة من الزهور المنعشة
                                            التي تجلب عبق الربيع ولطف النسيم العليل، مثالية لإضفاء البهجة على أي
                                            مكان.تصفح المزيد من باقات الورد من متجرنا تلال الورد للهدايا عن طريق الضغط
                                            هنا..</div>

                                        <div class="price">
                                            <div>
                                                <span class="price-normal">150 ر.س</span>
                                            </div>
                                        </div>

                                        <div class="rating no-rating ">
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
                                                        <input type="text" name="quantity" value="1"
                                                            data-minimum="1" class="form-control" />
                                                        <input type="hidden" name="product_id" value="76" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <a class="btn btn-cart"
                                                        onclick="cart.add('76', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                            class="btn-text">اضافة للسلة</span></a>
                                                </div>

                                                <div class="wish-group">
                                                    <a class="btn btn-wishlist" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid wishlist-tooltip"
                                                        data-placement="top" title="إضافة لرغباتي"
                                                        onclick="wishlist.add('76')"><span class="btn-text">إضافة
                                                            لرغباتي</span></a>

                                                    <a class="btn btn-compare" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid compare-tooltip"
                                                        data-placement="top" title="اضافة للمقارنة"
                                                        onclick="compare.add('76')"><span class="btn-text">اضافة
                                                            للمقارنة</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="extra-group">
                                            <div>
                                                <a class="btn btn-extra btn-extra-46"
                                                    onclick="cart.add('76', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                    <span class="btn-text">اشتري الآن</span>
                                                </a>
                                                <a class="btn btn-extra btn-extra-93"
                                                    href="javascript:open_popup(22)" data-product_id="76"
                                                    data-product_url="#?route=product/product&amp;path=107&amp;product_id=76"
                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                    <span class="btn-text">ارسال استفسار</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-layout  has-extra-button">
                                <div class="product-thumb">
                                    <div class="image">
                                        <div class="quickview-button">
                                            <a class="btn btn-quickview" data-toggle="tooltip"
                                                data-tooltip-class="product-grid quickview-tooltip"
                                                data-placement="top" title="عرض سريع"
                                                onclick="quickview('225')"><span class="btn-text">عرض
                                                    سريع</span></a>
                                        </div>

                                        <a href="#?route=product/product&amp;path=107&amp;product_id=225"
                                            class="product-img ">
                                            <div>
                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/nnn/Copy%20of%20Store%20ballon%20%20and%20mather%20day%205-250x250.jpg"
                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/nnn/Copy%20of%20Store%20ballon%20%20and%20mather%20day%205-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/nnn/Copy%20of%20Store%20ballon%20%20and%20mather%20day%205-500x500.jpg 2x"
                                                    width="250" height="250" alt="لهيب الحب"
                                                    title="لهيب الحب" class="img-responsive img-first" />


                                            </div>
                                        </a>

                                        <div class="product-labels">
                                            <span
                                                class="product-label product-label-29 product-label-default"><b>جديد</b></span>
                                            <span class="product-label product-label-31 product-label-default"><b>الأكثر
                                                    طلباً</b></span>
                                        </div>

                                    </div>

                                    <div class="caption">

                                        <div class="name"><a
                                                href="#?route=product/product&amp;path=107&amp;product_id=225">لهيب
                                                الحب</a></div>

                                        <div class="description">لهيب الحبباقة ساحرة من الورود الحمراء الفاخرة، ملفوفة
                                            بغلاف أسود أنيق يضفي لمسة من الغموض والفخامة. تعبر عن الشغف، الرومانسية،
                                            والمشاعر العميقة، مما يجعلها الهدية المثالية للتعبير عن حبك بكل جرأة
                                            وأناقة&nbsp;&nbsp;ملاحظة - الزهور موسمية نسبة التطابق من ٨٠&nbsp; الى&nbsp;
                                            ٩٠ بالمئة -في حال عدم توفر&n..</div>

                                        <div class="price">
                                            <div>
                                                <span class="price-normal">270 ر.س</span>
                                            </div>
                                        </div>

                                        <div class="rating no-rating ">
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
                                                        <input type="text" name="quantity" value="1"
                                                            data-minimum="1" class="form-control" />
                                                        <input type="hidden" name="product_id" value="225" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <a class="btn btn-cart"
                                                        onclick="cart.add('225', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                            class="btn-text">اضافة للسلة</span></a>
                                                </div>

                                                <div class="wish-group">
                                                    <a class="btn btn-wishlist" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid wishlist-tooltip"
                                                        data-placement="top" title="إضافة لرغباتي"
                                                        onclick="wishlist.add('225')"><span class="btn-text">إضافة
                                                            لرغباتي</span></a>

                                                    <a class="btn btn-compare" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid compare-tooltip"
                                                        data-placement="top" title="اضافة للمقارنة"
                                                        onclick="compare.add('225')"><span class="btn-text">اضافة
                                                            للمقارنة</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="extra-group">
                                            <div>
                                                <a class="btn btn-extra btn-extra-46"
                                                    onclick="cart.add('225', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                    <span class="btn-text">اشتري الآن</span>
                                                </a>
                                                <a class="btn btn-extra btn-extra-93"
                                                    href="javascript:open_popup(22)" data-product_id="225"
                                                    data-product_url="#?route=product/product&amp;path=107&amp;product_id=225"
                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                    <span class="btn-text">ارسال استفسار</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-layout  has-extra-button">
                                <div class="product-thumb">
                                    <div class="image">
                                        <div class="quickview-button">
                                            <a class="btn btn-quickview" data-toggle="tooltip"
                                                data-tooltip-class="product-grid quickview-tooltip"
                                                data-placement="top" title="عرض سريع"
                                                onclick="quickview('101')"><span class="btn-text">عرض
                                                    سريع</span></a>
                                        </div>

                                        <a href="#?route=product/product&amp;path=107&amp;product_id=101"
                                            class="product-img ">
                                            <div>
                                                <img src="https://rosehills.sa/image/cache/catalog/images/products/Store%202-27.jpg%20%20لمسة%20الورود%20الفاتنة-250x250.jpg"
                                                    srcset="https://rosehills.sa/image/cache/catalog/images/products/Store%202-27.jpg%20%20لمسة%20الورود%20الفاتنة-250x250.jpg 1x, https://rosehills.sa/image/cache/catalog/images/products/Store%202-27.jpg%20%20لمسة%20الورود%20الفاتنة-500x500.jpg 2x"
                                                    width="250" height="250" alt="لمسة الورود الفاتنة"
                                                    title="لمسة الورود الفاتنة" class="img-responsive img-first" />


                                            </div>
                                        </a>

                                        <div class="product-labels">
                                            <span class="product-label product-label-31 product-label-default"><b>الأكثر
                                                    طلباً</b></span>
                                        </div>

                                    </div>

                                    <div class="caption">

                                        <div class="name"><a
                                                href="#?route=product/product&amp;path=107&amp;product_id=101">لمسة
                                                الورود الفاتنة</a></div>

                                        <div class="description">لمسة الورود الفاتنةباقة تجمع بين الجمال والفتنة،
                                            مثالية لإضفاء لمسة من الأناقة والتميز على أي مناسبة.تصفح المزيد من باقات
                                            الورد من متجرنا تلال الورد للهدايا عن طريق الضغط هنا..</div>

                                        <div class="price">
                                            <div>
                                                <span class="price-normal">70 ر.س</span>
                                            </div>
                                        </div>

                                        <div class="rating no-rating ">
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
                                                        <input type="text" name="quantity" value="1"
                                                            data-minimum="1" class="form-control" />
                                                        <input type="hidden" name="product_id" value="101" />
                                                        <span>
                                                            <i class="fa fa-angle-up"></i>
                                                            <i class="fa fa-angle-down"></i>
                                                        </span>
                                                    </div>
                                                    <a class="btn btn-cart"
                                                        onclick="cart.add('101', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val());"
                                                        data-loading-text="<span class='btn-text'>اضافة للسلة</span>"><span
                                                            class="btn-text">اضافة للسلة</span></a>
                                                </div>

                                                <div class="wish-group">
                                                    <a class="btn btn-wishlist" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid wishlist-tooltip"
                                                        data-placement="top" title="إضافة لرغباتي"
                                                        onclick="wishlist.add('101')"><span class="btn-text">إضافة
                                                            لرغباتي</span></a>

                                                    <a class="btn btn-compare" data-toggle="tooltip"
                                                        data-tooltip-class="product-grid compare-tooltip"
                                                        data-placement="top" title="اضافة للمقارنة"
                                                        onclick="compare.add('101')"><span class="btn-text">اضافة
                                                            للمقارنة</span></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="extra-group">
                                            <div>
                                                <a class="btn btn-extra btn-extra-46"
                                                    onclick="cart.add('101', $(this).closest('.product-thumb').find('.button-group input[name=\'quantity\']').val(), true);"
                                                    data-loading-text="<span class='btn-text'>اشتري الآن</span>">
                                                    <span class="btn-text">اشتري الآن</span>
                                                </a>
                                                <a class="btn btn-extra btn-extra-93"
                                                    href="javascript:open_popup(22)" data-product_id="101"
                                                    data-product_url="#?route=product/product&amp;path=107&amp;product_id=101"
                                                    data-loading-text="<span class='btn-text'>ارسال استفسار</span>">
                                                    <span class="btn-text">ارسال استفسار</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pagination-results">
                            <div class="col-sm-6 text-left">
                                <ul class="pagination">
                                    <li class="active"><span>1</span></li>
                                    <li><a
                                            href="#?route=product/category&amp;path=107&amp;page=2">2</a>
                                    </li>
                                    <li><a
                                            href="#?route=product/category&amp;path=107&amp;page=3">3</a>
                                    </li>
                                    <li><a
                                            href="#?route=product/category&amp;path=107&amp;page=4">4</a>
                                    </li>
                                    <li><a href="#?route=product/category&amp;path=107&amp;page=2"
                                            class="next">&gt;</a></li>
                                    <li><a
                                            href="#?route=product/category&amp;path=107&amp;page=4">&gt;|</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6 text-right">عرض 1 الى 20 من 69 (4 صفحات)</div>
                        </div>
                    </div>
                </div>
                <aside id="column-right" class="side-column">
                    <div class="grid-rows">
                        <div class="grid-row grid-row-column-right-1">
                            <div class="grid-cols">
                                <div class="grid-col grid-col-column-right-1-1">
                                    <div class="grid-items">
                                        <div class="grid-item grid-item-column-right-1-1-1">
                                            <div class="accordion-menu accordion-menu-19">
                                                <h3 class="title module-title">All Categories</h3>
                                                <ul class="j-menu">
                                                    <li class="menu-item accordion-menu-item accordion-menu-item-1">
                                                        <a>
                                                            <span class="links-text">Home</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-2 ">
                                                        <a
                                                            href="#?route=product/category&amp;path=59">
                                                            <span class="links-text">Fashion</span>
                                                            <span class="open-menu collapsed" data-toggle="collapse"
                                                                data-target="#collapse-6900fc8b88940"
                                                                role="heading"><i class="fa fa-plus"></i></span>
                                                        </a>
                                                        <div class="collapse " id="collapse-6900fc8b88940">
                                                            <ul class="j-menu">
                                                                <li class="menu-item menu-item-c66 ">
                                                                    <a
                                                                        href="#?route=product/category&amp;path=59_66">
                                                                        <span class="links-text">المناسبات
                                                                            اليومية</span><span
                                                                            class="count-badge ">70</span>
                                                                        <span class="open-menu collapsed"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapse-6900fc8b88953"
                                                                            role="heading"><i
                                                                                class="fa fa-plus"></i></span>
                                                                    </a>
                                                                    <div class="collapse "
                                                                        id="collapse-6900fc8b88953">
                                                                        <ul class="j-menu">
                                                                            <li class="menu-item menu-item-c67">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_66_67">
                                                                                    <span class="links-text">التهنئة
                                                                                        بالمولود</span><span
                                                                                        class="count-badge ">7</span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="menu-item menu-item-c68">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_66_68">
                                                                                    <span class="links-text">الف
                                                                                        مبروك</span><span
                                                                                        class="count-badge ">12</span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="menu-item menu-item-c69">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_66_69">
                                                                                    <span class="links-text">مسكات
                                                                                        عروس</span><span
                                                                                        class="count-badge count-zero ">0</span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="menu-item menu-item-c70">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_66_70">
                                                                                    <span class="links-text">منزل
                                                                                        مبارك</span><span
                                                                                        class="count-badge ">47</span>
                                                                                </a>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </li>

                                                                <li class="menu-item menu-item-c71">
                                                                    <a
                                                                        href="#?route=product/category&amp;path=59_71">
                                                                        <span class="links-text">بدون
                                                                            مناسبة</span><span
                                                                            class="count-badge ">128</span>
                                                                    </a>
                                                                </li>

                                                                <li class="menu-item menu-item-c60 ">
                                                                    <a
                                                                        href="#?route=product/category&amp;path=59_60">
                                                                        <span class="links-text">المناسبات
                                                                            الموسمية</span><span
                                                                            class="count-badge ">151</span>
                                                                        <span class="open-menu collapsed"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapse-6900fc8b889bc"
                                                                            role="heading"><i
                                                                                class="fa fa-plus"></i></span>
                                                                    </a>
                                                                    <div class="collapse "
                                                                        id="collapse-6900fc8b889bc">
                                                                        <ul class="j-menu">
                                                                            <li class="menu-item menu-item-c65">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_60_65">
                                                                                    <span class="links-text">عيد
                                                                                        الأب</span><span
                                                                                        class="count-badge ">32</span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="menu-item menu-item-c64">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_60_64">
                                                                                    <span class="links-text">عيد
                                                                                        الأم</span><span
                                                                                        class="count-badge ">126</span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="menu-item menu-item-c61">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_60_61">
                                                                                    <span class="links-text">عيد
                                                                                        الحب</span><span
                                                                                        class="count-badge ">125</span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="menu-item menu-item-c63">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_60_63">
                                                                                    <span class="links-text">عيد
                                                                                        الزواج</span><span
                                                                                        class="count-badge ">122</span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="menu-item menu-item-c62">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_60_62">
                                                                                    <span class="links-text">عيد
                                                                                        الميلاد</span><span
                                                                                        class="count-badge ">127</span>
                                                                                </a>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </li>

                                                                <li class="menu-item menu-item-c72 ">
                                                                    <a
                                                                        href="#?route=product/category&amp;path=59_72">
                                                                        <span class="links-text">مشاعر</span><span
                                                                            class="count-badge ">135</span>
                                                                        <span class="open-menu collapsed"
                                                                            data-toggle="collapse"
                                                                            data-target="#collapse-6900fc8b88a0c"
                                                                            role="heading"><i
                                                                                class="fa fa-plus"></i></span>
                                                                    </a>
                                                                    <div class="collapse "
                                                                        id="collapse-6900fc8b88a0c">
                                                                        <ul class="j-menu">
                                                                            <li class="menu-item menu-item-c73">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_72_73">
                                                                                    <span
                                                                                        class="links-text">أحبك</span><span
                                                                                        class="count-badge ">113</span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="menu-item menu-item-c75">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_72_75">
                                                                                    <span class="links-text">الحمدلله
                                                                                        على السلامة</span><span
                                                                                        class="count-badge ">54</span>
                                                                                </a>
                                                                            </li>

                                                                            <li class="menu-item menu-item-c74">
                                                                                <a
                                                                                    href="#?route=product/category&amp;path=59_72_74">
                                                                                    <span
                                                                                        class="links-text">شكراً</span><span
                                                                                        class="count-badge ">114</span>
                                                                                </a>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>

                                                    <li
                                                        class="menu-item accordion-menu-item accordion-menu-item-3 open active">
                                                        <a
                                                            href="#?route=product/category&amp;path=107">
                                                            <span class="links-text">Bags</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-4 ">
                                                        <a
                                                            href="#?route=product/category&amp;path=109">
                                                            <span class="links-text">Health & Beauty</span>
                                                            <span class="open-menu collapsed" data-toggle="collapse"
                                                                data-target="#collapse-6900fc8b88a48"
                                                                role="heading"><i class="fa fa-plus"></i></span>
                                                        </a>
                                                        <div class="collapse " id="collapse-6900fc8b88a48">
                                                            <ul class="j-menu">
                                                                <li class="menu-item menu-item-c110">
                                                                    <a
                                                                        href="#?route=product/category&amp;path=109_110">
                                                                        <span class="links-text">بوكسات
                                                                            السعادة</span><span
                                                                            class="count-badge ">62</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-5">
                                                        <a>
                                                            <span class="links-text">Footwear</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-6">
                                                        <a
                                                            href="#?route=product/category&amp;path=69">
                                                            <span class="links-text">Electronics</span>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="grid-col grid-col-column-right-1-2">
                                    <div class="grid-items">
                                        <div class="grid-item grid-item-column-right-1-2-1">
                                            <div class="module module-filter module-filter-36">
                                                <h3 class="title module-title">
                                                    <span>تصفية</span>
                                                    <button class="reset-filter btn">مسح</button>
                                                    <a class="x"></a>
                                                </h3>
                                                <div class="module-body">
                                                    <div class="panel-group">
                                                        <div class="module-item module-item-p panel panel-active">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    <a href="#filter-68ee169c396b9-collapse-1"
                                                                        class="accordion-toggle "
                                                                        data-toggle="collapse" aria-expanded="true"
                                                                        data-filter="p">
                                                                        السعر
                                                                        <i class="fa fa-caret-down"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="panel-collapse collapse in"
                                                                id="filter-68ee169c396b9-collapse-1">
                                                                <div class="panel-body">
                                                                    <div class="filter-price"
                                                                        id="filter-filter-68ee169c396b9-1">
                                                                        <div class="range-slider">
                                                                            <input type="text"
                                                                                class="js-range-slider"
                                                                                value="" />
                                                                        </div>
                                                                        <div class="extra-controls">

                                                                            <input type="text"
                                                                                class="filter-price-min"
                                                                                name="min" data-min="5"
                                                                                value="5" />

                                                                            <span
                                                                                class="currency-symbol currency-right">
                                                                                ر.س</span>


                                                                            <input type="text"
                                                                                class="filter-price-max"
                                                                                name="max" data-max="400"
                                                                                value="400" />

                                                                            <span
                                                                                class="currency-symbol currency-right">
                                                                                ر.س</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="module-item module-item-t panel">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    <a href="#filter-68ee169c396b9-collapse-2"
                                                                        class="accordion-toggle collapsed"
                                                                        data-toggle="collapse" aria-expanded="false"
                                                                        data-filter="t">
                                                                        السمات
                                                                        <i class="fa fa-caret-down"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="panel-collapse collapse"
                                                                id="filter-68ee169c396b9-collapse-2">
                                                                <div class="panel-body">
                                                                    <div class="filter-checkbox">
                                                                        <label>
                                                                            <input type="checkbox" data-filter-trigger
                                                                                name="t"
                                                                                value="%D8%A8%D8%A7%D9%82%D8%A9%20%D9%88%D8%B1%D8%AF">
                                                                            <span class="links-text">باقة ورد</span>
                                                                            <span class="count-badge">40</span>
                                                                        </label>
                                                                        <label>
                                                                            <input type="checkbox" data-filter-trigger
                                                                                name="t"
                                                                                value="%D8%A8%D8%A7%D9%82%D9%87%20%D9%88%D8%B1%D8%AF">
                                                                            <span class="links-text">باقه ورد</span>
                                                                            <span class="count-badge">9</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="module-item module-item-q panel panel-active">
                                                            <div class="panel-heading">
                                                                <div class="panel-title">
                                                                    <a href="#filter-68ee169c396b9-collapse-3"
                                                                        class="accordion-toggle "
                                                                        data-toggle="collapse" aria-expanded="true"
                                                                        data-filter="q">
                                                                        التوفر
                                                                        <i class="fa fa-caret-down"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="panel-collapse collapse in"
                                                                id="filter-68ee169c396b9-collapse-3">
                                                                <div class="panel-body">
                                                                    <div class="filter-checkbox">
                                                                        <label>
                                                                            <input type="checkbox" data-filter-trigger
                                                                                name="q" value="1">
                                                                            <span class="links-text">في المخزن</span>
                                                                            <span class="count-badge">69</span>
                                                                        </label>
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
                        </div>
                    </div>

                </aside>
            </div>
        </div>
        <script type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"WebSite","url":"https:\/\/rosehills.sa\/","name":"\u062a\u0644\u0627\u0644 \u0627\u0644\u0648\u0631\u062f \u0644\u0644\u0647\u062f\u0627\u064a\u0627","description":"\u0645\u062a\u062c\u0631 \u062a\u0644\u0627\u0644 \u0627\u0644\u0648\u0631\u062f \u0627\u0643\u0628\u0631 \u0645\u062a\u062c\u0631 \u0644\u0644\u0648\u0631\u062f \u0648 \u0627\u0644\u0647\u062f\u0627\u064a\u0627 \u0648\u0643\u0648\u0634 \u0627\u0644\u0627\u0641\u0631\u0627\u062d \u0648 \u062a\u0646\u0633\u064a\u0642 \u0627\u0644\u0645\u0646\u0627\u0633\u0628\u0627\u062a","potentialAction":{"@type":"SearchAction","target":"https:\/\/rosehills.sa\/index.php?route=product\/search&amp;search={search}","query-input":"required name=search"}}</script>
        <script type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"Organization","url":"https:\/\/rosehills.sa\/","logo":"https:\/\/rosehills.sa\/image\/cache\/catalog\/images\/logo\/HorizontalLogo-603x170.png"}</script>
        <script type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"@id":"https:\/\/rosehills.sa\/index.php?route=common\/home","name":"\u0627\u0644\u0631\u0626\u064a\u0633\u064a\u0629"}},{"@type":"ListItem","position":2,"item":{"@id":"https:\/\/rosehills.sa\/index.php?route=product\/category&amp;path=107","name":"\u0628\u0627\u0642\u0627\u062a \u0648\u0631\u062f"}}]}</script>



        @include('website.layout.footer')

    </div><!-- .site-wrapper -->







    @include('website.layout.script')



    @include('website.layout.up')

</body>

</html>
