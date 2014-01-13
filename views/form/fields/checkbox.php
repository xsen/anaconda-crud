<div class="form-group">

    <label class="control-label col-lg-4" for="<?=$key?>"><?=$label?></label>

    <div class="col-lg-8">
        <div class="checkbox">
            <label>
                <input type="hidden" name="<?=$key?>" value="Нет" />
                <input type="checkbox"  id="<?=$key?>" name="<?=$key?>" value="Да" <? if ($value) echo 'checked="checked"';?>> отметить
            </label>
        </div>
    </div>
</div>