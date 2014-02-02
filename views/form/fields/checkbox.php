<div class="form-group">

    <label class="control-label col-lg-4" for="<?=$key?>"><?=$label?></label>

    <div class="col-lg-8">
        <div class="checkbox">
            <label>
                <input type="hidden" name="<?=$key?>" value="Нет" />
                <input type="checkbox"  id="<?=$key?>" name="<?=$key?>" value="1" <? if ($value) echo 'checked="checked"';?>>
            </label>
        </div>
    </div>
</div>