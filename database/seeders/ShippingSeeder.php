<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShippingSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // GOVERNATES
        $governates = [
            ['name' => 'Cairo', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Giza', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Alexandria', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Aswan', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('governates')->insert($governates);

        // CITIES
        $cities = [
            ['name' => 'Nasr City', 'governate_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Heliopolis', 'governate_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => '6th of October', 'governate_id' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dokki', 'governate_id' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sidi Gaber', 'governate_id' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kom Ombo', 'governate_id' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('cities')->insert($cities);

        // LOCATIONS
        $locations = [
            ['name' => 'Makram Ebeid', 'city_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Abbas El Akkad', 'city_id' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'El Nozha', 'city_id' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sheikh Zayed', 'city_id' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'El Haram', 'city_id' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Smouha', 'city_id' => 5, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'El Shallal', 'city_id' => 6, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('locations')->insert($locations);

        // SHIPPING RATES
        $shippingRates = [
            ['location_id' => 1, 'rate' => 50.00, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['location_id' => 2, 'rate' => 60.00, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['location_id' => 3, 'rate' => 55.50, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['location_id' => 4, 'rate' => 65.25, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['location_id' => 5, 'rate' => 45.00, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['location_id' => 6, 'rate' => 70.00, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['location_id' => 7, 'rate' => 80.00, 'is_active' => false, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('shipping_rates')->insert($shippingRates);
    }
}
