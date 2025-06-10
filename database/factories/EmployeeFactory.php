<?php
namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    private static int $onboardingCount = 0;

    public function definition(): array
    {
        $province = str_pad(fake()->numberBetween(31, 36), 2, '0', STR_PAD_LEFT);
        $city     = str_pad(fake()->numberBetween(1, 5), 2, '0', STR_PAD_LEFT);
        $district = str_pad(fake()->numberBetween(1, 10), 2, '0', STR_PAD_LEFT);

        $birthDate    = fake()->dateTimeBetween('-60 years', '-18 years');
        $birthDateStr = $birthDate->format('dmy');

        $sequence = str_pad(fake()->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);

        $nik = $province . $city . $district . $birthDateStr . $sequence;

        $isOnboarding = false;
        if (self::$onboardingCount < 50) {
            $isOnboarding = true;
            self::$onboardingCount++;
        }

        return [
            'nik'           => $nik,
            'name'          => fake()->name,
            'gender'        => fake()->randomElement(Gender::values()),
            'religion'      => fake()->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'location'      => fake()->randomElement(Location::values()),
            'is_onboarding' => $isOnboarding,
        ];
    }
}
