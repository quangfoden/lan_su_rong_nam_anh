<?php

namespace App\Services;

use App\Repositories\SettingsRepository;
use App\Services\SubSettingsServices\HomePageService;
use App\Services\SubSettingsServices\AboutPageService;
use App\Services\SubSettingsServices\ProductsPageService;

class SettingsService
{
    protected SettingsRepository $settingsRepo;
    protected HomePageService $homePageService;
    protected AboutPageService $aboutPageService;

    public function __construct(
        SettingsRepository $settingsRepo,
        HomePageService    $homePageService,
        AboutPageService    $aboutPageService,
    )
    {
        $this->settingsRepo = $settingsRepo;
        $this->homePageService = $homePageService;
        $this->aboutPageService = $aboutPageService;
    }

    public function handleUpdateSettings(array $requests): array
    {
        $name = $requests['name'];
        $settingItem = $this->settingsRepo->findByName($name);
        if (is_null($settingItem)) {
            return [
                'success' => false,
                'message' => "Setting có name = " . $name . " không tồn tại."
            ];
        }

        return match ($name) {
            'Home' => $this->homePageService->updateHomePageSettings($settingItem->id, $requests),
            'About' => $this->aboutPageService->updateLifePageSettings($settingItem->id, $requests),
            default => ['success' => true],
        };

    }
}
