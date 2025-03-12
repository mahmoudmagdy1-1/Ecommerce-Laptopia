<?php

namespace App\controllers;

use App\models\CategoryModel;
use Core\Flash;

class CategoryController
{
    protected $categoryModel;
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->getAllCategories();

        loadView('admin/categories', [
            'categories' => $categories
        ]);
    }
    public function addCategory()
    {
        loadView('categories/add-category');
    }

    public function createCategory()
    {
        $name = sanitize($_POST['name'] ?? '');

        if (empty($name)) {
            Flash::set(Flash::ERROR, 'Category name is required');
            redirect('/admin/categories/');
        }

        $categoryId = $this->categoryModel->createCategory(['name' => $name]);

        if ($categoryId) {
            Flash::set(Flash::SUCCESS, 'Category added successfully');
            redirect('/admin/categories');
        } else {
            Flash::set(Flash::ERROR, 'Failed to add category');
            redirect('/admin/categories/add');
        }
    }

    public function editCategory($params)
    {
        $categoryId = $params['id'];
        $category = $this->categoryModel->getCategoryById($categoryId);

        if (!$category) {
            Flash::set(Flash::ERROR, 'Category not found');
            redirect('/categories/categories');
        }

        loadView('categories/edit-category', [
            'category' => $category
        ]);
    }

    public function updateCategory($params)
    {
        $categoryId = $params['id'];
        $name = sanitize($_POST['name'] ?? '');

        if (empty($name)) {
            Flash::set(Flash::ERROR, 'Category name is required');
            redirect("/admin/categories/edit/{$categoryId}");
        }

        $success = $this->categoryModel->updateCategory($categoryId, ['name' => $name]);

        if ($success) {
            Flash::set(Flash::SUCCESS, 'Category updated successfully');
            redirect('/admin/categories');
        } else {
            Flash::set(Flash::ERROR, 'Failed to update category');
            redirect("/admin/categories/edit/{$categoryId}");
        }
    }
}