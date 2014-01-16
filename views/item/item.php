<div class="page-header">
    <?php echo "<h3>$title</h3>";?>
</div>

<dl class="dl-horizontal">
    <? foreach ($fields as $_key => $_field) :?>
        <dt><?=$_field?></dt>
        <?php
            $_value = trim($model->get_value($_key, Model::GET_TYPE_ITEM ));

            if ( !$_value ) {
                $_value = 'не установлено';
            }
        ?>
        <dd><?=$_value?></dd>
        <br>
    <?endforeach;?>
</dl>

<div class="well">
    <? if ($action_buttons[View_Item::BUTTON_EDIT] AND $model->can_edit()) :?>
        <a href="<?=$model->get_url('edit')?>" class="btn btn-primary">Редактировать</a>
    <? endif;?>
    <? if ($action_buttons[View_Item::BUTTON_DELETE] AND $model->can_delete()) :?>
        <a href="<?=$model->get_url('delete')?>" class="btn btn-danger">Удалить</a>
    <? endif;?>
</div>