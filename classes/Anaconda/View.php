<?php defined('SYSPATH') or die('No direct script access.');

abstract class Anaconda_View {

    protected $title;
    protected $view_name;
    protected $action_buttons;

    public function set_title($title)
    {
        $this->title = $title;
    }

    abstract public function set_position();


    public function render()
    {
        $view = View::factory($this->view_name);
        $view->title = $this->title;

        return $view;
    }

    public function set_button_view($type_button, $is_view)
    {
        $this->action_buttons[$type_button] = $is_view;
    }

    public function set_buttons_view(Array $actions)
    {
        $this->action_buttons = $actions;;
    }

}

?>