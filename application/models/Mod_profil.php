<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_profil extends CI_Model
{

	function updateProfil($id, $data)
	{
		$this->db->where('user_id', $id);
		$this->db->update('wp_user', $data);

		return  $this->db->affected_rows();
	}
}
