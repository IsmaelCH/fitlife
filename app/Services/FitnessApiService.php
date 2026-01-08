<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FitnessApiService
{
    private string $baseUrl = 'https://wger.de/api/v2/';

    /**
     * Obtener ejercicios de fitness
     */
    public function getExercises(int $limit = 10)
    {
        return Cache::remember('fitness_exercises_' . $limit, 3600, function () use ($limit) {
            try {
                $response = Http::get($this->baseUrl . 'exercise/', [
                    'limit' => $limit,
                    'language' => 2, // English
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return collect($data['results'] ?? [])->map(function ($exercise) {
                        return [
                            'id' => $exercise['id'],
                            'name' => $exercise['name'],
                            'description' => strip_tags($exercise['description'] ?? 'No description available'),
                            'category' => $exercise['category'] ?? null,
                        ];
                    });
                }

                return collect([]);
            } catch (\Exception $e) {
                Log::error('Fitness API Error: ' . $e->getMessage());
                return collect([]);
            }
        });
    }

    /**
     * Obtener información nutricional
     */
    public function getNutritionInfo(int $limit = 10)
    {
        return Cache::remember('fitness_nutrition_' . $limit, 3600, function () use ($limit) {
            try {
                $response = Http::get($this->baseUrl . 'ingredient/', [
                    'limit' => $limit,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return collect($data['results'] ?? [])->map(function ($item) {
                        return [
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'energy' => $item['energy'] ?? 0,
                            'protein' => $item['protein'] ?? 0,
                            'carbohydrates' => $item['carbohydrates'] ?? 0,
                            'fat' => $item['fat'] ?? 0,
                        ];
                    });
                }

                return collect([]);
            } catch (\Exception $e) {
                Log::error('Fitness API Error: ' . $e->getMessage());
                return collect([]);
            }
        });
    }

    /**
     * Obtener planes de entrenamiento
     */
    public function getWorkoutPlans(int $limit = 5)
    {
        return Cache::remember('fitness_workouts_' . $limit, 3600, function () use ($limit) {
            try {
                $response = Http::get($this->baseUrl . 'workout/', [
                    'limit' => $limit,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return collect($data['results'] ?? [])->map(function ($workout) {
                        return [
                            'id' => $workout['id'],
                            'name' => $workout['name'] ?? 'Workout Plan',
                            'description' => $workout['description'] ?? 'No description available',
                            'creation_date' => $workout['creation_date'] ?? now()->toDateString(),
                        ];
                    });
                }

                return collect([]);
            } catch (\Exception $e) {
                Log::error('Fitness API Error: ' . $e->getMessage());
                return collect([]);
            }
        });
    }
}
