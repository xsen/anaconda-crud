<?php defined('SYSPATH') or die('No direct script access.');

class Anaconda_View_Form extends Anaconda_View {

    public $view_name = 'form/form';

    protected $_errors = array();
    protected $_fields = array();

    const BUTTON_SAVE    = 1;
    const BUTTON_CANCEL  = 2;
    const BUTTON_DELETE  = 3;

    protected $action_buttons = array(
        self::BUTTON_SAVE   => TRUE,
        self::BUTTON_CANCEL => TRUE,
        self::BUTTON_DELETE => FALSE
    );

    public function add_field($field_type, $key, Array $params = array())
    {
        $field = View_Form_Field::factory($field_type, $key, $params);
        $this->_fields[$key] = $field;
    }

    public function errors(Array $errors = array())
    {
        if ($errors)
        {
            $this->_errors = $errors;
        }

        return $this->_errors;
    }

    public function render()
    {
        $view = View::factory($this->view_name);
        $view->action_buttons = $this->action_buttons;
        $fields = '';

        foreach ($this->get_fields() as $_field) {
            $fields .= $_field->render();
        }

        $view->fields = $fields;

        return $view;
    }

    public function get_fields()
    {
        return $this->_fields;
    }

    public function set_position()
    {

    }
}

?>