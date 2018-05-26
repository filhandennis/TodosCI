<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// use Pug\Pug;
class Task extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		//Load Pug Template Engine Library
		$this->load->library('pug');
		//Load Models
		$this->load->model('mTask','task');
	}

	public function index()
	{
		$this->pug->view('task/home');
	}

	public function add(){
		$this->load->vars(['title'=>'Create A Task']);
		$this->pug->view('task/add');
	}

	public function edit($id){
		$this->load->vars([
			'title'=>'Edit Task '.$id,
			'edit'=>[
				'id'=>$id,
				'data'=> $this->task->getById($id)
			]
		]);

		$this->pug->view('task/add');
	}

	public function view($id){
		// echo $this->;
	}

	/*
	 * REST
	 */
	public function getById($id){
		$q = $this->task->getById($id);
		$row = $q!=null?$q:"NOT EXIST";
		header('Content-Type: application/json');
		echo json_encode(["data"=>$row]);
	}

	public function all(){
		header('Content-Type: application/json');
		$q = $this->task->selectAll();
		echo json_encode($q);
	}
	
	public function store(){
		// $data = json_decode(file_get_contents("php://input"),true);
		$prefix = "task";
		$data = [
			'name'=>$_POST[$prefix.'Name'],
			'priority'=>$_POST[$prefix.'Priority'],
			'color'=>$_POST[$prefix.'Color'],
			'timeset'=>$_POST[$prefix.'Timeset'],
			'status'=>$_POST[$prefix.'Status']
		];
		// var_dump($data);

		header('Content-Type: application/json');
		$stats = $this->task->create($data)?"INSERT_SUCCESS":"INSERT_FAIL";
		echo json_encode(["status"=>$stats, 'id'=>$this->db->insert_id()]);
		// echo "storing";
	}

	public function update(){
		$prefix = "task";
		$data = [
			'name'=>$_POST[$prefix.'Name'],
			'priority'=>$_POST[$prefix.'Priority'],
			'color'=>$_POST[$prefix.'Color'],
			'timeset'=>$_POST[$prefix.'Timeset'],
			'status'=>$_POST[$prefix.'Status']
		];
		$id = $_POST[$prefix.'Id'];
		header('Content-Type: application/json');
		$stats = $this->task->update(['id'=>$id], $data)==1?"UPDATE_SUCCESS":"UPDATE_FAIL";
		echo json_encode(["status"=>$stats, 'id'=>$id]);
	}

	public function delete($id){
		$q = $this->task->delete($id);
		$stats = $q!=null?"DELETE_SUCCESS":"DELETE_FAIL";
		header('Content-Type: application/json');
		echo json_encode(["status"=>$stats, "id"=>$id]);
	}

	public function updateStatus($id){

	}
}