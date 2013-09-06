<?php defined('SYSPATH') or die('No direct script access.');

class Anaconda_View_List extends Anaconda_View {

    protected $list;
    protected $columns;
    protected $column_links = array();
    protected $view_name = 'list/list';

    const BUTTON_ADD    = 1;
    const BUTTON_EDIT   = 2;
    const BUTTON_DELETE = 3;

    protected $action_buttons = array(
        self::BUTTON_ADD => FALSE,
        self::BUTTON_EDIT => FALSE,
        self::BUTTON_DELETE => FALSE
    );

    public function __construct($model_name, Array $list)
    {
        $this->list = $list;
        $this->model = Model::factory($model_name);
    }

    public function set_column_link($column_key)
    {
        $this->column_links = $column_key;
    }

    public function set_columns(Array $columns)
    {
        $this->columns = $columns;
    }

    public function render()
    {
        $view = parent::render();

        $view->list = $this->list;
        $view->model = $this->model;
        $view->columns = $this->get_columns();
        $view->column_links = $this->column_links;
        $view->action_buttons = $this->action_buttons;

        return $view->render();
    }


    protected function get_columns()
    {
        if ( !$this->columns ) {
            $this->set_columns($this->model->get_fields_list());
        }

        return $this->columns;
    }

    public function set_position()
    {

    }
}

?>