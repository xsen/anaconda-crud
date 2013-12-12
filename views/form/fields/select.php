<div class="form-group">
    <label class="control-label" for="<?=$key?>"><?=$label?></label>

    <select id="<?=$key?>" name="<?=$key?>" data-placeholder="<?=$placeholder?>" class="form-control chzn-select">
        <?foreach($options as $_key => $_name) :?>
            <option <?=$_key == $value ? 'selected="selected"' : null?> value="<?=$_key?>"><?=$_name?></option>
        <?endforeach;?>
    </select>
</div>
