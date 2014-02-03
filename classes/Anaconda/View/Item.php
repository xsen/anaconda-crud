<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Класс для просмотра объекта
 *
 *
 * @package    Anaconda
 * @category   CRUD
 * @author     Evgeny Leshchenko
 */
class Anaconda_View_Item extends Anaconda_View {
    // Константы кнопок класса
    const BUTTON_EDIT   = 2;
    const BUTTON_DELETE = 3;

    public function __construct($file = NULL, array $data = NULL)
    {
        parent::__construct($file, $data);

        $this->action_buttons = array(
            self::BUTTON_EDIT => FALSE,
            self::BUTTON_DELETE => FALSE
        );
    }

    public function render($file = NULL)
    {
        $this->fields = $this->model->get_fields_view();

        return parent::render($file);
    }
}

?>