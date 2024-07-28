<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\SettingsRepository;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected SettingsRepository $settingsRepo;
    protected SettingsService $settingsService;

    public function __construct(
        SettingsRepository $settingsRepo,
        SettingsService $settingsService
    )
    {
        $this->settingsRepo = $settingsRepo;
        $this->settingsService = $settingsService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $settings = $this->settingsRepo->getAll();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $settings
        ]);
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->settingsService->handleUpdateSettings($request->all());

        if (!$result['success']) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => $result['message']
            ]);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Cập nhật ' . $request->input('name') . ' thành công.'
        ]);
    }

    public function getSettingsPage(Request $request): \Illuminate\Http\JsonResponse|array
    {
        $settings = $this->settingsRepo->findByName($request->input('page'));
        if (is_null($settings)) {
            return [
                'success' => false,
                'message' => "Setting có name = " . $request->input('page') . " không tồn tại."
            ];
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $settings->data
        ]);
    }
}
