<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Класс для просмотра списка объектов
 *
 *
 * @package    Anaconda
 * @category   CRUD
 * @author     Evgeny Leshchenko
 */
class Anaconda_View_List extends Anaconda_View {

    /**
     * @var array массив объектов для вывода
     */
    protected $list;

    /**
     * @var array список колонок для выводав таблицу
     */
    protected $columns;

    /**
     * @var array список ссылок для переходав просмотр объекта
     */
    protected $column_links = array();

    /**
     * @var string  имя шаблона
     */
    protected $view_name = 'list/list';

    // Константы кнопок класса
    const BUTTON_ADD    = 1;
    const BUTTON_EDIT   = 2;
    const BUTTON_DELETE = 3;

    /**
     * @var array Массив для настроки показа кнопок
     */
    protected $action_buttons = array(
        self::BUTTON_ADD => FALSE,
        self::BUTTON_EDIT => FALSE,
        self::BUTTON_DELETE => FALSE
    );

    public function __construct($model_name, Array $list)
    {
        $this->list = $list;
        $this->model = Model::factory($model_name);
    }

    /**
     * setter
     *
     * @param array $column_key
     */
    public function set_column_link($column_key)
    {
        $this->column_links = $column_key;
    }

    /**
     * setter
     *
     * @param array $columns
     */
    public function set_columns(Array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * Рендеринг готового шаблона для вывода
     *
     * @return View
     */
    public function render()
    {
        $view = parent::render();

        $view->list = $this->list;
        $view->model = $this->model;
        $view->columns = $this->get_columns();
        $view->column_links = $this->column_links;
        $view->action_buttons = $this->action_buttons;

        return $view->render();
    }

    /**
     * getter
     *
     * @return array
     */
    protected function get_columns()
    {
        if ( !$this->columns ) {
            $this->set_columns($this->model->get_fields_list());
        }

        return $this->columns;
    }

    // todo: реализовать
    public function set_position()
    {

    }
}

?>