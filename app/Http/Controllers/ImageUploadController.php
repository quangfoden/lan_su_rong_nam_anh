<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $uniqueId = uniqid();

            $filename = $uniqueId . '_' . time() . '_' . $file->getClientOriginalName();

            $destinationPath = public_path('uploads/posts');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);

            $appUrl = env('APP_URL', 'http://localhost:8000');
            $location = $appUrl . '/uploads/posts/' . $filename;

            return response()->json(['location' => $location]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function editImage(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
            'current_image_url' => 'required|string'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $currentImageUrl = $request->input('current_image_url');

            // Xử lý tệp mới
            $uniqueId = uniqid();
            $filename = $uniqueId . '_' . time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/posts');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $filename);

            // Đường dẫn đến tệp mới
            $appUrl = env('APP_URL', 'http://localhost:8000');
            $newFilePath = '/uploads/posts/' . $filename;
            $newFileUrl = $appUrl . $newFilePath;

            // Xóa tệp cũ nếu tồn tại
            $currentFilePath = str_replace($appUrl, public_path(), $currentImageUrl);

            if (file_exists($currentFilePath)) {
                unlink($currentFilePath);
            }

            return response()->json(['success' => true, 'new_image_url' => $newFileUrl]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
