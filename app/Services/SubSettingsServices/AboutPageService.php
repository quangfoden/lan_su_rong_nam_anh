<?php

namespace App\Services\SubSettingsServices;
use Illuminate\Support\Facades\Log;

use App\Repositories\SettingsRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutPageService
{
    protected SettingsRepository $settingsRepo;

    public function __construct(SettingsRepository $settingsRepo)
    {
        $this->settingsRepo = $settingsRepo;
    }

    public function updateLifePageSettings(int $id, array $requests): array
    {
        $newData = [];
        unset($requests['name']);
        $rqLifeOurValueMainBG = $requests['life_our_value_main_bg'] === 'null' ? null : $requests['life_our_value_main_bg'];
        $rqLifeOurValueContentBg1 = $requests['life_our_value_content_bg_1'] === 'null' ? null : $requests['life_our_value_content_bg_1'];
        $rqLifeOurValueContentBg2 = $requests['life_our_value_content_bg_2'] === 'null' ? null : $requests['life_our_value_content_bg_2'];
        $rqLifeOurValueContentBg3 = $requests['life_our_value_content_bg_3'] === 'null' ? null : $requests['life_our_value_content_bg_3'];
        $rqLifeOurValueContentBg4 = $requests['life_our_value_content_bg_4'] === 'null' ? null : $requests['life_our_value_content_bg_4'];
        $rqLifeOurValueContentBg5 = $requests['life_our_value_content_bg_5'] === 'null' ? null : $requests['life_our_value_content_bg_5'];

        $rqLifeWithYouVideo = $requests['life_with_you_video'] === 'null' ? null : $requests['life_with_you_video'];

        $rqHowWeHireImgKh1 = $requests['image_kh_0'] === 'null' ? null : $requests['image_kh_0'];
        $rqHowWeHireImgKh2 = $requests['image_kh_1'] === 'null' ? null : $requests['image_kh_1'];
        $rqHowWeHireImgKh3 = $requests['image_kh_2'] === 'null' ? null : $requests['image_kh_2'];
        $rqHowWeHireImgKh4 = $requests['image_kh_3'] === 'null' ? null : $requests['image_kh_3'];

        unset($requests['life_our_value_main_bg']);
        unset($requests['life_our_value_content_bg_1']);
        unset($requests['life_our_value_content_bg_2']);
        unset($requests['life_our_value_content_bg_3']);
        unset($requests['life_our_value_content_bg_4']);
        unset($requests['life_our_value_content_bg_5']);

        unset($requests['life_with_you_video']);

        unset($requests['image_kh_0']);
        unset($requests['image_kh_1']);
        unset($requests['image_kh_2']);
        unset($requests['image_kh_3']);


        // slug have images: life_our_value_sec(life_our_value_main_bg, life_our_value_content_bg_1~5)
        foreach ($requests as $slug => $request) {
            if ($slug === 'life_our_value_sec') {
                $data = $this->convertData($request);
                if (
                    !is_null($rqLifeOurValueMainBG) ||
                    !is_null($rqLifeOurValueContentBg1) ||
                    !is_null($rqLifeOurValueContentBg2) ||
                    !is_null($rqLifeOurValueContentBg3) ||
                    !is_null($rqLifeOurValueContentBg4) ||
                    !is_null($rqLifeOurValueContentBg5)
                ) {
                    if (!is_null($rqLifeOurValueMainBG)) {
                        $oldMainBgPath = $data['data']['main_bg'];
                        $data['data']['main_bg'] = $this->updateLifeImages($rqLifeOurValueMainBG, $oldMainBgPath);
                    }
                    if (!is_null($rqLifeOurValueContentBg1)) {
                        $oldContentBg1Path = $data['data']['content'][0]['bg'];
                        $data['data']['content'][0]['bg'] = $this->updateLifeImages($rqLifeOurValueContentBg1, $oldContentBg1Path);
                    }
                    if (!is_null($rqLifeOurValueContentBg2)) {
                        $oldContentBg2Path = $data['data']['content'][1]['bg'];
                        $data['data']['content'][1]['bg'] = $this->updateLifeImages($rqLifeOurValueContentBg2, $oldContentBg2Path);
                    }
                    if (!is_null($rqLifeOurValueContentBg3)) {
                        $oldContentBg3Path = $data['data']['content'][2]['bg'];
                        $data['data']['content'][2]['bg'] = $this->updateLifeImages($rqLifeOurValueContentBg3, $oldContentBg3Path);
                    }
                    if (!is_null($rqLifeOurValueContentBg4)) {
                        $oldContentBg4Path = $data['data']['content'][3]['bg'];
                        $data['data']['content'][3]['bg'] = $this->updateLifeImages($rqLifeOurValueContentBg4, $oldContentBg4Path);
                    }
                    if (!is_null($rqLifeOurValueContentBg5)) {
                        $oldContentBg5Path = $data['data']['content'][4]['bg'];
                        $data['data']['content'][4]['bg'] = $this->updateLifeImages($rqLifeOurValueContentBg5, $oldContentBg5Path);
                    }
                }
                $newData[] = $data;
            } elseif ($slug === 'life_with_you_sec') {
                $data = $this->convertData($request);
                if (!is_null($rqLifeWithYouVideo)) {
                    $oldVideoPath = $data['data']['video'];
                    $data['data']['video'] = $this->updateLifeVideo($rqLifeWithYouVideo, $oldVideoPath);
                }
                $newData[] = $data;
            } elseif ($slug === 'life_how_we_hire_sec') {
                $data = $this->convertData($request);
                if (
                    !is_null($rqHowWeHireImgKh1) ||
                    !is_null($rqHowWeHireImgKh2) ||
                    !is_null($rqHowWeHireImgKh3) ||
                    !is_null($rqHowWeHireImgKh4)
                ) {
                    if (!is_null($rqHowWeHireImgKh1)) {
                        $oldimgPath1 = $data['data']['data']['images_kh'][0];
                        $data['data']['data']['images_kh'][0] = $this->updateLifeImages($rqHowWeHireImgKh1, $oldimgPath1);
                    }
                    if (!is_null($rqHowWeHireImgKh2)) {
                        $oldimgPath2 = $data['data']['data']['images_kh'][1];
                        $data['data']['data']['images_kh'][1] = $this->updateLifeImages($rqHowWeHireImgKh2, $oldimgPath2);
                    }
                    if (!is_null($rqHowWeHireImgKh3)) {
                        $oldimgPath3 = $data['data']['data']['images_kh'][2];
                        $data['data']['data']['images_kh'][2] = $this->updateLifeImages($rqHowWeHireImgKh3, $oldimgPath3);
                    }
                    if (!is_null($rqHowWeHireImgKh4)) {
                        $oldimgPath4 = $data['data']['data']['images_kh'][3];
                        $data['data']['data']['images_kh'][3] = $this->updateLifeImages($rqHowWeHireImgKh4, $oldimgPath4);
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

    public function updateLifeImages(UploadedFile $rqImg, string $oldImgPath): string
    {
        $path = '/uploads/settings/about/';
        $uniqueName = Str::uuid()->toString() . '_' . $rqImg->getClientOriginalName();
        Storage::disk('local')->putFileAs($path, $rqImg, $uniqueName);
        if (file_exists(public_path($oldImgPath))) unlink(public_path($oldImgPath));

        return $path . $uniqueName;
    }

    public function updateLifeVideo(UploadedFile $rqVideo, string $oldVideoPath): string
    {
        $path = '/uploads/settings/about/videos/';
        $uniqueName = Str::uuid()->toString() . '_' . $rqVideo->getClientOriginalName();
        Storage::disk('local')->putFileAs($path, $rqVideo, $uniqueName);
        if (file_exists(public_path($oldVideoPath))) {
            unlink(public_path($oldVideoPath));
        }
        return $path . $uniqueName;
    }
    private function convertData(string $data): array
    {
        $result = [];
        $tmp = json_decode($data);
        Log::info($tmp);
        // print_r($tmp);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Lỗi giải mã JSON:', ['lỗi' => json_last_error_msg(), 'dữ liệu' => $data]);
            return $result; // Hoặc xử lý lỗi một cách phù hợp
        }
        
        // Kiểm tra định dạng dữ liệu
        if (!is_array($tmp) || count($tmp) < 2) {
            Log::error('Định dạng dữ liệu không như mong đợi:', ['dữ liệu' => $tmp]);
            return $result; // Hoặc xử lý lỗi một cách phù hợp
        }
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
