<?php  

defined('BASEPATH') OR exit('No direct script access allowed');
use Gregwar\Image\Image;

class Students extends CI_Controller {

	public function index()
	{
		$this->load->view('menuview');

		$this->load->model('Students_model');

		$studentId = $this->input->post('upload');
		if($studentId){
			$data['students'] = $this->imageUpload($studentId);
		}

		$studentId = $this->input->post('delete');
		if($studentId){
			$data['deleteResponse'] = $this->Students_model->deleteStudent($studentId);
		}

		// var_dump($this->input->post());die;
		if (count($this->input->post())>0 && !$this->input->post('delete')&& !$this->input->post('upload')) {
		// if (count($this->input->post('insert'))>0) {
			$dataInsert = $this->input->post();
			// var_dump($imageInsert);die;
			$data['insertResponse'] = $this->insertStudent($dataInsert);
		}

		

		$searchName = $this->input->get('name');
		// var_dump($searchName);
		if($searchName){
			$data['students'] = $this->Students_model->searchStudent($searchName);
		}
		else{
			$data['students'] = $this->Students_model->getStudents();
		}

		
		$this->load->view('studentsformview', $data);

	}

	private function insertStudent($data){

		$this->load->model('Students_model');

		// var_dump($last_id);

		$errorArray = [];
		$response = [];

		$error = false;
		// $this->load->library('Form_validation');

		if((strlen($data['name']) < 3 || strlen($data['name']) > 64) || (!preg_match("/^[a-zA-Z ]*$/",$data['name']))) {
			$errorArray[] = "Numele trebuie sa fie de min 3-max 64 caractere.";
			$error = true;
		}

		// $this->Form_validation->set_rules('name', 'Nume', 'required|min_lenght[3]|max_lenght[64]');

		if(!isset($_FILES['avatar']['tmp_name'])){
			$errorArray[] = "Imaginea de profil trebuie introdusa.";
			$error = true;
		}
		// else{
		// 	$data['avatar']= $this->imageUpload($data['id']);
		// }

		if (($data['year'] > 4) || (preg_match("/^[a-zA-Z ]*$/",$data['year']))) {
			$errorArray[] = "Anul trebuie sa fie cuprins intre 1 si 4.";
			$error = true;
		}

		// $this->Form_validation->set_rules('year', 'Anul', 'required|max_lenght[4]|numeric');

		if (($data['group_number'] > 6) || (preg_match("/^[a-zA-Z ]*$/",$data['group_number']))){
			$errorArray[] = "Grupa trebuie sa fie cuprinsa intre 1 si 6.";
			$error = true;
		}

		// $this->Form_validation->set_rules('group_number', 'Grupa', 'required|max_lenght[6]|numeric');

		if((strlen($data['section']) < 2 || strlen($data['section']) > 64) || (!preg_match("/^[a-zA-Z ]*$/",$data['section']))) {
			$errorArray[] = "Specializarea trebuie sa fie de min 3-max 64 caractere.";
			$error = true;
		}

		// $this->Form_validation->set_rules('section', 'Specializarea', 'required|min_lenght[2]|max_lenght[64]');

		if(!isset($_POST['pedagogy_courses'])){
		 	$errorArray[] = "Trebuie specificata participarea la cursul pedagogic";
			$error = true;
		}
		
		if($error==true){
			$errorArray[] = "Nu sunt indeplinite conditiile.";
			$response['status'] = 'errors';
			$response['errors'] = $errorArray;
		}
		else{
			$result = $this->Students_model->insertStudent($data);
			// var_dump($result);
			$this->imageUpload($result);

			if($result > 0){
				$response['status'] = 'success';
			}
			// else{
			// 	$errorArray[] = "Problema la inserare.";
			// }
			

		}
		return $response;

	}


	public function update()
	{
		$this->load->model('Students_model');

		$id = $this->input->post('studentId');
		$name = $this->input->post('name');
		// $avatar = $this->input->post('upload');
		// $thumbnail = 
		$year = $this->input->post('year');
		$group_number = $this->input->post('group_number');
		$section = $this->input->post('section');
		$pedagogy_courses = $this->input->post('pedagogy_courses');
		
		$errorArray = [];

		$response = [];

		// $this->load->library('Form_validation');

		if($id!=NULL or $name!=NULL or $year!=NULL or $group_number!=NULL or $section!=NULL or $pedagogy_courses!=NULL){
			$error = false;

			if((strlen($name) < 3 || strlen($name) > 64) || (!preg_match("/^[a-zA-Z ]*$/",$name))) {
				$errorArray[] = "Numele trebuie sa fie de min 3-max 64 caractere.";
				$error = true;
			}

			// $this->Form_validation->set_rules('name', 'Nume', 'required|min_lenght[3]|max_lenght[64]');

	
			if (($year > 4) || (preg_match("/^[a-zA-Z ]*$/",$year))) {
				$errorArray[] = "Anul trebuie sa fie cuprins intre 1 si 4.";
				$error = true;
			}

			// $this->Form_validation->set_rules('year', 'Anul', 'required|max_lenght[4]|numeric');

			if (($group_number > 6) || (preg_match("/^[a-zA-Z ]*$/",$group_number))){
				$errorArray[] = "Grupa trebuie sa fie cuprinsa intre 1 si 6.";
				$error = true;
			}

			// $this->Form_validation->set_rules('group_number', 'Grupa', 'required|max_lenght[6]|numeric');

			if((strlen($section) < 2 || strlen($section) > 64) || (!preg_match("/^[a-zA-Z ]*$/",$section))) {
				$errorArray[] = "Specializarea trebuie sa fie de min 3-max 64 caractere.";
				$error = true;
			}

			// $this->Form_validation->set_rules('section', 'Specializarea', 'required|min_lenght[2]|max_lenght[64]');

			if(!isset($_POST['pedagogy_courses'])){
			 	$errorArray[] = "Trebuie specificata participarea la cursul pedagogic";
				$error = true;
			}
			
			if($error==true){
				$errorArray[] = "Nu sunt indeplinite conditiile.";
				$response['status'] = 'errors';
				$response['errors'] = $errorArray;
				echo json_encode($response);
				return;
			}

			else{
				$result = $this->Students_model->updateStudent($id, $name, $year, $group_number, $section, $pedagogy_courses);
				
				if($result > 0){
					$response['status'] = 'success';
					echo json_encode($response);
					return;
				}
				else{
					$errorArray[] = "Nu ati facut nicio modificare.";
					$response['status'] = 'errors';
					$response['errors'] = $errorArray;
					echo json_encode($response);
					return;
				}
			}

		}
		
	}	

	public function imageUpload($studentId){
		$data['uploadImage'] = $this->Students_model->getStudent($studentId);
		// var_dump($data['uploadImage']['0']['id']);die;
		$id = $data['uploadImage']['0']['id'];
		// $completeName = $data['uploadImage']['0']['name'];
		// $completeNameLine = str_replace(" ", "-", $completeName);
		// $newImageName = $id . "-" . $completeNameLine;
		if (isset($_FILES['avatar']['tmp_name'])) {
			$uploadPath = 'uploads\\'. $id . '.jpg';
			move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath);
			$result = $this->Students_model->imageUpload($id, $uploadPath);
		}
		return $result;
	}

}
