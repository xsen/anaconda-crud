<div class="row">
    <div class="col-lg-6">
        <div class="box dark">
            <header>
                <div class="icons">
                    <i class="fa fa-edit"></i>
                </div>
                <h5><?=$title?></h5>
            </header>
            <div id="div-1" class="accordion-body collapse in body">
                <form role="form" method="POST" class="form-horizontal">

                    <?
                    foreach($fields as $key => $field) {
                        echo $field;
                    }
                    ?>

                    <? if ($action_buttons[View_Form::BUTTON_SAVE]) :?>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    <? endif;?>

                    <? if ($action_buttons[View_Form::BUTTON_DELETE]) :?>
                        <a href="<?=$action_buttons[View_Form::BUTTON_DELETE]?>" class="btn btn-danger">Удалить</a>
                    <? endif;?>

                    <? if ($action_buttons[View_Form::BUTTON_CANCEL]) :?>
                        <a href="<?=$action_buttons[View_Form::BUTTON_CANCEL]?>" class="btn btn-default">Отмена</a>
                    <? endif;?>
                </form>
            </div>
        </div>
    </div>
</div>

