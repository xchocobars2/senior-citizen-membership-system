<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $stats = [
            'total_members'    => User::members()->count(),
            'active_members'   => User::members()->active()->count(),
            'inactive_members' => User::members()->where('membership_status', 'inactive')->count(),
            'pending_members'  => User::members()->where('membership_status', 'pending')->count(),
            'total_admins'     => User::admins()->count(),
        ];

        $recentMembers = User::members()
            ->latest()
            ->take(5)
            ->get();

        
        $city = $request->input('city', config('services.weather.city', 'Manila'));

        $weather = $this->fetchWeather($city);

        return view('admin.dashboard', compact('stats', 'recentMembers', 'weather', 'city'));
    }

    
    private function fetchWeather(string $city): array
    {
        $apiKey = config('services.weather.key');

        $fallback = [
            'success'     => false,
            'message'     => 'Weather information is currently unavailable.',
            'city'        => $city,
            'temperature' => null,
            'description' => null,
            'humidity'    => null,
            'wind_speed'  => null,
            'icon'        => null,
        ];

        if (empty($apiKey)) {
            $fallback['message'] = 'Weather API key is not configured.';
            return $fallback;
        }

        try {
            $response = Http::timeout(5)
                ->get('https://api.openweathermap.org/data/2.5/weather', [
                    'q'     => $city,
                    'appid' => $apiKey,
                    'units' => 'metric',
                ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'success'     => true,
                    'city'        => $data['name'] ?? $city,
                    'country'     => $data['sys']['country'] ?? '',
                    'temperature' => round($data['main']['temp'] ?? 0),
                    'description' => ucfirst($data['weather'][0]['description'] ?? 'N/A'),
                    'humidity'    => $data['main']['humidity'] ?? null,
                    'wind_speed'  => $data['wind']['speed'] ?? null,
                    'icon'        => $data['weather'][0]['icon'] ?? null,
                ];
            }

            
            $errorBody = $response->json();
            $apiMessage = $errorBody['message'] ?? 'Unable to retrieve weather data.';

            if ($response->status() === 404) {
                $fallback['message'] = "City \"{$city}\" not found. Please try another city.";
            } elseif ($response->status() === 401) {
                $fallback['message'] = 'Invalid API key.';
            } else {
                $fallback['message'] = ucfirst($apiMessage);
            }

            Log::warning('Weather API error', [
                'status' => $response->status(),
                'city'   => $city,
                'body'   => $response->body(),
            ]);

            return $fallback;

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Weather API connection failed: ' . $e->getMessage());
            $fallback['message'] = 'Weather service is temporarily unavailable (connection timeout).';
            return $fallback;

        } catch (\Exception $e) {
            Log::error('Weather API unexpected error: ' . $e->getMessage());
            $fallback['message'] = 'An unexpected error occurred while fetching weather data.';
            return $fallback;
        }
    }
}