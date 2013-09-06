<div class="page-header">
    <?php echo "<h3>$title</h3>";?>
</div>

<dl class="dl-horizontal">
    <? foreach ($fields as $_key => $_field) :?>
        <dt><?=$_field?></dt>
        <dd><?=$model->get_value_view($_key)?></dd>
        <br>
    <?endforeach;?>
</dl>

<div class="well">
    <? if ($action_buttons[View_Item::BUTTON_EDIT]) :?>
        <a href="<?=$model->get_url('edit')?>" class="btn btn-default">Редактировать</a>
    <? endif;?>
    <? if ($action_buttons[View_Item::BUTTON_DELETE]) :?>
        <a href="<?=$model->get_url('delete')?>" class="btn btn-default">Удалить</a>
    <? endif;?>
</div>