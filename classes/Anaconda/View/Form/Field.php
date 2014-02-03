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

    protected $_key;
    protected $_type;

    protected $_path_templates = 'form/fields';

    public static function factory($file = NULL, array $data = NULL)
    {
        return new static($file, $data);
    }

    public function get_type()
    {
        $info = pathinfo($this->_file);
        return $info['filename'];
    }

    public function set_type($type)
    {
        $this->set_filename($type);
    }

    public function get_key()
    {
        return $this->_key;
    }

    public function set_key($key)
    {
        $this->_key = $key;
        $this->set('key', $this->_key);
    }

    public function set_filename($file)
    {
        $field_file = trim($this->_path_templates, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $file;

        if (($path = Kohana::find_file('views', $field_file)) === FALSE)
        {
            return parent::set_filename($file);
        }

        $this->_file = $path;
        return $this;
    }
}

?>