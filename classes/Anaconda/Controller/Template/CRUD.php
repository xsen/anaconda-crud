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
    protected $list_actions = array(View_List::BUTTON_ADD => true, View_List::BUTTON_EDIT => true, View_List::BUTTON_DELETE => true);

    public function action_list()
    {
        $view = new View_List($this->model_name, $this->get_list());
        $view->set_title($this::get_name());
        $view->set_buttons_view($this->list_actions);
        $view->set_column_link($this->list_links);

        echo $view->render();
    }

    public function action_view()
    {

        $model = ORM::factory($this->model_name, (int) $this->request->param('id'));

        if ( ! $model->loaded() ) throw new HTTP_Exception_404;
        if ( ! $model->can_view() ) throw new HTTP_Exception_403;

        $this->add_crumb($model->get_name(), $model->get_url('view'));

        $action_buttons = array(
            View_Item::BUTTON_EDIT   => TRUE,
            View_Item::BUTTON_DELETE => TRUE,
        );

        $view = new View_Item($model);
        $view->set_title($this::get_name());
        $view->set_buttons_view($action_buttons);

        echo $view->render();
    }

    protected $edit_field_types = array();

    public function action_add($edit = null)
    {
        $model = $edit ? $edit : ORM::factory($this->model_name);
        if ( !$model->loaded() AND !$model->can_add() ) throw new HTTP_Exception_403;

        $errors = array();
        if ( $this->request->method() == Request::POST ) {

            $model->values($this->request->post());
            $model = $this->_before_model_save($model);

            try {
                $model->save();
            }catch (ORM_Validation_Exception $e) { $errors = $e->errors(); }

            if (!$errors) $this->redirect($this->category_url);
        }

        $this->add_crumb($model->loaded() ? 'Редактирование' : 'Создание', '#');

        $action_buttons = array(
            View_Form::BUTTON_DELETE => $model->loaded() ? $model->get_url('delete') : null,
            View_Form::BUTTON_CANCEL => $model->loaded() ? $model->get_url('view') : $this->category_url,
            View_Form::BUTTON_SAVE   => TRUE,
        );

        $view = $model->generate_fields_for_form(new View_Form, $this->edit_field_types);
        $view->set_title($model->loaded() ? 'Редактирование' : 'Создание');
        $view->set_buttons_view($action_buttons);
        $view->errors($errors);

        $view = $this->_before_form_render($view, $model);
        echo $view->render();
    }

    public function action_edit()
    {
        $model = ORM::factory($this->model_name, (int) $this->request->param('id'));
        if ( ! $model->loaded() ) throw new HTTP_Exception_404;
        if ( ! $model->can_edit() ) throw new HTTP_Exception_403;

        $this->add_crumb($model->get_name(), $model->get_url());
        $this->action_add($model);
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


    /**
     * @param View_Form $view
     * @param ORM $model

     * @return  View_Form
     */
    protected function _before_form_render($view, $model)
    {
        return $view;
    }

    /**
     * @param ORM $model

     * @return ORM
     */
    protected function _before_model_save($model)
    {
        return $model;
    }

}

?>