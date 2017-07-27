<?php

class Timetable_model extends CI_Model {

	public function getTimetable() {

		$query = $this->db->order_by('year asc , day_of_week asc')->get('timetable');
		return $query->result_array();
	}

	public function insertTimetable($data){

		$this->db->insert('timetable', $data);
		$result=$this->db->affected_rows();
		return $result;

	}

	public function filterTimetable($data){
		if($data['year']){
			$this->db->where('year', $data['year']);
		}
		if($data['group_number']){
			$this->db->where('group_number', $data['group_number']);
		}
		if($data['day_of_week']){
			$this->db->where('day_of_week', $data['day_of_week']);
		}

		$query = $this->db->order_by('year asc , day_of_week asc')->get('timetable');
		return $query->result_array();
	}

}