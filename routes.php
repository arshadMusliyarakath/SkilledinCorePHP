<?php

include('MyController.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['action'])){

    date_default_timezone_set('Asia/Kolkata');
    $today =  date('Y-m-d');

    if($_GET['action'] == 'addNewProject'){
        $data = [
            'project_name' => $_POST['projectName'],
            'created_at' => $today
        ];

        $project = $model->create('projects', $data);
        header('Location:Projects/projects.php');
    }   

    if($_GET['action'] == 'deleteProject'){
        $data = ['project_id' => base64_decode($_GET['id'])];
        $model->delete('projects', $data);
        $model->delete('tasks', $data);
        header('Location:Projects/projects.php');
    }
    
    if($_GET['action'] == 'updateProject'){

        $setData = ['project_name' => $_POST['projectName']];
        $whereData = ['project_id' => $_POST['project_id']];

        $project = $model->update('projects', $setData, $whereData);
        header('Location:Projects/projects.php');
    } 
    
    if($_GET['action'] == 'changeProjectStatus'){

        $project_id = $_POST['project_id'];
        $whereData = [ 'project_id' => $project_id];
        $selectData = ['status'];
        $project = $model->findSelect('projects',$selectData, $whereData);

        $currentStatus = $project[0]['status'];
        $setData = ['status' => ($currentStatus == 1) ? 0 : 1 ];
        $whereData = ['project_id' => $project_id];
        echo $model->update('projects', $setData, $whereData);
    }
    
    //TASK

    if($_GET['action'] == 'addTaskProject'){
        $data = [
            'task_name' => $_POST['taskName'],
            'project_id' => $_POST['projects'],
            'created_at' => $today
        ];

        $tasks = $model->create('tasks', $data);
        header('Location:Tasks/tasks.php');
    }
    
    if($_GET['action'] == 'deleteTask'){
        $data = ['task_id' => base64_decode($_GET['id'])];
        $tasks = $model->delete('tasks', $data);
        header('Location:Tasks/tasks.php');
    }

    if($_GET['action'] == 'changeTaskStatus'){

        $task_id = $_POST['task_id'];
        $whereData = [ 'task_id' => $task_id];
        $selectData = ['status'];
        $task = $model->findSelect('tasks',$selectData, $whereData);

        $currentStatus = $task[0]['status'];
        $setData = ['status' => ($currentStatus == 1) ? 0 : 1 ];
        $whereData = ['task_id' => $task_id];
        echo $model->update('tasks', $setData, $whereData);

    }
    
    if($_GET['action'] == 'updateTask'){

        $setData = ['task_name' => $_POST['taskName'], 'project_id' => $_POST['projects']];
        $whereData = ['task_id' => $_POST['task_id']];

        $tasks = $model->update('tasks', $setData, $whereData);
        header('Location:Tasks/tasks.php');
    } 

    if($_GET['action'] == 'getActiveTasksOptions'){
        $tasks = $model->find('tasks', array('status' => '1', 'project_id' => $_POST['project_id']));
        $option = '<option value="">Select Task</option>';
        foreach ($tasks as $key => $value) {
            $option = $option."<option value='".$value['task_id']."'>".$value['task_name']."</option>";
        }
        echo $option;
    } 

    //ENTRY

    if($_GET['action'] == 'addEntry'){
        $data = [
            'project_id' => $_POST['project'],
            'task_id' => $_POST['task'],
            'hours' => $_POST['hour'],
            'date' => $_POST['date'],
            'description' => $_POST['description'],
            'created_at' => $today
        ];

        $entry = $model->create('entry', $data);
        header('Location:Home/home.php');
    }


    if($_GET['action'] == 'search'){
       
    } 
    
}
?>