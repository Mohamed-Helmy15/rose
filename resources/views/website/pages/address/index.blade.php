<!DOCTYPE html>
<html dir="rtl" lang="ar"
    class="desktop win chrome chrome141 webkit oc30 is-customer route-account-address store-0 skin-1 desktop-header-active mobile-sticky layout-6 one-column column-right"
    data-jb="185b08f7" data-jv="3.1.13.1" data-ov="3.0.3.9">

<head typeof="og:website">
    @include('website.layout.accountHead')
</head>

<body class="">



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
            <li><a href="#?route=account/address">دفتر العناوين</a></li>
        </ul>

        <div id="account-address" class="container">
            <div class="row">
                <div id="content" class="col-sm-9">
                    <h1 class="title page-title">قائمة دفتر العناوين</h1>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <td class="text-left">mohamed<br />ddsdfs<br />el mahallah el
                                    kobra<br />الرياض<br />السعودية</td>
                                <td class="text-right"><a
                                        href="#?route=account/address/edit&amp;address_id=93"
                                        class="btn btn-info">تحرير</a> <a
                                        href="#?route=account/address/delete&amp;address_id=93"
                                        class="btn btn-danger">حذف</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="buttons clearfix">
                        <div class="pull-left"><a href="#?route=account/account"
                                class="btn btn-default">رجوع</a></div>
                        <div class="pull-right"><a href="#?route=account/address/add"
                                class="btn btn-primary">عناوين جديدة</a></div>
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
                                                                data-target="#collapse-6901a082b2aae"
                                                                role="heading"><i class="fa fa-plus"></i></span>
                                                        </a>
                                                        <div class="collapse " id="collapse-6901a082b2aae">
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
