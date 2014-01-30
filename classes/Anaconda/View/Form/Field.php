<?php defined('SYSPATH') or die('No direct script access.');

class Anaconda_View_Form_Field {

    const DATE = 'date';
    const DATETIME = 'datetime';
    const FILE = 'file';
    const TEXT = 'text';
    const INT = 'int';
    const VIEW = 'view';
    const SELECT = 'select';
    const MULTI_SELECT = 'multi_select';
    const TEXTAREA = 'textarea';
    const PASSWORD = 'password';
    const CHECKBOX = 'checkbox';
    const HIDDEN = 'hiden';
    const DISABLED = 'disabled';
    const EXCLUDE = null;

    protected $key;
    protected $type;
    protected $params;
    protected $view;
    protected $path_templates = 'form/fields';

    public static function factory($field_type, $key, Array $params = array())
    {
        return new View_Form_Field($field_type, $key, $params);
    }

    public function __construct($field_type, $key, Array $params = array())
    {
        // TODO: check all params
        $this->type = $field_type;
        $this->key = $key;
        $this->params = $params;
    }

    public function get_key()
    {
        return $this->key;
    }

    public function set_key($key)
    {
        return $this->key = $key;
    }

    public function render()
    {
        $_template = $this->view ? $this->view : $this->path_templates.DIRECTORY_SEPARATOR.$this->type;

        $view =  View::factory($_template);
        $view->key = $this->get_key();

        foreach ($this->params as $_key => $_value) {
            $view->{$_key} = $_value;
        }

        return $view;
    }

    /**
     * @param $view
     */
    public function set_view($view)
    {
        $this->view = $view;
    }
}

?>