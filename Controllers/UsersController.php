<?php 
class UsersController{
    protected $model = '';

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $users = $this->model->getAllUsers();
        echo(json_encode($users));
    }

    public function show($id)
    {
        $user = $this->model->getUserById($id);
        echo(json_encode($user));
    }

    public function create()
    {
        if ($_POST) {
            $this->model->insert();
            echo('Inserted Successfully !');
        }
    }

    public function edit($id)
    {
        if ($_POST) {
            $this->model->update($id);
            echo('Updated Successfully !');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $this->model->delete($id);
            echo('Deleted Successfully !');
        }
    }
}