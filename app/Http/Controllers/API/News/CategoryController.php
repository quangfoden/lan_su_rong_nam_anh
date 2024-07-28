<?php

namespace App\Http\Controllers\API\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\AddCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryRepository $categoryRepo;

    public function __construct(
        CategoryRepository $categoryRepo
    )
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $cats = $this->categoryRepo->getList();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $cats
        ]);
    }

    public function detail(int $id): \Illuminate\Http\JsonResponse
    {
        $cat = $this->categoryRepo->findById($id);

        if (is_null($cat)) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => "Danh mục có #" . $id . " không tồn tại."
            ]);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $cat
        ]);
    }

    public function store(AddCategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        $cat = $this->categoryRepo->create($request->all());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Danh mục #" . $cat->id . " đã được thêm thành công.",
            'data_id' => $cat->id
        ]);
    }

    public function update(int $id, UpdateCategoryRequest $request): \Illuminate\Http\JsonResponse
    {
        $cat = $this->categoryRepo->findById($id);

        if (is_null($cat)) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => "Danh mục có #" . $id . " không tồn tại."
            ]);
        }

        $this->categoryRepo->update($id, $request->all());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Danh mục #" . $cat->id . " đã được cập nhật thành công."
        ]);
    }

    public function allCategories(): \Illuminate\Http\JsonResponse
    {
        $cats = $this->categoryRepo->getList();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $cats
        ]);
    }

    public function getCategoryOpts(Request $request): \Illuminate\Http\JsonResponse
    {
        $withoutId = !is_null($request->input('without_id')) ? (int) $request->input('without_id') : null;
        $forPost = !is_null($request->input('for_post')) ? (bool) $request->input('for_post') : null;
        $opts = $this->categoryRepo->getCategoryOpts($withoutId, $forPost);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $opts
        ]);
    }
}
