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
    // Константы кнопок класса
    const BUTTON_ADD    = 1;
    const BUTTON_EDIT   = 2;
    const BUTTON_DELETE = 3;

    protected $_model;

    public function __construct($file = NULL, array $data = NULL)
    {
        parent::__construct($file, $data);

        $this->list = array();
        $this->columns = array();
        $this->column_links = array();
        $this->action_buttons = array(
            self::BUTTON_ADD => FALSE,
            self::BUTTON_EDIT => FALSE,
            self::BUTTON_DELETE => FALSE
        );
    }

    public function set_column_link($column_key)
    {
        $this->column_links = $column_key;
    }

    public function set_columns(Array $columns)
    {
        $this->columns = $columns;
    }

    public function get_columns()
    {
        if ( !$this->columns ) {
            $this->set_columns($this->model->get_fields_list());
        }

        return $this->columns;
    }

    public function render($file = NULL)
    {
        $this->set('model', $this->model);
        $this->set('columns', $this->get_columns());
        return parent::render($file);
    }

    public function & __get($key)
    {
        if($key === 'model')
        {
            if(empty($this->_model))
            {
                if(empty($this->model_name))
                {
                    throw new Kohana_Exception(__CLASS__ . '::$model_name is not set');
                }

                $this->_model = ORM::factory($this->model_name);
            }

            return $this->_model;
        }

        return parent::__get($key);
    }
}

?>