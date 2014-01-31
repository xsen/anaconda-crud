<?php defined('SYSPATH') or die('No direct script access.');

abstract class Anaconda_Controller_Template_CRUD extends Controller_Template {

    protected $model_name;
    protected $category_url;

    public function before()
    {
        parent::before();
        $this->category_url = Route::url('default', array('controller' => strtolower(Request::current()->controller())));
        $this->add_crumb($this::get_name(),  $this->category_url);
    }

    public function action_index()
    {
        $this->action_list();
    }

    protected $list_links = array('name');
    protected $list_actions = array(Anaconda_View_List::BUTTON_ADD => true, Anaconda_View_List::BUTTON_EDIT => true, Anaconda_View_List::BUTTON_DELETE => true);

    public function action_list()
    {
        $view = new View_List('list/list');

        $view->model_name = $this->model_name;
        $view->list = $this->get_list();
        $view->title = $this::get_name();
        $view->action_buttons = $this->list_actions;
        $view->set_column_link($this->list_links);

        $this->_before_list_render($view);

        echo $view->render();
    }

    public function action_view()
    {
        $model = ORM::factory($this->model_name, (int) $this->request->param('id'));

        if ( ! $model->loaded() ) throw new HTTP_Exception_404;
        if ( ! $model->can_view() ) throw new HTTP_Exception_403;

        $this->add_crumb($model->get_name(), $model->get_url('view'));

        $view = new View_Item('item/item');

        $view->model = $model;
        $view->title = $this::get_name();
        $view->action_buttons = array(
            View_Item::BUTTON_EDIT   => TRUE,
            View_Item::BUTTON_DELETE => TRUE,
        );

        $this->_before_item_render($view);

        echo $view->render();
    }

    public function action_add()
    {
        $model = ORM::factory($this->model_name);

        if ( !$model->can_create() ) throw new HTTP_Exception_403;

        $this->add_crumb('Создание', '#');
        $this->_model_form($model);
    }

    public function action_edit()
    {
        $model = ORM::factory($this->model_name, (int) $this->request->param('id'));

        if ( ! $model->loaded() ) throw new HTTP_Exception_404;
        if ( ! $model->can_edit() ) throw new HTTP_Exception_403;

        $this->add_crumb($model->get_name(), $model->get_url());
        $this->_model_form($model);
    }

    protected $edit_field_types = array();

    protected function _model_form($model)
    {
        $errors = array();
        if ( $this->request->method() == Request::POST ) {
            $model->values($this->request->post());
            $this->_before_model_save($model);

            try {
                $model->save();
                $this->_after_model_save($model);
            }catch (ORM_Validation_Exception $e) { $errors = $e->errors(); }

            if (!$errors) $this->redirect($this->category_url);
        }

        $action_buttons = array(
            View_Form::BUTTON_DELETE => $model->loaded() ? $model->get_url('delete') : null,
            View_Form::BUTTON_CANCEL => $model->loaded() ? $model->get_url('view') : $this->category_url,
            View_Form::BUTTON_SAVE   => TRUE,
        );

        $view = new View_Form('form/form');
        $model->generate_fields_for_form($view, $this->edit_field_types);
        $view->model = $model;
        $view->title = $model->loaded() ? 'Редактирование' : 'Создание';
        $view->action_buttons = $action_buttons;
        $view->errors($errors);

        $this->_before_form_render($view);

        echo $view->render();
    }

    public function action_delete()
    {
        $model = ORM::factory($this->model_name, (int) $this->request->param('id'));

        if ( ! $model->loaded() ) throw new HTTP_Exception_404;
        if ( ! $model->can_delete() ) throw new HTTP_Exception_403;

        $model->delete();

        $this->redirect($this->category_url);
    }

    protected function get_list()
    {
        return ORM::factory($this->model_name)->find_all()->as_array();
    }

    protected function _before_form_render($view)
    {
    }

    protected function _before_item_render($view)
    {
    }

    protected function _before_list_render($view)
    {
    }

    protected function _before_model_save($model)
    {
    }

    protected function _after_model_save($model)
    {
    }
}

?>