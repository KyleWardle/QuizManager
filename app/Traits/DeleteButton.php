<?php namespace App\Traits;

trait DeleteButton
{
    public function render_delete_button($delete_route, $field_name = 'name', $password_confirm = false)
    {
        $model_id = $this->id;
        $model = "App\\".class_basename($this);
        $delete_url = route($delete_route, $this);
        return view('layouts.delete_button', compact('delete_url', 'field_name', 'password_confirm', 'model_id', 'model'));
    }
}