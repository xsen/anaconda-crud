<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Абстрактный класс отображения данных
 *
 *
 * @package    Anaconda
 * @category   CRUD
 * @author     Evgeny Leshchenko
 */
abstract class Anaconda_View {

    /**
     * @var string  заголовок
     */
    protected $title;

    /**
     * @var string  имя шаблона
     */
    protected $view_name;

    /**
     * @var array Массив для настроки показа кнопок
     */
    protected $action_buttons;


    /**
     * setter title
     *
     * @param string $title
     */
    public function set_title($title)
    {
        $this->title = $title;
    }

    // TODO: описать
    abstract public function set_position();


    /**
     * Рендеринг готового шаблона для вывода
     *
     * @return View
     */
    public function render()
    {
        $view = View::factory($this->view_name);
        $view->title = $this->title;

        return $view;
    }

    /**
     * Настройка показа конкретной кнопки
     *
     * @param string  $type_button
     * @param boolean $is_view
     */
    public function set_button_view($type_button, $is_view)
    {
        $this->action_buttons[$type_button] = $is_view;
    }

    /**
     * Настройка показа всех кнопок
     *
     * @param array $actions
     */
    public function set_buttons_view(Array $actions)
    {
        $this->action_buttons = $actions;;
    }

}

?>