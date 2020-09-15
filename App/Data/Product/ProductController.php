<?php

namespace App\Data\Product;

use App\Controller\AbstractController;
use App\Http\Request;
use App\Data\CategoryService;
use App\Data\Category\CategoryModel;
use App\Http\Response;
use App\Router\Route;
use Exception;

class ProductController extends AbstractController
{
//    /**
//     * @var Route
//     */
//    private $route;

    public function __construct()
    {
//        $this->route = $route;
    }

    /**
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return mixed
     *
     * @route("/product_list")
     */
    public function list(ProductRepository $productRepository, Request $request)
    {

        $current_page = $request->getIntFromGet('p', 1);

        $limit = 10;
        $offset = ($current_page - 1) * $limit;

        $productsCount = $productRepository->getListCount();
        $pagesCount = ceil($productsCount / $limit);

        $products = $productRepository->getList($limit, $offset);

        return $this->render('products/index.tpl', [
            'pages_count' => $pagesCount,
            'products' => $products,
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param ProductService $productService
     * @param ProductRepository $productRepository
     * @param ProductImageService $productImageService
     * @param CategoryService $categoryService
     * @return mixed
     *
     * @route("/product_edit/{id}")
     */
    public function edit(
        Request $request,
        Response $response,
        ProductService $productService,
        ProductRepository $productRepository,
        ProductImageService $productImageService,
        CategoryService $categoryService)
    {

        $productId = $request->getIntFromGet('id', null);
        if (is_null($productId)) {
            $productId = $this->route->getParam('id');
        }

        $product = [];

        if ($productId) {
            $product = $productRepository->getById($productId);
        }

        if ($request->isPost()) {
            $productData = $productService->getDataFromPost($request);

            $product->setName($productData['name']);
            $product->setArticle($productData['article']);
            $product->setDescription($productData['description']);
            $product->setAmount($productData['amount']);
            $product->setPrice($productData['price']);

            $categoryId = $productData['category_id'] ?? 0;
            if ($categoryId) {
                $categoryData = $categoryService->getById($categoryId);
                $categoryName = $categoryData['name'];
                $category = new CategoryModel($categoryName);
                $category->setId($categoryId);

                $product->setCategory($category);
            }

            $product = $productRepository->save($product);

            $imageUrl = trim($_POST['image_url']);
            $productImageService->uploadImageByUrl($productId, $imageUrl);

            $uploadImages = $_FILES['images'] ?? [];
            $productImageService->uploadImages($productId, $uploadImages);

            $response->redirect('/products/');
        }

        $categories = $categoryService->getList();

        return $this->render('products/edit.tpl', [
            'categories' => $categories,
            'product' => $product,
        ]);

    }

    /**
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param ProductService $productService
     * @param ProductImageService $productImageService
     * @param CategoryService $categoryService
     * @param Response $response
     * @return mixed
     * @throws Exception
     */
    public function add(Request $request, ProductRepository $productRepository, ProductService $productService, ProductImageService $productImageService, CategoryService $categoryService, Response $response)
    {

        if ($request->isPost()) {
            $productData = $productService->getDataFromPost($request);
            $product = $productRepository->getProductFromArray($productData);

            $product = $productRepository->save($product);

            $productId = $product->getId();

            $imageUrl = trim($request->getStrFromPost('image_url'));
            $productImageService->uploadImageByUrl($productId, $imageUrl);

            $uploadImages = $_FILES['images'] ?? [];
            $productImageService->uploadImages($productId, $uploadImages);

            if ($productId) {
                return $this->redirect('/products/list');
            } else {
                die("some insert error");
            }
        }

        $categories = $categoryService->getList();
        $product = new ProductModel('', 0, 0);
        $product->setId(0);

        $category = new CategoryModel('');
        $category->setId(0);

        $product->setCategory($category);

        return $this->render('products/edit.tpl', [
            'categories' => $categories,
            'product' => $product,
        ]);
    }

    public function delete(Request $request, ProductService $productService, Response $response)
    {
        $id = $request->getIntFromPost('id', false);

        if (!$id) {
            die("Error with id");
        }

        $deleted = $productService->deleteById($id);

        if ($deleted) {
            return $this->redirect('/products/list');
        } else {
            die("some error with delete row");
        }
    }

    public function deleteImage(Request $request, ProductImageService $productImageService)
    {
        $productImageId = $request->getIntFromPost('product_image_id', false);

        if (!$productImageId) {
            die("error with id");
        }

        $productImageService->deleteById($productImageId);
        die('ok');
    }
}