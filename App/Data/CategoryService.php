<?php

namespace App\Data;

use App\Db\Db;

class CategoryService {
    public function getList()
    {
        $query = "SELECT * FROM categories";

        return Db::fetchAll($query);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM categories WHERE id = $id";
        return Db::fetchRow($query);
    }

    public function updateById(int $id, array $category)
    {
        if (isset($category['id'])) {
            unset($category['id']);
        }

        return Db::update('categories', $category, "id = $id");
    }

    public function add($category)
    {
        if (isset($category['id'])) {
            unset($category['id']);
        }

        return Db::insert('categories', $category);
    }

    public function deleteById(int $id)
    {
        return Db::delete('categories', "id = $id");
    }

    public function getDataFromPost(Request $request)
    {
        return [
            'id'          => $request->getIntFromPost('id', false),
            'name'        => $request->getStrFromPost('name'),
        ];
    }

    public function getByName(string $categoryName)
    {
        $query = "SELECT * FROM categories WHERE name = '$categoryName'";
        return Db::fetchRow($query);
    }

}