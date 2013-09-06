<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Расширение фукнций ORM Kohana:
 *
 *
 * @package    Anaconda
 * @category   ORM
 * @author     Evgeny Leshchenko
 */

class Anaconda_ORM extends Kohana_ORM {

    /**
     * @var boolean  Включить автоматическое преобразование всех HTML сущностей для защиты
     */
    protected $_auto_HTML_encode = TRUE;

    /**
     * Фильтры для валидации данных
     *
     * @return array
     */
    public function filters() {
        $filters = parent::filters();

        if ($this->_auto_HTML_encode) {
            array_merge(
                $filters,
                array(
                    true => array(
                        array(array('HTML', 'entities'))
                    )
                )
            );
        }

        return $filters;
    }

    /**
     * Метод для создание правил просмотра объекта
     * TODO: указать места где используется
     * @return boolean
     */
    public function can_view ()
    {
        return TRUE;
    }

    /**
     * Метод для создание правил добавление объекта
     * TODO: указать места где используется
     * @return boolean
     */
    public function can_add ()
    {
        return TRUE;
    }

    /**
     * Метод для создание правил редактирования объекта
     * TODO: указать места где используется
     * @return boolean
     */
    public function can_edit ()
    {
        return $this->can_add();
    }

    /**
     * Метод для создание правил удаления объекта
     * TODO: указать места где используется
     * @return boolean
     */
    public function can_delete ()
    {
        return $this->can_edit();
    }


    /**
     * Updates or Creates the record depending on loaded()
     * Добавлена конвертация всех полей с типом Date для корректного хранения
     * @chainable
     * @param  Validation $validation Validation object
     * @return ORM
     */
    public function save(Validation $validation = NULL) {
        $columns = $this->table_columns();

        foreach ($columns as $_key => $_column) {
            if ($_column['data_type'] != 'date') continue;

            $this->$_key = $this->_convert_date_to_mysql($this->$_key);
        }

        parent::save($validation);
    }

    public function get_url($action = 'view')
    {
        $route_name = isset($routes[$this->_object_name]) ? $this->_object_name : 'default';

        $params = array('action' => $action);
        if ( $this->loaded() ) $params['id'] = $this->pk();

        return Route::url($route_name, $params);
    }

    /**
     * Handles getting of column
     * Override this method to add custom get behavior
     *
     * Добавлена конвертация данных для коректного получение полей с типом Date
     * @param   string $column Column name
     * @throws Kohana_Exception
     * @return mixed
     */
    public function get($column) {
        $value = parent::get($column);
        $columns = $this->table_columns();

        if ( isset($columns[$column]['data_type']) AND $columns[$column]['data_type'] == 'date' ) {
            $value = $this->_get_date($value);
        }

        return $value;
    }

    public function get_fields_list()
    {
        return $this->labels();
    }

    public function get_fields_view()
    {
        return $this->labels();
    }

    public function get_fields_add()
    {
        return $this->labels();
    }

    public function get_fields_edit()
    {
        return $this->labels();
    }

    public function get_value_list($column)
    {
        return $this->get($column);
    }

    public function get_value_view($column)
    {
        return $this->get($column);
    }

    public function get_value_add($column)
    {
        return $this->get($column);
    }

    public function get_value_edit($column)
    {
        return $this->get($column);
    }

    public function get_name()
    {
        return $this->name;
    }

    public function generate_fields_for_form(View_Form $view, Array $types = array())
    {
        $labels = $this->labels();
        $fields = $this->loaded() ? $this->get_fields_edit() : $this->get_fields_add();
        $columns = $this->table_columns();

        foreach ($fields as $_key => $_name) {
            $params = array(
                'value' => $this->loaded() ? $this->get_value_edit($_key) : $this->get_value_add($_key),
                'placeholder' => 'Введите '.$labels[$_key],
            );

            $field_type = $this->_get_form_field_type($columns[$_key]['data_type']);
            $view->add_field($field_type, $_key, $params);
        }

        return $view;
    }

    protected function _get_form_field_type($data_type)
    {
        switch ($data_type) {

            case 'date' : {
                return View_Form_Field::DATE;
            }

            case 'string' : {
                return View_Form_Field::TEXTAREA;
            }

            default : {
                return View_Form_Field::TEXT;
            }
        }
    }

    /**
     * Конвертация строки в нормальный формат даты
     * @param  string $date Дата
     * @return string
     */
    protected function _convert_date_to_mysql($date) {
        $timestamp = strtotime($date);
        return $timestamp > 0 ? date('Y-m-d', $timestamp) : null;
    }

    /**
     * Получение корректной даты из строки
     * @param  string $value Дата
     * @return string
     */
    protected function _get_date($value) {

        if ( $value == '00.00.0000' OR $value == '01.01.1970' OR $value == '1970-01-01' OR $value == '0000-00-00') { return false; }
        $timestamp = strtotime($value);

        return $timestamp ? date('d.m.Y', $timestamp) : null;
    }
}
?>