<!DOCTYPE html>
<html dir="rtl" lang="ar"
    class="desktop win chrome chrome141 webkit oc30 is-customer route-account-account store-0 skin-1 desktop-header-active mobile-sticky layout-6 one-column column-right"
    data-jb="185b08f7" data-jv="3.1.13.1" data-ov="3.0.3.9">

<head typeof="og:website">
    @include('website.layout.accountHead')
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


        @include('website.layout.accountHeader')



        <ul class="breadcrumb">
            <li><a href="#?route=common/home"><i class="fa fa-home"></i></a></li>
            <li><a href="#?route=account/account">الحساب</a></li>
        </ul>

        <div id="account-account" class="container">
            <div class="row">
                <div id="content" class="account-page col-sm-9">
                    <h1 class="title page-title">حسابي</h1>

                    <div class="my-account">
                        <h2 class="title">حسابي</h2>
                        <ul class="list-unstyled account-list">
                            <li class="edit-info"><a href="#?route=account/edit">تحرير
                                    معلومات حسابك</a></li>
                            <li class="edit-pass"><a
                                    href="#?route=account/password">تغيير كلمة المرور</a>
                            </li>
                            <li class="edit-address"><a
                                    href="#?route=account/address">تعديل العناوين</a></li>
                            <li class="edit-wishlist"><a
                                    href="#?route=account/wishlist">تعديل قائمة رغباتي</a>
                            </li>
                        </ul>
                    </div>
                    <div class="my-orders">
                        <h2 class="title">طلباتي</h2>
                        <ul class="list-unstyled account-list">
                            <li class="edit-order"><a href="#?route=account/order">عرض
                                    سجل الطلبات</a></li>
                            <li class="edit-downloads"><a
                                    href="#?route=account/download">عرض ملفات التنزيل</a>
                            </li>
                            <li class="edit-rewards"><a
                                    href="#?route=account/reward">نقاط المكافآت الخاصة
                                    بك</a></li>
                            <li class="edit-returns"><a href="#?route=account/return">عرض
                                    طلبات الإرجاع الخاصة بك</a></li>
                            <li class="edit-transactions"><a
                                    href="#?route=account/transaction">عرض رصيدك
                                    المتوفر</a></li>
                            <li class="edit-recurring"><a
                                    href="#?route=account/recurring">المدفوعات
                                    المتكررة</a></li>
                        </ul>
                    </div>
                    <div class="my-affiliates">
                        <h2 class="title">حسابي في نظام العمولة</h2>
                        <ul class="list-unstyled account-list">
                            <li class="affiliate-add"><a
                                    href="#?route=account/affiliate/add">التسجيل في نظام
                                    العمولة</a></li>
                        </ul>
                    </div>
                    <div class="my-newsletter">
                        <h2 class="title">النشرة الاخبارية</h2>
                        <ul class="list-unstyled account-list">
                            <li><a href="#?route=account/newsletter">اشتراك / الغاء
                                    الاشتراك في القائمة البريدية</a></li>
                        </ul>
                    </div>
                </div>
                <aside id="column-right" class="side-column">
                    <div class="grid-rows">
                        <div class="grid-row grid-row-column-right-1">
                            <div class="grid-cols">
                                <div class="grid-col grid-col-column-right-1-1">
                                    <div class="grid-items">
                                        <div class="grid-item grid-item-column-right-1-1-1">
                                            <div class="accordion-menu accordion-menu-126">
                                                <h3 class="title module-title">قائمة الحساب</h3>
                                                <ul class="j-menu">
                                                    <li class="menu-item accordion-menu-item accordion-menu-item-1">
                                                        <a href="#?route=account/account">
                                                            <span class="links-text">حسابي</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-2">
                                                        <a href="#?route=account/address">
                                                            <span class="links-text">العناوين</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-3">
                                                        <a
                                                            href="#?route=account/wishlist">
                                                            <span class="links-text">قائمة الأمنيات</span><span
                                                                class="count-badge wishlist-badge">1</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-4">
                                                        <a href="#?route=account/order">
                                                            <span class="links-text">سجل الطلبات</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-6">
                                                        <a
                                                            href="#?route=account/recurring">
                                                            <span class="links-text">المدفوعات المتكررة</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-7">
                                                        <a href="#?route=account/reward">
                                                            <span class="links-text">نقاط المكافأة</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-8">
                                                        <a
                                                            href="#?route=account/return/add">
                                                            <span class="links-text">المرتجعات</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-9">
                                                        <a
                                                            href="#?route=account/transaction">
                                                            <span class="links-text">المعاملات</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-10">
                                                        <a
                                                            href="#?route=account/newsletter">
                                                            <span class="links-text">النشرات الإخباية</span>
                                                        </a>
                                                    </li>

                                                    <li class="menu-item accordion-menu-item accordion-menu-item-11 ">
                                                        <a>
                                                            <span class="links-text">قائمة مخصصة</span>
                                                            <span class="open-menu collapsed" data-toggle="collapse"
                                                                data-target="#collapse-69019efea5063"
                                                                role="heading"><i class="fa fa-plus"></i></span>
                                                        </a>
                                                        <div class="collapse " id="collapse-69019efea5063">
                                                            <ul class="j-menu">
                                                                <li class="menu-item accordion-menu-item-12">
                                                                    <a>
                                                                        <span class="links-text">Add or Remove</span>
                                                                    </a>
                                                                </li>

                                                                <li class="menu-item accordion-menu-item-13">
                                                                    <a>
                                                                        <span class="links-text">Any Menu Item</span>
                                                                    </a>
                                                                </li>

                                                                <li class="menu-item accordion-menu-item-14">
                                                                    <a>
                                                                        <span class="links-text">This is a Fully
                                                                            Customizable</span>
                                                                    </a>
                                                                </li>

                                                                <li class="menu-item accordion-menu-item-15">
                                                                    <a>
                                                                        <span class="links-text">Accordion Menu
                                                                            Module</span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </li>

                                                </ul>
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



        @include('website.layout.footer')

    </div><!-- .site-wrapper -->







    @include('website.layout.script')



    @include('website.layout.up')

</body>

</html>
