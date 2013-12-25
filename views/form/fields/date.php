<?
    $timestamp = strtotime($value);
    $value = $timestamp > 0 ? date('Y-m-d', $timestamp) : null;
?>

<div class="form-group">
    <label class="control-label col-lg-4" for="<?=$key?>"><?=$label?></label>
    <div class="col-lg-8">
        <input type="date" class="form-control" id="<?=$key?>" name="<?=$key?>" placeholder="<?=$placeholder?>" value="<?=$value?>">
    </div>
</div>