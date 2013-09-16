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

    /**
     * @var string  имя шаблона
     */
    protected $view_name = 'item/item';

    // Константы кнопок класса
    const BUTTON_EDIT   = 2;
    const BUTTON_DELETE = 3;

    /**
     * @var array Массив для настроки показа кнопок
     */
    protected $action_buttons = array(
        self::BUTTON_EDIT => FALSE,
        self::BUTTON_DELETE => FALSE
    );

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Рендеринг готового шаблона для вывода
     *
     * @return View
     */
    public function render()
    {
        $view = parent::render();
        $view->model = $this->model;
        $view->fields = $this->model->get_fields_view();
        $view->action_buttons = $this->action_buttons;

        return $view->render();
    }

    // todo: реализовать метод
    public function set_position()
    {
    }
}

?>