<?php defined('SYSPATH') or die('No direct script access.');

class Anaconda_View_Form extends Anaconda_View {
    public $errors = array();
    public $fields = array();
    public $input_name = '';

    const BUTTON_SAVE    = 1;
    const BUTTON_CANCEL  = 2;
    const BUTTON_DELETE  = 3;

    public function __construct($file = NULL, array $data = NULL)
    {
        parent::__construct($file, $data);

        $this->action_buttons = array(
            self::BUTTON_SAVE   => TRUE,
            self::BUTTON_CANCEL => false,
            self::BUTTON_DELETE => false
        );
    }

    public function add_field($field_type, $key, Array $params = array())
    {
        if ( $field_type == View_Form_Field::EXCLUDE )
            return;

        $field = new View_Form_Field($field_type);
        $field->set($params);
        $field->set_key($key);
        $this->fields[$key] = $field;
    }

    public function errors(Array $errors = array())
    {
        if ($errors)
        {
            $this->errors = $errors;
        }

        return $this->errors;
    }

    public function render($file = NULL)
    {
        foreach($this->get_fields() as $field)
        {
            $field->set('key', $this->get_input_name_for($field->get_key()));
        }

        $this->set('form', $this);
        $this->set('fields', $this->fields);

        return parent::render($file);
    }

    public function get_fields()
    {
        return $this->fields;
    }

    public function get_input_name_for($key) {
        $key = strval($key);
        $keys = explode('[', $key);

        if($this->input_name) {
            $keys[0] .= ']';
            array_unshift($keys, $this->input_name);
        }

        return implode('[', $keys);
    }
}

?>