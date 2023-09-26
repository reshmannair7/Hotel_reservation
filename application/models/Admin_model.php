<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    public function getHashedPassword($email) {
        $this->db->select('password');
        $this->db->where('email', $email);
        $this->db->where('is_admin', 1);
        $query = $this->db->get('registration');

        if ($query->num_rows() == 1) {
            $admin = $query->row();
            return $admin->password; 
        }

        return false; // User not found
    }
    public function getuserPassword($email) {
        $this->db->select('password');
        $this->db->where('email', $email);
        $this->db->where('is_admin', 0);
        $query = $this->db->get('registration');

        if ($query->num_rows() == 1) {
            $admin = $query->row();
            return $admin->password; 
        }

        return false; // User not found
    }
    public function check_room_type($type)
    {
        $this->db->select('room_type');
        $this->db->where('room_type', $type);
        $query = $this->db->get('room_type');
        return $query->result();
    }
    public function insert_room_type($data)
    {
        
        $this->db->insert("room_type",$data);
        return $this->db->affected_rows() > 0;
    }
     public function getMaster_roomType() {
        $query = $this->db->get('room_type'); 
        return $query->result();
    }
    public function getRoomtData($type_id) {
        $this->db->where('id', $type_id);
        $query = $this->db->get('room_type');

        return $query->row_array();
    }
    // application/models/StudentModel.php

    public function updateRoomMaster($room_id, $room_type) {
        $data = array(
            'room_type' => $room_type,
        );
        $this->db->where('id', $room_id);
        $this->db->update('room_type', $data);

        return $this->db->affected_rows() > 0;
    }
    public function deleteRoomtype($type_id) {
        $this->db->where('id', $type_id);
        $this->db->delete('room_type');

        return $this->db->affected_rows() > 0;
    }
      public function check_floor_type($type)
    {
        $this->db->select('floor');
        $this->db->where('floor', $type);
        $query = $this->db->get('floor');
        return $query->result();
    }
    public function insert_floor_type($data)
    {
        
        $this->db->insert("floor",$data);
        return $this->db->affected_rows() > 0;
    }
     public function getMaster_floorType() {
        $query = $this->db->get('floor'); 
        return $query->result();
    }
     public function getFloorData($type_id) {
        $this->db->where('id', $type_id);
        $query = $this->db->get('floor');

        return $query->row_array();
    }
    public function updateFloorMaster($floor_id, $floor) {
        $data = array(
            'floor' => $floor,
        );
        $this->db->where('id', $floor_id);
        $this->db->update('floor', $data);

        return $this->db->affected_rows() > 0;
    }
    public function deleteFloortype($type_id) {
        $this->db->where('id', $type_id);
        $this->db->delete('floor');

        return $this->db->affected_rows() > 0;
    }
    public function select_all_roomType()
    {
        
        $query = $this->db->get('room_type');
        return $query->result();
    }
     public function select_all_floorType()
    {
        
        $query = $this->db->get('floor');
        return $query->result();
    }
   public function insert_room($data)
    {
        
        $this->db->insert("room",$data);
        return $this->db->affected_rows() > 0;
    }
    public function insert_room_image($datas)
    {
        
        $this->db->insert("room_image",$datas);
        $inserted_id = $this->db->insert_id();
        return $inserted_id;
    }
    public function select_all_rooms()
    {
       
        $this->db->select('room.*,room_type.room_type,floor.floor'); //
        $this->db->from('room');
        $this->db->join('room_type', 'room_type.id = room.room_type_id');
         $this->db->join('floor', 'floor.id = room.floor_id');
        $query = $this->db->get();
        return $query->result();
    }
     public function select_all_image()
    {

        $query = $this->db->get('room_image');
        return $query->result();
    }
      public function deleteRooms($type_id) {
        $this->db->where('id', $type_id);
        $this->db->delete('room');
        return $this->db->affected_rows() > 0;
    }
    public function deleteRoomimage($type_id) {
        $this->db->where('id', $type_id);
        $this->db->delete('room');
        return $this->db->affected_rows() > 0;
    }
      public function selectRoomsImages($type_id) {
        $this->db->where('room_id', $type_id);
         $query = $this->db->get('room_image');
        return $query->result();
    }
    public function check_email_type($type)
    {
        $this->db->select('email');
        $this->db->where('email', $type);
        $query = $this->db->get('registration');
        return $query->result();
    }
    public function insert_user_type($data)
    {
        
        $this->db->insert("registration",$data);
        return $this->db->affected_rows() > 0;
    }
    public function user_details($user)
    {
        $this->db->where('email', $user);
        $query = $this->db->get('registration');
        return $query->result();

    }
     public function select_rooms_number($room_type_id,$floor_id)
    {
       $this->db->where('room_type_id', $room_type_id);
       $this->db->where('floor_id', $floor_id);
        $query = $this->db->get('room');
        return $query->result();
    }
  


   
   /* public function insert_admin($email,$password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $is_admin = 1;
        $date = date('Y-m-d');
        $data = array(
            'email' => $email,
            'password' => $hashed_password,
            'is_admin' => $is_admin,
            'created_at'=>$date
        );
         $this->db->insert('registration', $data);
    }*/
}
?>
