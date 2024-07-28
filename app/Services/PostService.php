<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostService
{
    protected PostRepository $postRepo;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function uploadNewPostImage(int $id, UploadedFile $file): void
    {
        $path = '/uploads/posts/' . $id . '/';
        Storage::disk('local')->putFileAs($path, $file, $file->getClientOriginalName());
        $dataImage = $path . $file->getClientOriginalName();

        $this->postRepo->update($id, ['image' => $dataImage]);
    }

    public function getNewOverwritePostImage(Post $post, UploadedFile|null $file): string
    {
        $dataImage = $post->image;
        if (!is_null($file)) {
            if (file_exists(public_path($post->image))) unlink(public_path($post->image));
            $path = '/uploads/posts/' . $post->id . '/';
            Storage::disk('local')->putFileAs($path, $file, $file->getClientOriginalName());
            $dataImage = $path . $file->getClientOriginalName();
        }

        return $dataImage;
    }
}
