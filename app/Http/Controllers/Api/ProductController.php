<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var Request
     */
    private $request;

    public function __construct(
        Request $request,
        ProductRepositoryInterface $productRepository
    ){

        $this->productRepository = $productRepository;
        $this->request = $request;
    }


    public function index()
    {
        return ProductResource::collection($this->productRepository->paginate($this->request->all()));
    }

    public function store(ProductRequest $request)
    {
        $model = $this->productRepository->create($request->validated());
        return new ProductResource($model);
    }

    public function show($id)
    {
        $model = $this->productRepository->findById($id);
        return new ProductResource($model);
    }

    public function update(ProductRequest $request, $id)
    {
        $model = $this->productRepository->update($id, $request->validated());
        return new ProductResource($model);

    }

    public function destroy($id)
    {
        return $this->productRepository->deleteById($id);
    }
}
