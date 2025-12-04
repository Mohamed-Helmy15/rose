<?php

namespace App\Http\Controllers;

use App\Models\Governate;
use App\Models\City;
use App\Models\Location;
use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    use \App\Traits\LogActivity;

    // Governates
    public function governates()
    {
        $governates = Governate::with('cities')->get();
        $total = $governates->count();
        $active = $governates->where('is_active', true)->count();
        $citiesCount = $governates->sum(fn($g) => $g->cities->count());

        return view('dashboard.shipping.governates.index', compact('governates', 'total', 'active', 'citiesCount'));
    }

    public function governateCreate()
    {
        return view('dashboard.shipping.governates.create');
    }

    public function governateStore(Request $request)
    {
        $request->validate([
            'governates' => 'required|array|min:1',
            'governates.*.name' => 'required|string|max:255|unique:governates,name',
            'governates.*.is_active' => 'nullable|in:1',
        ]);

        $created = [];
        foreach ($request->governates as $data) {
            $g = Governate::create([
                'name' => $data['name'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ]);
            $created[] = $g->name;
        }

        $this->logActivity('governates_created', "تم إنشاء محافظات: " . implode(', ', $created));

        return redirect()->route('shipping.governates.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم إنشاء ' . count($created) . ' محافظة بنجاح'
        ]);
    }

    public function governateShow(Governate $governate)
    {
        $governate->load('cities.locations.shippingRates');
        return view('dashboard.shipping.governates.show', compact('governate'));
    }

    public function governateEdit(Governate $governate)
    {
        return view('dashboard.shipping.governates.edit', compact('governate'));
    }

    public function governateUpdate(Request $request, Governate $governate)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:governates,name,' . $governate->id,
            'is_active' => 'nullable|in:1',
        ]);

        $oldName = $governate->name;
        $governate->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        $this->logActivity('governate_updated', "تم تعديل المحافظة من '{$oldName}' إلى '{$governate->name}'");

        return redirect()->route('shipping.governates.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم تحديث المحافظة بنجاح'
        ]);
    }

    public function governateDestroy(Governate $governate)
    {
        $name = $governate->name;
        $governate->delete();

        $this->logActivity('governate_deleted', "تم حذف المحافظة: {$name}");

        return redirect()->route('shipping.governates.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم حذف المحافظة بنجاح'
        ]);
    }

    // Cities
    public function cities()
    {
        $cities = City::with('governate')->get();
        $total = $cities->count();
        $active = $cities->where('is_active', true)->count();
        $governatesCount = $cities->pluck('governate')->unique('id')->count();

        return view('dashboard.shipping.cities.index', compact('cities', 'total', 'active', 'governatesCount'));
    }

    public function cityCreate()
    {
        $governates = Governate::where('is_active', true)->get();
        return view('dashboard.shipping.cities.create', compact('governates'));
    }

    public function cityStore(Request $request)
    {
        $request->validate([
            'cities' => 'required|array|min:1',
            'cities.*.name' => 'required|string|max:255',
            'cities.*.governate_id' => 'required|exists:governates,id',
            'cities.*.is_active' => 'nullable|in:1',
        ]);

        $created = [];
        foreach ($request->cities as $data) {
            $city = City::create([
                'name' => $data['name'],
                'governate_id' => $data['governate_id'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ]);
            $created[] = $city->name;
        }

        $this->logActivity('cities_created', "تم إنشاء مدن: " . implode(', ', $created));

        return redirect()->route('shipping.cities.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم إنشاء ' . count($created) . ' مدينة بنجاح'
        ]);
    }

    public function cityShow(City $city)
    {
        $city->load('governate', 'locations.shippingRates');
        return view('dashboard.shipping.cities.show', compact('city'));
    }

    public function cityEdit(City $city)
    {
        $governates = Governate::where('is_active', true)->get();
        return view('dashboard.shipping.cities.edit', compact('city', 'governates'));
    }

    public function cityUpdate(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'governate_id' => 'required|exists:governates,id',
            'is_active' => 'nullable|in:1',
        ]);

        $oldName = $city->name;
        $city->update([
            'name' => $request->name,
            'governate_id' => $request->governate_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        $this->logActivity('city_updated', "تم تعديل المدينة من {$oldName} إلى {$city->name}");

        return redirect()->route('shipping.cities.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم تحديث المدينة بنجاح'
        ]);
    }

    public function cityDestroy(City $city)
    {
        $name = $city->name;
        $city->delete();

        $this->logActivity('city_deleted', "تم حذف المدينة: {$name}");

        return redirect()->route('shipping.cities.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم حذف المدينة بنجاح'
        ]);
    }
    // Locations
    public function locations()
    {
        $locations = Location::with('city.governate', 'shippingRates')->get();
        $total = $locations->count();
        $active = $locations->where('is_active', true)->count();
        $citiesCount = $locations->pluck('city')->unique('id')->count();
        $ratesCount = $locations->sum(fn($l) => $l->shippingRates->count());

        return view('dashboard.shipping.locations.index', compact(
            'locations',
            'total',
            'active',
            'citiesCount',
            'ratesCount'
        ));
    }

    public function locationCreate()
    {
        $cities = City::where('is_active', true)->with('governate')->get();
        return view('dashboard.shipping.locations.create', compact('cities'));
    }

    public function locationStore(Request $request)
    {
        $request->validate([
            'locations' => 'required|array|min:1',
            'locations.*.name' => 'required|string|max:255',
            'locations.*.city_id' => 'required|exists:cities,id',
            'locations.*.is_active' => 'nullable|in:1',
        ]);

        $created = [];
        foreach ($request->locations as $data) {
            $loc = Location::create([
                'name' => $data['name'],
                'city_id' => $data['city_id'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ]);
            $created[] = $loc->name;
        }

        $this->logActivity('locations_created', "تم إنشاء أماكن: " . implode(', ', $created));

        return redirect()->route('shipping.locations.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم إنشاء ' . count($created) . ' مكان بنجاح'
        ]);
    }

    public function locationShow(Location $location)
    {
        $location->load('city.governate', 'shippingRates');
        return view('dashboard.shipping.locations.show', compact('location'));
    }

    public function locationEdit(Location $location)
    {
        $cities = City::where('is_active', true)->with('governate')->get();
        return view('dashboard.shipping.locations.edit', compact('location', 'cities'));
    }

    public function locationUpdate(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'is_active' => 'nullable|in:1',
        ]);

        $oldName = $location->name;
        $location->update([
            'name' => $request->name,
            'city_id' => $request->city_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        $this->logActivity('location_updated', "تم تعديل المكان من '{$oldName}' إلى '{$location->name}'");

        return redirect()->route('shipping.locations.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم تحديث المكان بنجاح'
        ]);
    }

    public function locationDestroy(Location $location)
    {
        $name = $location->name;
        $location->delete();

        $this->logActivity('location_deleted', "تم حذف المكان: {$name}");

        return redirect()->route('shipping.locations.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم حذف المكان بنجاح'
        ]);
    }

    // Shipping Rates
    public function shippingRates()
    {
        $totalShippingRates = ShippingRate::with('location.city.governate')->get();
        $shippingRates = ShippingRate::with('location.city.governate')->where('is_active', true)->get();
        // dd($shippingRates);
        $total = $totalShippingRates->count();
        $active = $shippingRates->where('is_active', true)->count();
        $avgRate = $shippingRates->avg('rate');
        $maxRate = $shippingRates->max('rate');
        $minRate = $shippingRates->min('rate');

        return view('dashboard.shipping.rates.index', compact(
            'shippingRates',
            'total',
            'active',
            'avgRate',
            'maxRate',
            'minRate'
        ));
    }

    public function shippingRateCreate()
    {
        $locations = Location::with('city.governate')
            ->where('is_active', true)
            ->get();
        return view('dashboard.shipping.rates.create', compact('locations'));
    }

    public function shippingRateStore(Request $request)
    {
        $request->validate([
            'rates' => 'required|array|min:1',
            'rates.*.location_id' => 'required|exists:locations,id|unique:shipping_rates,location_id',
            'rates.*.rate' => 'required|numeric|min:0',
            'rates.*.is_active' => 'nullable|in:1',
        ]);

        $created = [];
        foreach ($request->rates as $data) {
            $rate = ShippingRate::create([
                'location_id' => $data['location_id'],
                'rate' => $data['rate'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
            ]);
            $created[] = $rate->rate . ' جنيه';
        }

        $this->logActivity('shipping_rates_created', "تم إنشاء أسعار شحن: " . implode(', ', $created));

        return redirect()->route('shipping.rates.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم إنشاء ' . count($created) . ' سعر شحن بنجاح'
        ]);
    }

    public function shippingRateShow(ShippingRate $shippingRate)
    {
        $shippingRate->load('location.city.governate');
        return view('dashboard.shipping.rates.show', compact('shippingRate'));
    }

    public function shippingRateEdit(ShippingRate $shippingRate)
    {
        $locations = Location::with('city.governate')->where('is_active', true)->get();
        return view('dashboard.shipping.rates.edit', compact('shippingRate', 'locations'));
    }

    public function shippingRateUpdate(Request $request, ShippingRate $shippingRate)
    {
        $request->validate([
            'location_id' => 'required|exists:locations,id|unique:shipping_rates,location_id,' . $shippingRate->id,
            'rate' => 'required|numeric|min:0',
            'is_active' => 'nullable|in:1',
        ]);

        $oldRate = $shippingRate->rate;
        $shippingRate->update([
            'location_id' => $request->location_id,
            'rate' => $request->rate,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        $this->logActivity('shipping_rate_updated', "تم تعديل سعر الشحن من {$oldRate} إلى {$shippingRate->rate} جنيه");

        return redirect()->route('shipping.rates.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم تحديث سعر الشحن بنجاح'
        ]);
    }

    public function shippingRateDestroy(ShippingRate $shippingRate)
    {
        $rate = $shippingRate->rate;
        $shippingRate->delete();

        $this->logActivity('shipping_rate_deleted', "تم حذف سعر الشحن: {$rate} جنيه");

        return redirect()->route('shipping.rates.index')->with('toast', [
            'type' => 'bg-success',
            'message' => 'تم حذف سعر الشحن بنجاح'
        ]);
    }
}