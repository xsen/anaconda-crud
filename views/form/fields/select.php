<div class="form-group">
    <label class="control-label col-lg-4"><?=$label?></label>
    <div class="col-lg-8">
        <select id="<?=$key?>" name="<?=$key?>" data-placeholder="<?=$placeholder?>" class="form-control chzn-select">
            <?foreach($options as $_key => $_name) :?>
                <option <?=$_key == $value ? 'selected="selected"' : null?> value="<?=$_key?>"><?=$_name?></option>
            <?endforeach;?>
        </select>
    </div>
</div>