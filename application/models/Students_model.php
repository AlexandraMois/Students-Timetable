<?php 


use Gregwar\Image\Image;

class Students_model extends CI_Model {

	public function getStudents() {
		$query = $this->db->get('users');
		return $query->result_array();
	}

	public function getStudent($studentId){
		$query = $this->db->where('id',$studentId)->get('users');
		return $query->result_array();
	}

	public function insertStudent($data){
		
		$this->db->insert('users', $data);
		$last_id=$this->db->insert_id();
		$result=$this->db->affected_rows();
		return $last_id;
	}

	public function updateStudent($id, $name, $year, $group_number, $section, $pedagogy_courses) {
		$this->db->where('id',$id);
		$data= array(
			'id'=> $id,
			'name'=> $name,
			'year'=> $year,
			'group_number' => $group_number,
			'section' => $section,
			'pedagogy_courses' =>$pedagogy_courses
		);
		$this->db->update('users',$data);

		$result=$this->db->affected_rows();
		return $result;
	}

	public function deleteStudent($studentId){
		$this->db->where('id',$studentId);
		$this->db->delete('users');

		$result=$this->db->affected_rows();
		return $result;
	}

	public function searchStudent($searchName){
        $query = $this->db->like('name',$searchName)->get('users');
        return $query->result_array();
	}

	public function imageUpload($id, $uploadPath){
		$this->db->set('avatar', $uploadPath);
		$this->db->set('thumbnail', $this->resize_image_Gregwar($uploadPath));
		$this->db->where('id',$id);
		$this->db->update('users');

		$result=$this->db->affected_rows();
		return $result;
	}

	public function resize_image( $uploadPath, $w, $h) {
	    list($width, $height) = getimagesize($uploadPath);
	    $r = $width / $height;
	    // , $crop=FALSE
	    // if ($crop) {
	    //     if ($width > $height) {
	    //         $width = ceil($width-($width*abs($r-$w/$h)));
	    //     } else {
	    //         $height = ceil($height-($height*abs($r-$w/$h)));
	    //     }
	    //     $newwidth = $w;
	    //     $newheight = $h;
	    // } else {
	        if ($w/$h > $r) {
	            $newwidth = $h*$r;
	            $newheight = $h;
	        } else {
	            $newheight = $w/$r;
	            $newwidth = $w;
	        }
	    // }
	    $src = imagecreatefromjpeg($uploadPath);
	    $dst = imagecreatetruecolor($newwidth, $newheight);
	    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);


		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	    	$destPath = 'thumbnails\\' . basename($uploadPath, '.jpg') . '-thumbnail.jpg';
	    }else{
	    	$destPath = 'thumbnails/' . basename($uploadPath, '.jpg') . '-thumbnail.jpg';
	    }
	    $output = imagejpeg($dst, $destPath, 100);

	    return $destPath;
	}

	public function resize_image_Gregwar($uploadPath) {
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	    	$destPath = 'thumbnails\\' . basename($uploadPath, '.jpg') . '-thumbnail.jpg';
	    }else{
	    	$destPath = 'thumbnails/' . basename($uploadPath, '.jpg') . '-thumbnail.jpg';
	    }

	    Image::open($uploadPath)
	     ->cropResize(100, 100)
	     ->save($destPath);

	    // $output = imagejpeg($dst, $destPath, 100);

	    return $destPath;
	}


}

