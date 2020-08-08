<?php

namespace App\Product;

use App\Renderer;
use App\Request;
use App\CategoryService;
use App\Category\CategoryModel;
use App\Response;
use App\Router\Route;

class ProductController
{
    /**
     * @var Route
     */
    private $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    /**
     * @param ProductRepository $productRepository
     * @param Request $request
     *
     * @route("/product_list")
     */
    public function list(ProductRepository $productRepository, Request $request)
    {

        $current_page = $request->getIntFromGet('p', 1);

        $limit = 10;
        $offset = ($current_page - 1) * $limit;

        $products_count = $productRepository->getListCount();
        $pages_count = ceil($products_count / $limit);

        $products = $productRepository->getList($limit, $offset);

        Renderer::getSmarty()->assign('pages_count', $pages_count);
        Renderer::getSmarty()->assign('products', $products);
        Renderer::getSmarty()->display('products/index.tpl');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param ProductService $productService
     * @param ProductRepository $productRepository
     * @param ProductImageService $productImageService
     * @param CategoryService $categoryService
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

        Renderer::getSmarty()->assign('categories', $categories);
        Renderer::getSmarty()->assign('product', $product);
        Renderer::getSmarty()->display('products/edit.tpl');
    }

    public function add()
    {

        if (Request::isPost()) {
            $productData = ProductService::getDataFromPost();
            $productRepository = new Product\ProductRepository();
            $product = $productRepository->getProductFromArray($productData);

            $product = $productRepository->save($product);

            $productId = $product->getId();

            $imageUrl = trim($_POST['image_url']);
            ProductImageService::uploadImageByUrl($productId, $imageUrl);

            $uploadImages = $_FILES['images'] ?? [];
            ProductImageService::uploadImages($productId, $uploadImages);

            if ($productId) {
                Response::redirect('/products/list');
            } else {
                die("some insert error");
            }
        }

        $categoies = CategoryService::getList();
        $product = new Product\ProductModel('', 0, 0);
        $product->setId(0);

        $category = new CategoryModel('');
        $category->setId(0);

        $product->setCategory($category);


        Renderer::getSmarty()->assign('categories', $categoies);
        Renderer::getSmarty()->assign('product', $product);
        Renderer::getSmarty()->display('products/add.tpl');
    }

    public function delete()
    {
        $id = Request::getIntFromPost('id', false);

        if (!$id) {
            die("Error with id");
        }

        $deleted = ProductService::deleteById($id);

        if ($deleted) {
            Response::redirect('/products/list');
        } else {
            die("some error with delete row");
        }
    }

    public function deleteImage()
    {
        $productImageId = Request::getIntFromPost('product_image_id', false);

        if (!$productImageId) {
            die("error with id");
        }

        $deleted = ProductImageService::deleteById($productImageId);
        die('ok');

//        if ($deleted) {
//            Response::redirect('/products/list');
//        } else {
//            die("some error with delete row");
//        }
    }
}