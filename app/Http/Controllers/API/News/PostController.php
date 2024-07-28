<?php

namespace App\Http\Controllers\API\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\AddPostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Repositories\PostRepository;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected PostRepository $postRepo;
    protected PostService $postService;

    public function __construct(
        PostRepository $postRepo,
        PostService    $postService
    )
    {
        $this->postRepo = $postRepo;
        $this->postService = $postService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $posts = $this->postRepo->getList();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $posts
        ]);
    }

    public function detail(int $id): \Illuminate\Http\JsonResponse
    {
        $post = $this->postRepo->findById($id);

        if (is_null($post)) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => "Bài viết có #" . $id . " không tồn tại."
            ]);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $post
        ]);
    }

    public function store(AddPostRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();
        $imgRequest = $data['image'];
        $categoriesId = json_decode($data['categories_id']);
        unset($data['image']);
        unset($data['categories_id']);

        $post = $this->postRepo->create($data);
        $this->postService->uploadNewPostImage($post->id, $imgRequest);
        if (!is_null($categoriesId)) {
            $post->categories()->attach($categoriesId);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Bài viết #" . $post->id . " đã được thêm thành công.",
            'data_id' => $post->id
        ]);
    }

    public function update(int $id, UpdatePostRequest $request): \Illuminate\Http\JsonResponse
    {
        $post = $this->postRepo->findById($id);

        if (is_null($post)) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => "Bài viết có #" . $id . " không tồn tại."
            ]);
        }

        $data = $request->all();

        foreach ($data as $idx => $val) {
            if ($val === 'null') $data[$idx] = null;
        }

        $imgRequest = $data['image'];
        $categoriesId = json_decode($data['categories_id']);
        unset($data['image']);
        unset($data['categories_id']);

        $postImage = $this->postService->getNewOverwritePostImage($post, $imgRequest);
        $data = array_merge($data, ['image' => $postImage]);
        $this->postRepo->update($id, $data);
        if (!is_null($categoriesId)) {
            $post->categories()->sync($categoriesId);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Bài viết #" . $post->id . " đã được cập nhật thành công."
        ]);
    }

    public function allPosts(Request $request): \Illuminate\Http\JsonResponse
    {
        $posts = $this->postRepo->getAll($request->all());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $posts
        ]);
    }
    public function latestPosts(Request $request): \Illuminate\Http\JsonResponse
    {
        $latestPosts = $this->postRepo->getLatestPosts(6);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $latestPosts
        ]);
    }

    public function detailBySlug(string $slug): \Illuminate\Http\JsonResponse
    {
        $post = $this->postRepo->findBySlug($slug);

        if (is_null($post)) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => "Bài viết không tồn tại."
            ]);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $post
        ]);
    }

    public function likePost(int $id): \Illuminate\Http\JsonResponse
    {
        $post = $this->postRepo->findById($id);

        if (is_null($post)) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => "Bài viết có #" . $id . " không tồn tại."
            ]);
        }

        $this->postRepo->update($id, ['like_number' => $post->like_number + 1]);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Bài viết: " . $post->title . " đã được cập nhật số lượng like thành công."
        ]);
    }
}
