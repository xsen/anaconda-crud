<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Anaconda_Model extends Kohana_Model {

    /**
     * Константы для получение корректных значений с помощью геттеров
     */
    const GET_TYPE_LIST = 1;
    const GET_TYPE_ITEM = 2;
    const GET_TYPE_ADD  = 3;
    const GET_TYPE_EDIT = 4;
    const GET_TYPE_DEFAULT = 0;


    /**
     * Метод для создание правил просмотра объекта
     * @return boolean
     */
    public function can_view()
    {
        return true;
    }

    /**
     * Метод для создание правил добавление объекта
     * @return boolean
     */
    public function can_create()
    {
        return true;
    }

    /**
     * Метод для создание правил редактирования объекта
     * @return boolean
     */
    public function can_edit()
    {
        return $this->can_create();
    }

    /**
     * Метод для создание правил удаления объекта
     * @return boolean
     */
    public function can_delete()
    {
        return $this->can_edit();
    }

    /**
     * Получения значения с помощью геттера или напрямую из свойства класса
     *
     * @param  string $key Column name
     * @param  int $type Тип получения данных (для разграничения типа выводимых данных в геттерах)
     *
     * @throws Kohana_Exception
     * @return mixed
     */
    public function get_value($key, $type = self::GET_TYPE_DEFAULT)
    {
        $_method_name = 'get_'.$key;
        return method_exists($this, $_method_name) ? $this->$_method_name($type) : $this->$key;
    }

    /**
     * Label definitions for validation
     *
     * @return array
     */
    public function labels()
    {
        return array();
    }

    /**
     * Список полей для отображение с использованием класса View_List
     *
     * @return array
     */
    public function get_fields_list()
    {
        return $this->labels();
    }


    /**
     * Список полей для отображение с использованием класса View_Item
     *
     * @return array
     */
    public function get_fields_view()
    {
        return $this->labels();
    }

    /**
     * Список полей для отображение с использованием класса List_Form
     *
     * @return array
     */
    public function get_fields_add()
    {
        return $this->labels();
    }


    /**
     * Список полей для отображение с использованием класса List_Form
     *
     * @return array
     */
    public function get_fields_edit()
    {
        return $this->get_fields_add();
    }

}
