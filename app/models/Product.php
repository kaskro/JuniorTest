<?php

namespace app\models;

use app\core\Model;

class Product extends Model
{

    // Object properties
    public $pr_id;
    public $pr_SKU;
    public $pr_name;
    public $pr_price;
    public $pr_type_id;
    public $pr_type_name;
    public $pr_attr_id;
    public $pr_attr_name;
    public $pr_attr_unit;
    public $pr_attr_value;

    public function getProduct()
    {
        $result = $this->db->row(
            'SELECT product.pr_id, product.pr_SKU, product.pr_name, product.pr_price,
            product_type.pr_type_name, product_attributes.pr_attr_name,
            product_attributes.pr_attr_unit, product.pr_attr_value
        FROM product
            INNER JOIN product_type ON
            product.pr_type_id = product_type.pr_type_id
            INNER JOIN product_attributes ON
            product_type.pr_type_id = product_attributes.pr_attr_id'
        );
        return $result;
    }

    public function addProduct($vars)
    {
        $result = $this->db->doQuery(
            'INSERT INTO
                product
              SET
                pr_SKU=:pr_SKU,pr_name=:pr_name,pr_price=:pr_price,pr_type_id=:pr_type_id,pr_attr_value=:pr_attr_value',
            $vars
        );
        return $result;
    }

    public function getProducts()
    {
        $result = $this->db->row('SELECT * FROM product');
        return $result;
    }

    public function deleteProduct($id)
    {

        $result = $this->db->column('DELETE FROM product WHERE pr_id =:id ', $param = ['id' => $id]);
        return $result;
    }

    public function checkBySKU($SKU)
    {
        $result = $this->db->row('SELECT pr_id FROM product WHERE pr_SKU =:SKU', $param = ['SKU' => $SKU]);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getTypes()
    {
        $result = $this->db->row('SELECT pr_type_id,pr_type_name  FROM product_type');
        return $result;
    }
}
