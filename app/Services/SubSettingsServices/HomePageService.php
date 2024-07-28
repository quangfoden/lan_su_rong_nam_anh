<?php

namespace App\Services\SubSettingsServices;

use App\Repositories\SettingsRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomePageService
{
    protected SettingsRepository $settingsRepo;

    public function __construct(SettingsRepository $settingsRepo)
    {
        $this->settingsRepo = $settingsRepo;
    }

    public function updateHomePageSettings(int $id, array $requests): array
    {
        $newData = [];
        $rqFavicon = $requests['general_favicon'] === 'null' ? null : $requests['general_favicon'];
        $rqLogo = $requests['general_logo'] === 'null' ? null : $requests['general_logo'];
        unset($requests['name']);
        unset($requests['general_favicon']);
        unset($requests['general_logo']);

        $rqSlideImgBig0 = $requests['slide_img_big_0'] === 'null' ? null : $requests['slide_img_big_0'];
        $rqSlideImgSmall0 = $requests['slide_img_small_0'] === 'null' ? null : $requests['slide_img_small_0'];
        $rqSlideImgBig1 = $requests['slide_img_big_1'] === 'null' ? null : $requests['slide_img_big_1'];
        $rqSlideImgSmall1 = $requests['slide_img_small_1'] === 'null' ? null : $requests['slide_img_small_1'];
        $rqSlideImgBig2 = $requests['slide_img_big_2'] === 'null' ? null : $requests['slide_img_big_2'];
        $rqSlideImgSmall2 = $requests['slide_img_small_2'] === 'null' ? null : $requests['slide_img_small_2'];

        unset($requests['slide_img_big_0']);
        unset($requests['slide_img_small_0']);
        unset($requests['slide_img_big_1']);
        unset($requests['slide_img_small_1']);
        unset($requests['slide_img_big_2']);
        unset($requests['slide_img_small_2']);


        // slug have images: general(logo, favicon)
        foreach ($requests as $slug => $request) {
            if ($slug === 'general') {
                $data = $this->convertData($request);
                if (!is_null($rqFavicon) || !is_null($rqLogo)) {
                    if (!is_null($rqFavicon)) {
                        $oldFaviconPath = $data['data']['favicon'];
                        $data['data']['favicon'] = $this->updateHomeFALImages($rqFavicon, $oldFaviconPath);
                    }
                    if (!is_null($rqLogo)) {
                        $oldFaviconPath = $data['data']['logo'];
                        $data['data']['logo'] = $this->updateHomeFALImages($rqLogo, $oldFaviconPath);
                    }
                }
                $newData[] = $data;
            } elseif ($slug === 'slide_sec') {
                $data = $this->convertData($request);
                if (
                    !is_null($rqSlideImgBig0)
                    || !is_null($rqSlideImgSmall0)
                    || !is_null($rqSlideImgBig1)
                    || !is_null($rqSlideImgSmall1)
                    || !is_null($rqSlideImgBig2)
                    || !is_null($rqSlideImgSmall2)
                ) {
                    if (!is_null($rqSlideImgBig0)) {
                        $oldSlideImgBig0 = $data['data'][0]['img'];
                        $data['data'][0]['img'] = $this->updateHomeSlideImages($rqSlideImgBig0, $oldSlideImgBig0);
                    }
                    if (!is_null($rqSlideImgSmall0)) {
                        $oldSlideImgSmall0 = $data['data'][0]['img_small'];
                        $data['data'][0]['img_small'] = $this->updateHomeSlideImages($rqSlideImgSmall0, $oldSlideImgSmall0);
                    }
                    if (!is_null($rqSlideImgBig1)) {
                        $oldSlideImgBig1 = $data['data'][1]['img'];
                        $data['data'][1]['img'] = $this->updateHomeSlideImages($rqSlideImgBig1, $oldSlideImgBig1);
                    }
                    if (!is_null($rqSlideImgSmall1)) {
                        $oldSlideImgSmall1 = $data['data'][1]['img_small'];
                        $data['data'][1]['img_small'] = $this->updateHomeSlideImages($rqSlideImgSmall1, $oldSlideImgSmall1);
                    }
                    if (!is_null($rqSlideImgBig2)) {
                        $oldSlideImgBig2 = $data['data'][2]['img'];
                        $data['data'][2]['img'] = $this->updateHomeSlideImages($rqSlideImgBig2, $oldSlideImgBig2);
                    }
                    if (!is_null($rqSlideImgSmall2)) {
                        $oldSlideImgSmall2 = $data['data'][2]['img_small'];
                        $data['data'][2]['img_small'] = $this->updateHomeSlideImages($rqSlideImgSmall2, $oldSlideImgSmall2);
                    }
                }
                $newData[] = $data;
            } else {
                $newData[] = $this->convertData($request);
            }
        }

        $this->settingsRepo->update($id, ['data' => serialize($newData)]);

        return ['success' => true];
    }

    public function updateHomeFALImages(UploadedFile $rqImg, string $oldImgPath): string
    {
        $path = '/uploads/settings/home/general/';
        $uniqueName = Str::uuid()->toString() . '_' . $rqImg->getClientOriginalName();
        Storage::disk('local')->putFileAs($path, $rqImg, $uniqueName);
        if (file_exists(public_path($oldImgPath))) {
            unlink(public_path($oldImgPath));
        }
        return $path . $uniqueName;
    }

    public function updateHomeSlideImages(UploadedFile $rqImg, string $oldImgPath): string
    {
        $path = '/uploads/settings/home/slide/';
        $uniqueName = Str::uuid()->toString() . '_' . $rqImg->getClientOriginalName();
        Storage::disk('local')->putFileAs($path, $rqImg, $uniqueName);

        if (file_exists(public_path($oldImgPath))) {
            unlink(public_path($oldImgPath));
        }

        return $path . $uniqueName;
    }

    private function convertData(string $data): array
    {
        $result = [];
        $tmp = json_decode($data);
        $result['name'] = $tmp[0];
        foreach (json_decode($tmp[1]) as $data) {
            $result['data'][$data[0]] = gettype($data[1]) === 'object' ? (array)$data[1] : (gettype($data[1]) === 'array' ? $this->convertChildData($data[1]) : $data[1]);
        }

        return $result;
    }

    private function convertChildData(array $childData): array
    {
        $result = [];
        foreach ($childData as $data) {
            if (gettype($data) === 'object') {
                $result[] = (array)$data;
            }
        }

        return $result;
    }
}
