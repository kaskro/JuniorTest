<div class="container-fluid">

<form action="/JTV2/product/add" method="post">
    <div class="row align-items-center border-bottom my-3">
      <div class="col">
        <div class="h2"><?php echo $title ?></div>
      </div>
      <div class="col-md-auto">
        <button type="submit" class="my-btn" onclick="return formValidator()">Save</button>
      </div>
    </div>
    <div class="alert-light p-2"><?php if (isset($error)) { echo $error; } ?></div>
<?php $i=0;?>
<?php foreach ($fields['name'] as $field):?>
    <div class="form-group row">
      <label for="input<?php echo $fields['name'][$i]; ?>" class="col-sm-1 col-form-label"><?php echo $fields['name'][$i]; ?></label>
      <div class="col-sm-2">
        <input type="text" class="form-control" id="input<?php echo $fields['name'][$i]; ?>" name="input<?php echo $fields['name'][$i]; ?>"
    onchange="validateInput('<?php echo $fields['name'][$i]; ?>', <?php echo $fields['regex'][$i]; ?>)" value="<?php if(isset($data['input'.$fields['name'][$i].''])){ echo $data['input'.$fields['name'][$i].''];} ?>" required>
      </div>
      <div id="error<?php echo $fields['name'][$i]; ?>" class="alert-light p-2"><?php echo $fields['hint'][$i]; ?></div>
  </div>
<?php
if ($i == 2) {
?>
<div class="form-group row">
    <label class="col-sm-1 col-form-label">Type Switcher</label>
        <div class="col-sm-2">
        <select id = "mySelector" name="mySelector"
        class="form-control selectpicker" onchange="changeType()">
        <?php
        foreach ($types as $type):?>
            <?php if(isset($data['mySelector']) && ($data['mySelector'] == $type['pr_type_id'])) { ?>
                <option value="<?php echo $type['pr_type_id']; ?>" selected><?php echo $type['pr_type_name'];
            } else { ?>
            <option value="<?php echo $type['pr_type_id']; ?>"><?php echo $type['pr_type_name']; ?></option>
        <?php } endforeach; ?>
        </select>
        </div>
</div>
<!-- Dynamically change this Div -->
<div id="emptyDiv"><div class="form-group row">
<?php }
$i++;
endforeach;?>

<div class="form-group row d-none">
      <label for="inputAttribute" class="col-sm-1 col-form-label d-none">Attribute</label>
      <div class="col-sm-2">
        <input type="text" class="form-control d-none" id="inputAttribute" name="inputAttribute" value="<?php if(isset($data['inputAttribute'])){ echo $data['inputAttribute']; } ?>">
      </div>
      <div id="errorAttribute" class="alert-light p-2 d-none"></div>
    </div>
</div>
  </form>
</div>
