<?php defined('SYSPATH') or die('No direct script access.');

class Anaconda_View_Form_Field {

    const DATE = 'date';
    const FILE = 'file';
    const TEXT = 'text';
    const VIEW = 'view';
    const SELECT = 'select';
    const MULTI_SELECT = 'select';
    const TEXTAREA = 'textarea';
    const PASSWORD = 'password';
    const CHECKBOX = 'checkbox';
    const HIDDEN = 'hiden';
    const EXCLUDE = 'exclude';

    protected $key;
    protected $type;
    protected $label;
    protected $value;
    protected $placeholder;

    protected $path_templates = 'form/fields';

    public static function factory($field_type, $key, Array $params = array())
    {
        return new View_Form_Field($field_type, $key, $params);
    }

    public function __construct($field_type, $key, Array $params = array())
    {
        $this->type = $field_type; // TODO: check type
        $this->key = $key;

        foreach ($params as $_key => $_value) {
            $this->{$_key} = $_value;
        }
    }

    public function get_key()
    {
        return $this->key;
    }

    public function get_label()
    {
        return $this->label;
    }

    public function get_value()
    {
        return $this->value;
    }

    public function get_placeholder()
    {
        return $this->placeholder;
    }

    public function set_key($key)
    {
        return $this->key = $key;
    }

    public function set_value($value)
    {
        return $this->value = $value;
    }

    public function set_label($label)
    {
        return $this->label = $label;
    }

    public function set_placeholder($placeholder)
    {
        return $this->placeholder = $placeholder;
    }

    public function render()
    {
        $view =  View::factory($this->path_templates.DIRECTORY_SEPARATOR.$this->type);
        $view->key = $this->get_key();
        $view->label = $this->get_label();
        $view->value = $this->get_value();
        $view->placeholder = $this->get_placeholder();

        return $view;
    }
}

?>