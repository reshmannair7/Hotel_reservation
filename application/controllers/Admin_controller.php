<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_controller extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
         $this->load->library('session');
        $this->load->model('Admin_model');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url'));
    }
    public function index() {
        // Load the login view
        /*$email = "admin@gmail.com";
        $password = "Admin@123";
         $this->Admin_model->insert_admin($email, $password);*/
        $this->load->view('admin/admin_login');
    }
    public function dashboard() {
        // Load the login view
        $data['records'] = $this->Admin_model->getMaster_roomType();
        $data['content'] = $this->load->view('admin/room_master_list', $data, true);
        $this->load->view('admin/admin_dashboard', $data);
    }
    public function room_master_list($content) {
    	$data['records'] = $this->Admin_model->getMaster_roomType();
	    $data['content'] = $this->load->view('admin/'.$content, $data, true);
	    echo $data['content'];
	}
	public function floor_master_list($content) {
		$data['records'] = $this->Admin_model->getMaster_floorType();
	    $data['content'] = $this->load->view('admin/'.$content, $data, true);
	    echo $data['content'];
	}
	public function room_list($content) {
		$data['types'] = $this->Admin_model->select_all_roomType();
		$data['floors'] = $this->Admin_model->select_all_floorType();
		$data['room'] = $this->Admin_model->select_all_rooms();
		$data['images'] = $this->Admin_model->select_all_image();
	    $data['content'] = $this->load->view('admin/'.$content, $data, true);
	    echo $data['content'];
	}
	public function user_reservation($content) {
	    $data['content'] = $this->load->view('admin/'.$content, '', true);
	    echo $data['content'];
	}

    public function process_login() {
        // Handle login form submission and validation
        
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload the login view
            $this->load->view('admin/admin_login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $hashed_password_from_db = $this->Admin_model->getHashedPassword($email);
             $user_password_from_db = $this->Admin_model->getuserPassword($email);
            $this->load->model('Admin_model'); 
			if ($hashed_password_from_db !== false && password_verify($password, $hashed_password_from_db)) {
			    // Successful login, set session and redirect to admin dashboard
                $data = array('username' => $email);
                $this->session->set_userdata($data);
                redirect('Admin_controller/dashboard');
			}
			elseif ($user_password_from_db !== false && password_verify($password, $user_password_from_db))
			{
				 $data = array('username' => $email);
                $this->session->set_userdata($data);
                redirect('Admin_controller/user_dashboard',$data);
			}
             else {
                // Invalid login, show error message
                $data['error_message'] = 'Invalid username or password';
                $this->load->view('admin/admin_login', $data);
            }
        }
    }

    public function logout() {
        // Logout the user and destroy the session
        $this->session->sess_destroy();
        redirect('Admin_controller/index');
    }

    public function add_room_type()
    {
    	
    	if ($this->input->is_ajax_request()) {
    		$this->form_validation->set_rules('room_type', 'Room_type', 'required',
		        array(
		            'required' => 'Enter Room master type.'
		        )
		    );
    		if ($this->form_validation->run() == false) {
	            // Validation failed, return validation errors
	            $errors = validation_errors();
	            echo json_encode(array('success' => false, 'errors' => $errors));
	        } else {
	        	 $type = $this->input->post('room_type');
	             $exist_type = $this->Admin_model->check_room_type($type);
	            if ($exist_type) {
                	 echo json_encode(array('success' => false, 'errors' => "Room type exist already"));
           		 }else
           		 {
           		 	 $data = array(
			            'room_type' => $this->input->post('room_type'),
			            'created_at'=> date('Y-m-d')
			        );

		            $result = $this->Admin_model->insert_room_type($data);
		            if ($result) {
	                	echo json_encode(array('success' => true));
	           		 }
           		 }
	           
	          
	        }
	    }
	   
    }
    public function editRoomtype($type_id) {
        $type_data = $this->Admin_model->getRoomtData($type_id);

        $data['type_data'] = $type_data;

        $this->load->view('admin/update_room_type', $data);
    }
    
	public function updateRoomtype() {

		$room_id = $this->input->post('id');
	    $room_type = $this->input->post('room_type');
	    $updated = $this->Admin_model->updateRoomMaster($room_id, $room_type);

	        redirect('Admin_controller/dashboard');
	    
	}
	public function deleteRoomtype($type_id) {
        $deleted = $this->Admin_model->deleteRoomtype($type_id);

        if ($deleted) {
            redirect('Admin_controller/dashboard');
        } 
    }

    public function add_floor_type()
    {
    	if ($this->input->is_ajax_request()) {
    		$this->form_validation->set_rules('floor', 'Floor', 'required',
		        array(
		            'required' => 'Enter floor master type.'
		        )
		    );
    		if ($this->form_validation->run() == false) {
	            // Validation failed, return validation errors
	            $errors = validation_errors();
	            echo json_encode(array('success' => false, 'errors' => $errors));
	        } else {
	        	 $type = $this->input->post('floor');
	             $exist_type = $this->Admin_model->check_floor_type($type);
	            if ($exist_type) {
                	 echo json_encode(array('success' => false, 'errors' => "Floor exist already"));
           		 }else
           		 {
           		 	 $data = array(
			            'floor' => $this->input->post('floor'),
			            'created_at'=> date('Y-m-d')
			        );

		            $result = $this->Admin_model->insert_floor_type($data);
		            if ($result) {
	                	echo json_encode(array('success' => true));
	           		 }
           		 }
	           
	          
	        }
	    }
	   
    }
    public function editFloortype($type_id) {
        $type_data = $this->Admin_model->getFloorData($type_id);

        $data['type_data'] = $type_data;

        $this->load->view('admin/update_floor_type', $data);
    }
    public function updateFloortype() {

		$floor_id = $this->input->post('id');
	    $floor = $this->input->post('floor');
	    $updated = $this->Admin_model->updateFloorMaster($floor_id, $floor);
	    
	        redirect('Admin_controller/dashboard?triggerClick=floor');
	    
	}
	public function deleteFloortype($type_id) {
        $deleted = $this->Admin_model->deleteFloortype($type_id);

        if ($deleted) {
            redirect('Admin_controller/dashboard?triggerClick=floor');
        } 
    }
    public function addProduct() {
      // Define the upload directory path
        $upload_path = './uploads/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        // Configuration for file upload
        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size']      = 2048; // 2MB maximum file size
        $config['encrypt_name']  = TRUE;
        

        $this->load->library('upload', $config);

        
            // Upload successful, save file info and other data
            $data = $this->upload->data();
            $image_data = array(
                'image' => $data['file_name'],
                'room_type_id' => $this->input->post('room_type_id'),
                'description' => $this->input->post('description')
            );

            // Store image data in the database (you need to create a database table for this)
            // Create a model for database operations
            $this->Admin_model->addProduct($image_data);

            // Redirect to a success page or display a success message
           
        
    }
    function upload()
    {
    	if($_FILES["files"]["name"]!="")
    	{
    		$output = '';
			$config["upload_path"]   = './upload/';
        	$config["allowed_types"] = 'gif|jpg|jpeg|png';
        	$this->load->library('upload', $config);
        	$this->upload->initialize($config);
        	for ($count=0; $count <($_FILES["files"]["name"]) ; $count++) { 
        		$_FILES["file"]["name"]= $_FILES["files"]["name"][$count];
        		$_FILES["file"]["type"]= $_FILES["files"]["type"][$count];
        		$_FILES["file"]["tmp_name"]= $_FILES["files"]["tmp_name"][$count];
        		$_FILES["file"]["error"]= $_FILES["files"]["error"][$count];
        		$_FILES["file"]["size"]= $_FILES["files"]["size"][$count];
        		if ($this->upload->do_upload('file')) {
        			$data = $this->upload->data();
        			$output .= '<div class="col-md-3"><img src="'.base_url().'upload/'.$data["file_name"].'" class=""/> </div>';
        		}
        	}
        	echo $output;
    	}
    }
      public function add_room()
    {
    	
    	if ($this->input->is_ajax_request()) {
    		$this->form_validation->set_rules('room_type_id', 'Room_type_id', 'required',
		        array(
		            'required' => 'Select room master type.'
		        )
		    );
		    $this->form_validation->set_rules('floor_id', 'Floor_id', 'required',
		        array(
		            'required' => 'Select Floor type.'
		        )
		    );
		    $this->form_validation->set_rules('room_number', 'Room number', 'required',
		        array(
		            'required' => 'Enter room numbrer.'
		        )
		    );
    		if ($this->form_validation->run() == false) {
	            // Validation failed, return validation errors
	            $errors = validation_errors();
	            echo json_encode(array('success' => false, 'errors' => $errors));
	        } else {
	        	 $data = array(
			            'room_type_id' => $this->input->post('room_type_id'),'floor_id' => $this->input->post('floor_id'),'room_number' => $this->input->post('room_number'),'description' => $this->input->post('description'),
			            'created_at'=> date('Y-m-d')
			        );

		            $result = $this->Admin_model->insert_room($data);
		            $inserted_id = $this->db->insert_id();
		            
		            if ($result) {

		           $config = array();
				    $config['upload_path'] = './upload/';
				    $config['allowed_types'] = 'gif|jpg|png|jpeg';
				    
				    $config['overwrite']     = FALSE;

				    $this->load->library('upload');
				    $room_type_id=$this->input->post('room_type_id');
				    $files = $_FILES;
				    $count = count($_FILES['userfile']['name']);
				    for($i=0; $i< $count; $i++)
				    {           
				        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
				        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
				        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
				        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
				        $_FILES['userfile']['size']= $files['userfile']['size'][$i];    

				        $this->upload->initialize($config);
				       
				        if (!$this->upload->do_upload('userfile')) {
		            $error = array('error' => $this->upload->display_errors());
		            $this->load->view('upload_form', $error);
		        } else {
				            $uploaded_data = $this->upload->data();
				            $file_path = 'upload/' . $uploaded_data['file_name'];
				           
				                 $datas = array(
					            'room_id' => $inserted_id,'image' =>  $file_path
					        );
				                  $result = $this->Admin_model->insert_room_image($datas); 
				  
				        }
				    }
					        	 
	                	echo json_encode(array('success' => true));
	           		 }

	        }
	    }
	   
    }
    
 public function deleterooms($type_id) {
        $deleted = $this->Admin_model->deleteRooms($type_id);
         $image_file = $this->Admin_model->selectRoomsimages($type_id);
         if (!empty($image_file)) {
		        // Iterate through the image file names and delete each one
		        foreach ($image_file as $file_name) {
		            $file_path = 'uploads/' .$file_name;
		            if (file_exists($file_path)) {
		                unlink($file_path); // Delete the image file
		            }
		        }
		         $this->Admin_model->deleteRoomimage($type_id);
           
        }
        if ($deleted) { 
         redirect('Admin_controller/dashboard?triggerClick=room');
    }
}
 public function registration()
    {
    	if ($this->input->is_ajax_request()) {
    		$this->form_validation->set_rules('name', 'name', 'required',
		        array(
		            'required' => 'Enter name.'
		        )
		    );
		    $this->form_validation->set_rules('email', 'Email', 'required',
		        array(
		            'required' => 'Enter email.'
		        )
		    );
		    $this->form_validation->set_rules('password', 'Password', 'required',
		        array(
		            'required' => 'Enter password.'
		        )
		    );
		    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]',
		        array(
		            'required' => 'Enter confirm password.'
		        )
		    );
    		if ($this->form_validation->run() == false) {
	            // Validation failed, return validation errors
	            $errors = validation_errors();
	            echo json_encode(array('success' => false, 'errors' => $errors));
	        } else {
	        	 $name = $this->input->post('name');
	        	 $email = $this->input->post('email');
	        	 $password = $this->input->post('password');
	        	 $confirm_password = $this->input->post('confirm_password');
	        	 $phone_number = $this->input->post('phone_number');
	        	 $phone_number = $this->input->post('phone_number');
	        	 $country = $this->input->post('country');
	        	 $state = $this->input->post('state');
	        	 $city = $this->input->post('city');
	        	 $pincode = $this->input->post('pincode');
	        	 $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
     
	             $exist_type = $this->Admin_model->check_email_type($email);
	            if ($exist_type) {
                	 echo json_encode(array('success' => false, 'errors' => "Email exist already"));
           		 }else
           		 {
           		 	 $data = array(
			            'name' => $this->input->post('name'),'email' => $this->input->post('email'),'phone_number' => $this->input->post('phone_number'),'password' => $hashed_password,'is_admin'=>0,'country' => $this->input->post('country'),'state' => $this->input->post('state'),'city' => $this->input->post('city'),'pincode' => $this->input->post('pincode'),'gender' => $this->input->post('gender'),'address_line1' => $this->input->post('address_line1'),'address_line2' => $this->input->post('address_line2'),
			            'created_at'=> date('Y-m-d')
			        );

		            $result = $this->Admin_model->insert_user_type($data);
		            if ($result) {
		            	 $data = array('username' => $email);
               			 $this->session->set_userdata($data);
	                	echo json_encode(array('success' => true));
	                	redirect('Admin_controller/user_dashboard');
	           		 }
           		 }
	           
	          
	        }
	    }
	   
    }


 public function user_dashboard()
 {
 	$user = $this->session->userdata('username');
 	$data['records'] = $this->Admin_model->user_details($user);
 	$data['rooms'] = $this->Admin_model->select_all_rooms();
 	$data['types'] = $this->Admin_model->select_all_roomType();
	$data['floors'] = $this->Admin_model->select_all_floorType();
	$data['images'] = $this->Admin_model->select_all_image();
 	$this->load->view('admin/user_dashboard',$data);
 }


  
 public function AllfetchData()
 {
 	$room_type_id = $this->input->post('room_type_id');
    $floor_id = $this->input->post('floor_id');
    $result = $this->Admin_model->select_rooms_number($room_type_id,$floor_id);
     echo json_encode(['result' => $result]);
 }
}

?>
