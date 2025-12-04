<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
use App\Models\CategorySection;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Feature;
use App\Models\Group;
use App\Models\HomeStat;
use App\Models\Info;
use App\Models\OrderItem;
use App\Models\Partner;
use App\Models\Policy;
use App\Models\Product;
use App\Models\ProductSection;
use App\Models\Shipping;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('website.pages.home.index');
    }

    public function category()
    {
        return view('website.pages.category.index');
    }
    public function product()
    {
        return view('website.pages.product.index');
    }
    public function cart()
    {
        return view('website.pages.cart.index');
    }
    public function favorite()
    {
        return view('website.pages.favorite.index');
    }
    public function compare()
    {
        return view('website.pages.compare.index');
    }
    public function account()
    {
        return view('website.pages.account.index');
    }
    public function address()
    {
        return view('website.pages.address.index');
    }
    public function addAddress()
    {
        return view('website.pages.address.add');
    }
    public function editAddress()
    {
        return view('website.pages.address.edit');
    }
    public function about()
    {
        return view('website.pages.about.index');
    }
    public function shipping()
    {
        return view('website.pages.shipping.index');
    }
    public function privacy()
    {
        return view('website.pages.privacy.index');
    }
    public function policy()
    {
        return view('website.pages.policy.index');
    }


}
