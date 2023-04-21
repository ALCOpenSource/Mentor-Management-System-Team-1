<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Console\Command;

class PopulateCityData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-city-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected function fetchData($filename, $download_url)
    {
        if (! file_exists(storage_path('app/'.$filename))) {
            // Download the data from $download_url and save it to storage/app/$filename
            $this->error($filename.' not found in storage/app');
            $this->info('Downloading '.$filename);
            file_put_contents(storage_path('app/'.$filename), file_get_contents($download_url));
            $this->info($filename.' downloaded');

            // If file still doesn't exist or is empty, exit
            if (! file_exists(storage_path('app/'.$filename)) || empty(file_get_contents(storage_path('app/'.$filename)))) {
                throw new \Exception($filename.' not found in storage/app');
            }
        }

        $this->info('Reading '.$filename);

        return json_decode(file_get_contents(storage_path('app/'.$filename)), true);
    }

    protected function fetchAllData()
    {
        // Download the data from https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/cities.json
        return $this->fetchData('country_states_cities.json', 'https://github.com/dr5hn/countries-states-cities-database/raw/master/countries%2Bstates%2Bcities.json');
    }

    protected function fetchCountryData()
    {
        // Download the data from https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries.json
        return $this->fetchData('countries.json', 'https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries.json');
    }

    /**
     * Populate the database with country, state and city data.
     *
     * @return void
     */
    protected function populateCities(array $cities, Country $country, State $state)
    {
        // Create cities
        foreach ($cities as $city) {
            $city_name = $city['name'];

            // Check if city exists
            if (callStatic(City::class, 'where', 'name', $city_name)->exists()) {
                // If verbose, show that city already exists
                if ($this->option('verbose')) {
                    $this->info($city_name.' already exists');
                }

                continue;
            }

            // Create city
            $city = callStatic(City::class, 'create', [
                'name' => $city_name,
                'state_id' => $state->id,
                'country_id' => $country->id,
            ]);

            if ($this->option('verbose')) {
                $this->info($city_name.' created');
            }
        }
    }

    /**
     * Populate the database with country, state and city data.
     *
     * @param array $data
     *
     * @return void
     */
    protected function populateStates(array $states, Country $country)
    {
        // Create states
        foreach ($states as $state) {
            $state_name = $state['name'];
            $state_code = $state['state_code'];
            $cities = $state['cities']; // Array

            // Check if state exists
            if (callStatic(State::class, 'where', 'name', $state_name)->exists()) {
                // If verbose, show that state already exists
                if ($this->option('verbose')) {
                    $this->info($state_name.' already exists');
                }

                continue;
            }

            // Create state
            $state = callStatic(State::class, 'create', [
                'name' => $state_name,
                'code' => $state_code,
                'country_id' => $country->id,
            ]);

            if ($this->option('verbose')) {
                $this->info($state_name.' created');
            }

            // Create cities
            $this->populateCities($cities, $country, $state);
        }
    }

    /**
     * Populate the database with country, state and city data.
     *
     * @return void
     */
    protected function populateCountries(array $countries)
    {
        // Add progress bar
        $bar = $this->output->createProgressBar(count($countries));

        foreach ($countries as $country) {
            $country_name = $country['name'];
            $country_code = $country['iso2'];
            $phone_code = $country['phone_code'];
            $currency = $country['currency'];
            $currency_symbol = $country['currency_symbol'];
            $region = $country['region'];
            $subregion = $country['subregion'];
            $timezones = $country['timezones']; // Array
            $states = $country['states']; // Array
            $capital = $country['capital'];

            // Check if country exists
            if (callStatic(Country::class, 'where', 'code', $country_code)->exists()) {
                // If verbose, show that country already exists
                if ($this->option('verbose')) {
                    $this->info($country_name.' already exists');
                }

                continue;
            }

            // Create country
            $country = callStatic(Country::class, 'create', [
                'name' => $country_name,
                'code' => $country_code,
                'currency' => $currency,
                'currency_symbol' => $currency_symbol,
                'currency_code' => $currency,
                'phone_code' => $phone_code,
                'timezones' => $timezones,
                'region' => $region,
                'subregion' => $subregion,
                'capital' => $capital,
            ]);

            if ($this->option('verbose')) {
                $this->info($country_name.' created');
            }

            // Create states
            $this->populateStates($states, $country);
            $bar->advance();
        }

        $bar->finish();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $countries = $this->fetchAllData();
        $this->populateCountries($countries);
    }
}
