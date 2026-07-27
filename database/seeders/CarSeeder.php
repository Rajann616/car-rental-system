<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            // Maruti Suzuki
            [
                'brand' => 'Maruti Suzuki',
                'model' => 'Swift',
                'year' => 2024,
                'registration_number' => 'GJ-01-AB-1234',
                'fuel_type' => 'Petrol',
                'transmission' => 'Manual',
                'seating_capacity' => 5,
                'rental_price_per_day' => 1200,
                'description' => 'The all-new Maruti Suzuki Swift is a sporty hatchback that delivers excellent fuel efficiency and a fun driving experience. Perfect for city commutes in Ahmedabad.',
                'features' => ['Touchscreen Infotainment', 'Rear Parking Camera', 'Dual Airbags', 'ABS', 'LED DRLs', 'Keyless Entry'],
                'status' => 'Available',
            ],
            [
                'brand' => 'Maruti Suzuki',
                'model' => 'Baleno',
                'year' => 2024,
                'registration_number' => 'GJ-01-CD-5678',
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'rental_price_per_day' => 1500,
                'description' => 'Premium hatchback with heads-up display and 360-degree camera. Ideal for Ahmedabad to Udaipur road trips.',
                'features' => ['360° Camera', 'Heads-Up Display', 'Cruise Control', '6 Airbags', 'Wireless Charging', 'Sunroof'],
                'status' => 'Available',
            ],

            // Tata Motors
            [
                'brand' => 'Tata',
                'model' => 'Nexon',
                'year' => 2024,
                'registration_number' => 'GJ-01-EF-9012',
                'fuel_type' => 'Diesel',
                'transmission' => 'Manual',
                'seating_capacity' => 5,
                'rental_price_per_day' => 1800,
                'description' => 'India\'s safest compact SUV with a 5-star Global NCAP rating. Conquer Gujarat highways with confidence.',
                'features' => ['Ventilated Seats', 'Electric Sunroof', 'Air Purifier', '6 Airbags', 'Harman Audio', 'Connected Car Tech'],
                'status' => 'Available',
            ],
            [
                'brand' => 'Tata',
                'model' => 'Harrier',
                'year' => 2024,
                'registration_number' => 'GJ-01-GH-3456',
                'fuel_type' => 'Diesel',
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'rental_price_per_day' => 3000,
                'description' => 'Premium SUV built on Land Rover\'s D8 platform. Perfect for family trips from Ahmedabad to Goa or Kutch.',
                'features' => ['Panoramic Sunroof', 'JBL 10-Speaker System', 'ADAS', 'Terrain Modes', 'Ventilated Seats', '360° Camera'],
                'status' => 'Available',
            ],
            [
                'brand' => 'Tata',
                'model' => 'Nexon EV',
                'year' => 2024,
                'registration_number' => 'GJ-01-EV-0001',
                'fuel_type' => 'Electric',
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'rental_price_per_day' => 2200,
                'description' => 'India\'s best-selling electric SUV with 312 km range. Zero emission city drives around Ahmedabad.',
                'features' => ['Fast Charging', 'Connected Car', 'Air Purifier', 'Sunroof', 'Cruise Control', 'Drive Modes'],
                'status' => 'Available',
            ],

            // Hyundai
            [
                'brand' => 'Hyundai',
                'model' => 'Creta',
                'year' => 2024,
                'registration_number' => 'GJ-01-IJ-7890',
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'rental_price_per_day' => 2500,
                'description' => 'India\'s most popular SUV with dual-screen dashboard and ADAS Level 2. Great for SG Highway cruising.',
                'features' => ['Dual 10.25" Screens', 'ADAS Level 2', 'Ventilated Seats', 'Bose Audio', '6 Airbags', 'Panoramic Sunroof'],
                'status' => 'Available',
            ],
            [
                'brand' => 'Hyundai',
                'model' => 'Verna',
                'year' => 2024,
                'registration_number' => 'GJ-01-KL-1122',
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'rental_price_per_day' => 2000,
                'description' => 'Premium sedan with turbo engine and advanced tech. Executive travel around Ahmedabad and Gujarat.',
                'features' => ['Turbo Engine', 'Ventilated Seats', 'ADAS', 'Digital Cluster', 'Wireless Charging', 'Sunroof'],
                'status' => 'Available',
            ],

            // Mahindra
            [
                'brand' => 'Mahindra',
                'model' => 'Thar',
                'year' => 2024,
                'registration_number' => 'GJ-01-MN-3344',
                'fuel_type' => 'Diesel',
                'transmission' => 'Manual',
                'seating_capacity' => 4,
                'rental_price_per_day' => 3500,
                'description' => 'Iconic off-road SUV for adventure seekers. Take on the Great Rann of Kutch or the Saputara hills.',
                'features' => ['4x4', 'Convertible Top', 'Touchscreen', 'Cruise Control', 'Adventure Ready', 'All-Terrain Tires'],
                'status' => 'Available',
            ],
            [
                'brand' => 'Mahindra',
                'model' => 'XUV700',
                'year' => 2024,
                'registration_number' => 'GJ-01-OP-5566',
                'fuel_type' => 'Diesel',
                'transmission' => 'Automatic',
                'seating_capacity' => 7,
                'rental_price_per_day' => 3200,
                'description' => 'Tech-loaded 7-seater SUV with ADAS and panoramic views. Perfect for large family Gujarat tours.',
                'features' => ['ADAS', 'Panoramic Sunroof', 'Sony 3D Audio', 'Alexa Built-in', 'Flush Door Handles', 'Dual Airbags'],
                'status' => 'Available',
            ],

            // Kia
            [
                'brand' => 'Kia',
                'model' => 'Seltos',
                'year' => 2024,
                'registration_number' => 'GJ-01-QR-7788',
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'rental_price_per_day' => 2400,
                'description' => 'Feature-rich compact SUV with bold design and connected car technology. Navigate Ahmedabad in style.',
                'features' => ['10.25" HD Display', 'Bose Audio', 'Ventilated Seats', '6 Airbags', 'UVO Connect', 'Drive Modes'],
                'status' => 'Available',
            ],

            // Honda
            [
                'brand' => 'Honda',
                'model' => 'City',
                'year' => 2024,
                'registration_number' => 'GJ-01-ST-9900',
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'rental_price_per_day' => 2200,
                'description' => 'The trusted Honda City sedan with ADAS and Honda SENSING suite. Reliable for Ahmedabad business travel.',
                'features' => ['Honda SENSING', 'Lane Keep Assist', 'Sunroof', 'Wireless Charging', 'Connected Car', '6 Airbags'],
                'status' => 'Available',
            ],

            // Toyota
            [
                'brand' => 'Toyota',
                'model' => 'Innova Crysta',
                'year' => 2024,
                'registration_number' => 'GJ-01-UV-1133',
                'fuel_type' => 'Diesel',
                'transmission' => 'Automatic',
                'seating_capacity' => 7,
                'rental_price_per_day' => 3800,
                'description' => 'India\'s favourite MPV for family road trips. Spacious, reliable, and built for Gujarat highways.',
                'features' => ['Captain Seats', 'Auto Climate Control', 'Touchscreen', 'Rear AC Vents', 'Vehicle Stability', '7 Airbags'],
                'status' => 'Available',
            ],
            [
                'brand' => 'Toyota',
                'model' => 'Fortuner',
                'year' => 2024,
                'registration_number' => 'GJ-01-WX-4455',
                'fuel_type' => 'Diesel',
                'transmission' => 'Automatic',
                'seating_capacity' => 7,
                'rental_price_per_day' => 5000,
                'description' => 'Premium full-size SUV with 4x4 capability. Command the road from Ahmedabad to anywhere in India.',
                'features' => ['4x4', 'Kick Sensor Tailgate', 'Cooled Seats', 'JBL Audio', 'Wireless Charging', '7 Airbags'],
                'status' => 'Available',
            ],

            // MG Motor
            [
                'brand' => 'MG',
                'model' => 'Hector',
                'year' => 2024,
                'registration_number' => 'GJ-01-YZ-6677',
                'fuel_type' => 'Petrol',
                'transmission' => 'Automatic',
                'seating_capacity' => 5,
                'rental_price_per_day' => 2800,
                'description' => 'Internet-connected SUV with the largest infotainment screen in its class. Smart driving in Ahmedabad.',
                'features' => ['14" Infotainment', 'i-SMART Connected', 'Panoramic Sunroof', 'ADAS', 'PM 2.5 Filter', '6 Airbags'],
                'status' => 'Available',
            ],

            // Maintenance/Booked cars
            [
                'brand' => 'Maruti Suzuki',
                'model' => 'Ertiga',
                'year' => 2023,
                'registration_number' => 'GJ-01-AA-8899',
                'fuel_type' => 'CNG',
                'transmission' => 'Manual',
                'seating_capacity' => 7,
                'rental_price_per_day' => 1600,
                'description' => 'India\'s most popular MPV with factory-fitted CNG. Economical family vehicle for Ahmedabad and beyond.',
                'features' => ['Factory CNG', 'Touchscreen', 'Steering Controls', 'Dual Airbags', 'ABS', 'Roof Rails'],
                'status' => 'Maintenance',
            ],
        ];

        foreach ($cars as $carData) {
            Car::create($carData);
        }
    }
}
