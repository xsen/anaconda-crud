<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Класс для создания HTML форм
 *
 *
 * @package    Anaconda
 * @category   CRUD
 * @author     Evgeny Leshchenko
 */
class Anaconda_View_Form extends Anaconda_View {

    /**
     * @var string  имя шаблона
     */
    public $view_name = 'form/form';

    /**
     * @var array поля не прошедшие валидацию формата key => error text
     */
    protected $_errors = array();

    /**
     * @var array объекты View_Form_Field
     */
    protected $_fields = array();

    // Константы кнопок класса
    const BUTTON_SAVE    = 1;
    const BUTTON_CANCEL  = 2;
    const BUTTON_DELETE  = 3;

    /**
     * @var array Массив для настроки показа кнопок
     */
    protected $action_buttons = array(
        self::BUTTON_SAVE   => TRUE,
        self::BUTTON_CANCEL => false,
        self::BUTTON_DELETE => false
    );

    /**
     * Добавление поля
     *
     * @param string $field_type Тип поля (см. константы View_Form_Field)
     * @param string $key ключ поля (id, name)
     * @param array  $params дополнительные параметры поля(value, placeholder, etc)
     *
     * @return void
     */
    public function add_field($field_type, $key, Array $params = array())
    {
        if ( $field_type != View_Form_Field::EXCLUDE ) {
            $field = View_Form_Field::factory($field_type, $key, $params);
            $this->_fields[$key] = $field;
        }
    }

    /**
     * Получение/Добавление ошибок к форме
     *
     * @param array $errors
     *
     * @return array
     */
    public function errors(Array $errors = array())
    {
        if ($errors)
        {
            $this->_errors = $errors;
        }

        return $this->_errors;
    }

    /**
     * Рендеринг готового шаблона для вывода
     *
     * @return View
     */
    public function render()
    {
        $view = View::factory($this->view_name);
        $view->title = $this->title;
        $view->action_buttons = $this->action_buttons;

        $fields = '';

        foreach ($this->get_fields() as $_field) {
            $fields .= $_field->render();
        }

        $view->fields = $fields;

        return $view;
    }

    /**
     * getter $_fields
     *
     * @return array
     */
    public function get_fields()
    {
        return $this->_fields;
    }

    // todo: реализовать
    public function set_position()
    {

    }
}

?>