<div class="page-header">
    <?php echo "<h3>$title</h3>";?>
</div>

<? if ( $action_buttons[View_List::BUTTON_ADD] AND $model->can_add() ) :?>
    <a href="<?=$model->get_url('add')?>" class="btn btn-lg btn-default">Создать</a>
<? endif;?>

<table class="table">
    <thead>
    <tr>
        <? foreach ($columns as $_name) :?>
            <th><?=$_name?></th>
        <? endforeach;?>
    </tr>
    </thead>

    <tbody>
    <? foreach ($list as $model) :?>
        <? if ( !$model->can_view() ) continue; ?>
        <tr>
            <? foreach ($columns as $_key => $_name) :?>
                <? $_value = $model->get_value($_key, Model::GET_TYPE_LIST )?>
                <td>
                    <?= in_array($_key, $column_links) ? '<a href="'.$model->get_url().'">'.$_value.'</a>' : $_value ?>
                </td>
            <? endforeach;?>
        </tr>
    <? endforeach;?>
    </tbody>
</table>