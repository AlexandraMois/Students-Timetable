<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timetable extends CI_Controller{

	public function index()
	{
		$this->load->model('Timetable_model');
		// var_dump($this->input->post());
		// var_dump($this->input->get());

		if($this->input->post()){
			$data['insertResponse'] = $this->insertTimetable($this->input->post());
		}

		if($this->input->get()){
			$data['timetable'] = $this->Timetable_model->filterTimetable($this->input->get());
		}
		else{
			$data['timetable'] = $this->Timetable_model->getTimetable();
		}

		$this->load->view('menuview');
		$this->load->view('timetableview',$data);

	}

	private function insertTimetable($data)
	{
		$this->load->model('Timetable_model');

		$errorArray = [];
		$response = [];

		$error = false;

		if (($data['year'] > 4) || (preg_match("/^[a-zA-Z ]*$/",$data['year']))) {
			$errorArray[] = "Anul trebuie sa fie cuprins intre 1 si 4.";
			$error = true;
		}

		if (($data['group_number'] > 6) || (preg_match("/^[a-zA-Z ]*$/",$data['group_number']))){
			$errorArray[] = "Grupa trebuie sa fie cuprinsa intre 1 si 6.";
			$error = true;
		}

		if((strlen($data['school_discipline']) < 3 || strlen($data['school_discipline']) > 64) || (!preg_match("/^[a-zA-Z ]*$/",$data['school_discipline']))) {
			$errorArray[] = "Disciplina trebuie sa fie de min 3-max 64 caractere.";
			$error = true;
		}

		if (($data['day_of_week'] > 5) || (preg_match("/^[a-zA-Z ]*$/",$data['day_of_week']))) {
			$errorArray[] = "Ziua trebuie sa fie cuprins intre 1 si 5.";
			$error = true;
		}

		if (!strtotime($data['start'])) {
			$errorArray[] = "Ora de incepere trebuie sa aiba formatul HH:MM:SS.";
			$error = true;
		}

		if (!strtotime($data['stop'])) {
			$errorArray[] = "Ora de sfarsit trebuie sa aiba formatul HH:MM:SS.";
			$error = true;
		}

		if(strlen($data['classroom']) > 4 || strlen($data['classroom']) < 1 ) {
			$errorArray[] = "Sala trebuie sa fie de max 4 caractere.";
			$error = true;
		}

		if($error==true){
			$errorArray[] = "Nu sunt indeplinite conditiile.";
			$response['status'] = 'errors';
			$response['errors'] = $errorArray;
		}
		else{
			$result = $this->Timetable_model->insertTimetable($data);

			if($result > 0){
				$response['status'] = 'success';
			}

		}
		return $response;

	}

}