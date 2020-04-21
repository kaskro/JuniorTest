<div class="container-fluid">
<form action="/JTV2/product/delete" method="post" >
<div class="row align-items-center border-bottom">
  <div class="col no-gutters">
    <div class="h2"><?php echo $title ?></div>
  </div>
  <div class="col-md-auto">
  <select>
    <option value="mass_delete">Mass Delete Action</option>
  </select>
  </div>
  <div class="col-md-auto">
    <button type="submit" class="my-btn">Apply</button>
  </div>
  <div class="col-md-auto">
    <a href="/JTV2/product/add" class="button">Add product</a>
  </div>
</div>
<!-- Create product boxes -->
<?php
foreach ($data as $product):?>
    <div class="box-style">
        <input type="checkbox" name="<?php
        echo 'checkbox'.$product['pr_id'] ?>" value="<?php echo $product['pr_id']; ?>">
        <div><p><?php echo $product['pr_SKU']; ?></p></div>
        <div><p><?php echo $product['pr_name']; ?></p></div>
        <div><p><?php echo $product['pr_price']; ?> $</p></div>
        <div><p><?php echo $product['pr_attr_name'].': '.$product['pr_attr_value'].' '.$product['pr_attr_unit']; ?></p>
        </div>
    </div>

<?php endforeach; ?>

</form>
</div>
