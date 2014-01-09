<?php defined('SYSPATH') or die( 'No direct script access.' );

/**
 * Расширение фукнций ORM Kohana:
 *
 *
 * @package    Anaconda
 * @category   CRUD
 * @author     Evgeny Leshchenko
 */

class Anaconda_ORM extends Kohana_ORM
{

    /**
     * @var boolean  Включить автоматическое преобразование всех HTML сущностей для защиты
     */
    protected $_auto_HTML_encode = true;

    protected $_files = array();

    /**
     * Displays the primary key of a model when it is converted to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->get_name();
    }

    /**
     * Фильтры для валидации данных
     *
     * @return array
     */
    public function filters()
    {
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

    protected function _initialize()
    {
        // Set the object name and plural name
        $this->_object_name = strtolower(substr(get_class($this), 6));

        // Check if this model has already been initialized
        if ( ! $init = Arr::get(ORM::$_init_cache, $this->_object_name, FALSE))
        {
            $init = array(
                '_belongs_to' => array(),
                '_has_one'    => array(),
                '_has_many'   => array(),
                '_files'      => array(),
            );

            // Set the object plural name if none predefined
            if ( ! isset($this->_object_plural))
            {
                $init['_object_plural'] = Inflector::plural($this->_object_name);
            }

            if ( ! $this->_errors_filename)
            {
                $init['_errors_filename'] = $this->_object_name;
            }

            if ( ! is_object($this->_db))
            {
                // Get database instance
                $init['_db'] = Database::instance($this->_db_group);
            }

            if (empty($this->_table_name))
            {
                // Table name is the same as the object name
                $init['_table_name'] = $this->_object_name;

                if ($this->_table_names_plural === TRUE)
                {
                    // Make the table name plural
                    $init['_table_name'] = Arr::get($init, '_object_plural', $this->_object_plural);
                }
            }

            $defaults = array();

            foreach ($this->_belongs_to as $alias => $details)
            {
                if ( ! isset($details['model']))
                {
                    $defaults['model'] = str_replace(' ', '_', ucwords(str_replace('_', ' ', $alias)));
                }

                $defaults['foreign_key'] = $alias.$this->_foreign_key_suffix;

                $init['_belongs_to'][$alias] = array_merge($defaults, $details);
            }

            foreach ($this->_files as $alias)
            {
                $defaults['model'] = 'File';
                $defaults['foreign_key'] = 'file'.$this->_foreign_key_suffix;

                $init['_files'][$alias] = $defaults;
            }

            foreach ($this->_has_one as $alias => $details)
            {
                if ( ! isset($details['model']))
                {
                    $defaults['model'] = str_replace(' ', '_', ucwords(str_replace('_', ' ', $alias)));
                }

                $defaults['foreign_key'] = $this->_object_name.$this->_foreign_key_suffix;

                $init['_has_one'][$alias] = array_merge($defaults, $details);
            }

            foreach ($this->_has_many as $alias => $details)
            {
                if ( ! isset($details['model']))
                {
                    $defaults['model'] = str_replace(' ', '_', ucwords(str_replace('_', ' ', Inflector::singular($alias))));
                }

                $defaults['foreign_key'] = $this->_object_name.$this->_foreign_key_suffix;
                $defaults['through'] = NULL;

                if ( ! isset($details['far_key']))
                {
                    $defaults['far_key'] = Inflector::singular($alias).$this->_foreign_key_suffix;
                }

                $init['_has_many'][$alias] = array_merge($defaults, $details);
            }

            ORM::$_init_cache[$this->_object_name] = $init;
        }

        // Assign initialized properties to the current object
        foreach ($init as $property => $value)
        {
            $this->{$property} = $value;
        }

        // Load column information
        $this->reload_columns();

        // Clear initial model state
        $this->clear();
    }

    /**
     * Updates or Creates the record depending on loaded()
     * Добавлена конвертация всех полей с типом Date для корректного хранения
     * @chainable
     *
     * @param  Validation $validation Validation object
     *
     * @return ORM
     */
    public function save(Validation $validation = null)
    {
        $columns = $this->table_columns();

        foreach ($columns as $_key => $_column) {
            if ($_column['data_type'] != 'date') {
                continue;
            }

            $this->$_key = $this->_convert_date_to_mysql($this->$_key);
        }

        parent::save($validation);
    }

    // TODO: описать метод
    public function get_url($action = 'view')
    {
        $route_name = isset( $routes[$this->_object_name] ) ? $this->_object_name : 'default';

        $params = array('action' => $action, 'controller' => strtolower(Request::current()->controller()));
        if ($this->loaded()) {
            $params['id'] = $this->pk();
        }

        return Route::url($route_name, $params);
    }

    /**
     * Handles getting of column
     * Override this method to add custom get behavior
     *
     * Добавлена конвертация данных для коректного получение полей с типом Date // TODO обновить
     *
     * @param   string $column Column name
     *
     * @throws Kohana_Exception
     * @return mixed
     */
    public function get($column)
    {
        if (isset($this->_files[$column]))
        {
            $model = ORM::factory($this->_files[$column]['model']);
            $col = $model->_object_name.'.'.$this->_files[$column]['foreign_key'];
            $val = $this->pk();

            return $model->where($col, '=', $val);
        }else {
            $value = parent::get($column);
            $columns = $this->table_columns();

            if (isset( $columns[$column]['data_type'] ) AND $columns[$column]['data_type'] == 'date') {
                $value = $this->_get_date($value);
            }

            return $value;
        }
    }

    /**
     * getter name
     * @return mixed
     */
    public function get_name()
    {
        return $this->pk();
    }

    /**
     * Авмтоматическая генерация полей для класса View_Form
     *
     * @param View_Form $view  объект формы
     * @param array     $types типы полей
     *
     * @return View_Form
     */
    public function generate_fields_for_form(View_Form $view, Array $types = array())
    {
        $labels  = $this->labels();
        $fields  = $this->loaded() ? $this->get_fields_edit() : $this->get_fields_add();
        $columns = $this->table_columns();

        foreach ($fields as $_key => $_name) {

            $params = array(
                'value'       => $this->loaded() ? $this->get_value($_key, Model::GET_TYPE_EDIT) : $this->get_value($_key, Model::GET_TYPE_ADD),
                'label'       => $labels[$_key],
                'placeholder' => 'Введите ' . $labels[$_key],
            );

            $field_type = View_Form_Field::TEXT;

            // Default types
            if ( isset($columns[$_key]['data_type']) ) {
                $field_type = $this->_get_form_field_type($columns[$_key]['data_type']);

                if ( $columns[$_key]['data_type'] == 'enum' ) {
                    foreach( $columns[$_key]['options'] as $_options ) {
                        $params['options'][$_options] = $_options;
                    }
                }
            }

            // Extended types
            if ( array_key_exists($_key, $types) ) {
                $field_type = $types[$_key];
            }

            // Relationships types
            $all_relationships = array_merge($this->_belongs_to, $this->_has_many, $this->_has_one);
            if ( array_key_exists($_key, $all_relationships) ) {
                $relationship = $all_relationships[$_key];

                $params['value'] = $params['value']->pk();
                $params['options'] = ORM::factory($relationship['model'])->get_list_of_relationship($this);

                $field_type = array_key_exists($_key, $this->_has_many) ? View_Form_Field::MULTI_SELECT : View_Form_Field::SELECT;
                $_key = $relationship['foreign_key'];
            }

            if ( array_key_exists($_key, $this->_files) ) {
                $field_type = View_Form_Field::FILE;
            }

            $view->add_field($field_type, $_key, $params);
        }

        return $view;
    }

    /**
     * Получение типа поля для конкретного типа данных
     *
     * @param string $data_type
     *
     * @return string
     */
    protected function _get_form_field_type($data_type)
    {
        switch ($data_type) {

            case 'date' :
            {
                return View_Form_Field::DATE;
            }

            case 'enum' :
            {
                return View_Form_Field::SELECT;
            }

            case 'text' :
            {
                return View_Form_Field::TEXTAREA;
            }

            case 'int' :
            {
                return View_Form_Field::INT;
            }

            case 'varchar' :
            {
                return View_Form_Field::TEXT;
            }

            default :
            {
                return View_Form_Field::TEXT;
            }
        }
    }


    protected function get_list_of_relationship($parent)
    {
        $list = array();
        $objects = $this->find_all();

        foreach ($objects as $_object) {
            $list[$_object->pk()] = $_object->get_name();
        }

        return $list;
    }

    /**
     * Конвертация строки в нормальный формат даты
     * @param  string $date Дата
     *
     * @return string
     */
    protected function _convert_date_to_mysql($date)
    {
        $timestamp = strtotime($date);
        return $timestamp > 0 ? date('Y-m-d', $timestamp) : null;
    }

    /**
     * Получение корректной даты из строки
     * @param  string $value Дата
     *
     * @return string
     */
    protected function _get_date($value)
    {

        if ($value == '00.00.0000' OR $value == '01.01.1970' OR $value == '1970-01-01' OR $value == '0000-00-00') {
            return false;
        }
        $timestamp = strtotime($value);

        return $timestamp ? date('d.m.Y', $timestamp) : null;
    }
}

?>