<?php defined('SYSPATH') or die('No direct script access.');

class Anaconda_View_Form_Field extends View {

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

    public $key;
    public $type;
    public $params = array();

    protected $path_templates = 'form/fields';

    public function get_type()
    {
        return $this->type;
    }

    public function set_type($type)
    {
        return $this->key = $type;
    }

    public function get_key()
    {
        return $this->key;
    }

    public function set_key($key)
    {
        return $this->key = $key;
    }

    public function render($file = NULL)
    {
        // $_template = $this->view ? $this->view : $this->path_templates.DIRECTORY_SEPARATOR.$this->type;
        $this->set('key', $this->get_key());
        return parent::render();
    }

    public function set_filename($file)
    {
        $field_file = trim($this->path_templates, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $file;

        if (($path = Kohana::find_file('views', $field_file)) === FALSE)
        {
            return parent::set_filename($file);
        }

        $this->_file = $path;
        return $this;
    }
}

?>