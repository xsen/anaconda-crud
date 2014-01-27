<?
    $timestamp = is_numeric($value) ? intval($value) : strtotime(strval($value));
    $value = $timestamp > 0 ? date('Y-m-d\TH:i:s', $timestamp) : null;
?>

<div class="form-group">
    <label class="control-label col-lg-4" for="<?=$key?>"><?=$label?></label>
    <div class="col-lg-8">
        <input type="datetime-local" class="form-control" id="<?=$key?>" name="<?=$key?>" placeholder="<?=$placeholder?>" value="<?=$value?>">
    </div>
</div>