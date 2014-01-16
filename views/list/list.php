<div class="row">
    <div class="col-lg-12">
        <div class="box">
        <header>
            <div class="icons">
                <? if ( $action_buttons[View_List::BUTTON_ADD] AND $model->can_create() ) :?>
                    <div class="btn-group">
                        <a href="<?=$model->get_url('add')?>" class="btn btn-sm btn-primary">
                            <i class="glyphicon-plus glyphicon"></i>
                        </a>
                    </div>
                <? endif;?>
            </div>
            <?php echo "<h5>$title</h5>";?>
            <div class="toolbar">

            </div>
        </header>
        <div id="collapse4" class="body">
        <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">
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
        </div>
        </div>
    </div>
</div>