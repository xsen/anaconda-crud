<?php defined('SYSPATH') or die('No direct script access.');

class Model_History extends Anaconda_ORM {

    /**
     * @param ORM $model
     * @param array $new_data
     * @param array $old_data
     */
    public function create_history($model, $data_new, $data_old)
    {
        $this->user_id = Auth::instance()->get_user()->pk();
        $this->model_id = $model->pk();
        $this->model_name = $model->object_name();
        $this->datetime = Date::formatted_time();
        $this->data_new = serialize($data_new);
        $this->data_old = serialize($data_old);

        return $this->save();
    }

    public function get_user()
    {
        return ORM::factory('User', $this->user_id);
    }

    public function get_diff()
    {
        $diff_result = array();

        $data_new = (array) unserialize($this->data_new);
        $data_old = (array) unserialize($this->data_old);

        $diff_keys = array_keys(array_diff($data_new, $data_old));
        foreach($diff_keys as $_key) {
            $diff_result[$_key] = array(
                'old' => isset($data_old[$_key]) ? $data_old[$_key] : '"Не установлено"',
                'new' => $data_new[$_key],
            );
        }

        return $diff_result;
    }

    public function get_datetime()
    {
        $timestamp = strtotime($this->datetime);
        return $timestamp > 0 ? date('h:i d.m.Y ', $timestamp) : null;
    }
}

?>