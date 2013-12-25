<div class="form-group">

    <label class="control-label col-lg-4" for="<?=$key?>"><?=$label?></label>

    <div class="col-lg-8">
        <div class="checkbox">
            <label>
                <input type="hidden" name="<?=$key?>" value="" />
                <input type="checkbox"  id="<?=$key?>" name="<?=$key?>" value="да" <? if ($value) echo 'checked="checked"';?>> отметить
            </label>
        </div>
    </div>
</div>