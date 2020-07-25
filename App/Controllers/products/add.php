<?php


/**
 * product_images
 *  id
 *  product_id
 *  name
 *  path
 */

if (Request::isPost()) {


    $product = Product::getDataFromPost();
    $productId = Product::add($product);

//    echo "<pre>"; var_dump($_POST); echo "</pre>";
//    echo "<pre>"; var_dump($_FILES); echo "</pre>";
//
    $uploadImages = $_FILES['images'] ?? [];

    $imageNames = $uploadImages['name'];
    $imageTmpNames = $uploadImages['tmp_name'];

    $path = APP_UPLOAD_PRODUCT_DIR . '/' . $productId;

    if (!file_exists($path)) {
        mkdir($path);
    }

    for ($i = 0; $i < count($imageNames); $i++) {
        $imageName = basename($imageNames[$i]);
        $imageTmpName = $imageTmpNames[$i];

        $imagePath = $path . '/' . $imageName;

        move_uploaded_file($imageTmpName, $imagePath);

        ProductImage::add([
            'product_id' => $productId,
            'name' => $imageName,
            'path' => str_replace(APP_PUBLIC_DIR, '', $imagePath),
        ]);
    }

//    exit;

    if ($productId) {
        Response::redirect('/products/list');
    } else {
        die("some insert error");
    }
}

$categoies = Category::getList();

$smarty->assign('categories', $categoies);
$smarty->display('products/add.tpl');