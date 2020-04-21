<?php

namespace app\controllers;

use app\core\Controller;

use app\core\View;

class ProductController extends Controller
{
    public function listAction()
    {
        $result = $this->model->getProduct();
        $vars = [
            'title' => 'List the page',
            'data' => $result,
        ];

        $this->view->render($vars['title'], $vars);
    }

    public function addAction()
    {
        $error = '';
        $fields = [
            'name' => ['SKU', 'Name', 'Price', ],
            'regex' => ['/^[A-Z]{3}\d{6}$/', '/^[A-Z][a-zA-Z0-9āēšģīķļņčū\s]+$/', '/^\d*\.\d{2}$/', ],
            'hint' => [
                        'Please use format: AAA000000',
                        'Start name with capital letter!',
                        'Price must be positive. Use format: 00.00',
                     ],
        ];
        $types = $this->model->getTypes();
        if ($_POST) {
            // Make validation and them send to db info!
            if ($this->model->checkBySKU($_POST['inputSKU']) != true) {
                $result = [
                    'pr_SKU' => $_POST['inputSKU'],
                    'pr_name' => $_POST['inputName'],
                    'pr_price' => $_POST['inputPrice'],
                    'pr_type_id' => $_POST['mySelector'],
                    'pr_attr_value' => $_POST['inputAttribute'],
                    ];
                if ($this->model->addProduct($result)) {
                    View::redirect('/JTV2/product/');
                } else {
                    $result = $_POST;
                }
            } else {
                $error = 'Product with SKU: "'.$_POST['inputSKU'].'" exists!';
                $temp = [];
                foreach ($_POST as $key => $val) {
                    if (preg_match('/input/', $key)) {
                        if (str_replace('input', '', $key) != 'Attribute') {
                            $temp[] = str_replace('input', '', $key);
                        }
                    }
                }
                $add = false;
                foreach ($temp as $key) {
                    $add = false;
                    foreach ($fields['name'] as $value) {
                        if ($value == $key) {
                            $add = false;
                            break;
                        } else {
                            $add =  true;
                        }
                    }
                    if ($add == true) {
                        $fields['name'][] = $key;
                        $fields['regex'][] = '/^[1-9]\d*$/';
                        $fields['hint'][] = 'Value must be a positive number';
                    }
                }

                $result = $_POST;
            }
        } else {
            $result = [];
        }

        // Collects data to send to page!
        $vars = [
            'title' => 'Add product',
            'data' => $result,
            'error' => $error,
            'types' => $types,
            'fields' => $fields,
        ];

        $this->view->render($vars['title'], $vars);
    }

    public function deleteAction()
    {
        if ($_POST) {
            foreach ($_POST as $key => $value) {
                $this->model->deleteProduct($value);
            }
        }
            View::redirect('./list');
    }
}
