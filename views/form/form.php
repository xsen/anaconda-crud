<form role="form" method="POST">
    <?=$fields?>

    <? if ($action_buttons[View_Form::BUTTON_SAVE]) :?>
        <button type="submit" class="btn btn-default">Сохранить</button>
    <? endif;?>

    <? if ($action_buttons[View_Form::BUTTON_DELETE]) :?>
        <button type="submit" class="btn btn-default">Сохранить</button>
    <? endif;?>

    <? if ($action_buttons[View_Form::BUTTON_CANCEL]) :?>
        <button type="submit" class="btn btn-default">Отмена</button>
    <? endif;?>

</form>