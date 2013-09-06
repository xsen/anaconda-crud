<?php defined('SYSPATH') or die('No direct script access.');

class Anaconda_View_Item extends Anaconda_View {

    protected $model;
    protected $view_name = 'item/item';
    protected $excluded_fields;

    const BUTTON_EDIT   = 2;
    const BUTTON_DELETE = 3;

    protected $action_buttons = array(
        self::BUTTON_EDIT => FALSE,
        self::BUTTON_DELETE => FALSE
    );

    public function __construct($model, $excluded = array())
    {
        $this->model = $model;
        $this->excluded_fields = $excluded;
    }

    public function render()
    {
        $view = parent::render();
        $view->model = $this->model;
        $view->fields = $this->model->get_fields_view();
        $view->action_buttons = $this->action_buttons;

        return $view->render();
    }

    public function set_position()
    {
    }
}

?>