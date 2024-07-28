<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\AddProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Repositories\ProductsRepository;
use App\Services\ProductsService;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    protected ProductsRepository $productsRepository;
    protected ProductsService $productsService;

    public function __construct(
        ProductsRepository $productsRepository,
        ProductsService  $productsService
    ) {
        $this->productsRepository = $productsRepository;
        $this->productsService = $productsService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $products = $this->productsRepository->getAll();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $products
        ]);
    }
    public function getProductsIsHot(): \Illuminate\Http\JsonResponse
    {
        $products = $this->productsRepository->getListIsHot();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $products
        ]);
    }

    public function detail(int $id): \Illuminate\Http\JsonResponse
    {
        $products = $this->productsRepository->findById($id);

        if (is_null($products)) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => "Tài khoản có #" . $id . " không tồn tại."
            ]);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $products
        ]);
    }

    public function store(AddProductRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();
        $imgRequests = [
            'bg_img' => $data['bg_img'],
            'details_img' => $data['details_img'],
        ];
        unset($data['bg_img']);
        unset($data['details_img']);

        $products = $this->productsRepository->create($data);

        $this->productsService->uploadNewProductImages($products->id, $imgRequests);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Sản phẩm #" . $products->id . " đã được thêm thành công.",
            'data_id' => $products->id
        ]);
    }

    public function update(int $id, UpdateProductRequest $request): \Illuminate\Http\JsonResponse
    {
        $products = $this->productsRepository->findById($id);

        if (is_null($products)) {
            return response()->json([
                'status' => 200,
                'success' => false,
                'message' => "Sản phẩm có #" . $id . " không tồn tại."
            ]);
        }

        $data = $request->all();

        foreach ($data as $idx => $val) {
            if ($val === 'null') $data[$idx] = null;
        }

        $imgRequests = [
            'bg_img' => $data['bg_img'],
            'details_img' => $data['details_img'],
        ];
        unset($data['bg_img']);
        unset($data['details_img']);

        $productImages = $this->productsService->getNewOverwriteProductImages($products, $imgRequests);
        $data = array_merge($data, $productImages);
        $this->productsRepository->update($id, $data);

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => "Sản phẩm #" . $products->id . " đã được cập nhật thành công."
        ]);
    }

    public function allProducts(Request $request): \Illuminate\Http\JsonResponse
    {
        $products = $this->productsRepository->getList($request->all());

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' => $products
        ]);
    }
}
