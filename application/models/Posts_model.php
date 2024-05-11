<?php


class Posts_model extends CI_Model
{

  // ------------------------------------------------------------------------

  //dito ilalagay yung query kapag may default ka na iloload sa class 
  public function __construct()
  {
    // to run our database ; 
    $this->load->database();
    
  }


  // get all the posts 
  public function get_posts()
  { 
  
 
    // stored procedure query 
    // $query =  $this->db->query("CALL get_all_blogs()"); 
    // return $query->result(); 

    //not stored procedure query 
     $query = $this->db->get('blogs');
     return $query->result_array();
     

  }

  public function count_all_records(){ 
    return $this->db->count_all('blogs');
  }
  //finding and posting a single post 
  public function get_posts_single($slug)
  {

    // $this->db->select('*');
    // $this->db->from('blogs'); // Replace 'your_table_name' with the actual table name
    // $this->db->where('id', 1);
    // $query = $this->db->get();


    //  $this->db->where('id',$id); 
    // $result = $this->db->get('blogs'); 

    // return  $query->row_array(); 

    $this->db->where('slug', $slug);
    $result = $this->db->get('blogs');

    return  $result->row_array();
  }

  // insert posts to model 
  public function insert_post($image)
  {


    //receiving the value from the form
    $data = array(
      'title' => $this->input->post('title'),
      'slug' => url_title($this->input->post('title'), '-', true),
      'body' => $this->input->post('body'),
      'image'=>$image
    );

    return $this->db->insert('blogs', $data);
  }


  //finding and edit a single post 
  public function get_posts_edit($id)
  {

    $this->db->where('id', $id);
    $result = $this->db->get('blogs');

    return  $result->row_array();
  }

  // update posts to model 
  public function update_post()
  {

    //receiving the value from the form
    $id  = $this->input->post('id');
    $data = array(
      'title' => $this->input->post('title'),
      'slug' => url_title($this->input->post('title'), '-', true),
      'body' => $this->input->post('body'),

    );

    $this->db->where('id', $id);
    return $this->db->update('blogs', $data);
  }


  public function delete_post()
  {
    //receiving the value from the form 
    $id =  $this->input->post('id');
    $this->db->where('id', $id);
    $this->db->delete('blogs');
  }


  public function login()
  {
    // mysqli_real_escape_string to prevent sql injection
    $this->db->where('username', $this->input->post('username', true));
    $this->db->where('password', $this->input->post('password', true));
    $result  =  $this->db->get('user');


    if ($result->num_rows() == 1) {
      return $result->row_array();
    } else {
      return false;
    }
  }

  public function get_post_search($param)
  {

 
//stored procedurized query. 
$query = $this->db->query("CALL search_posts('" . $param . "')");
return $query->result(); 
 
  //not store procedurized query  . 
  // $this->db->like('title', $param);
  // $result = $this->db->get('blogs');
  // return  $result->result_array();
  }
}

/* End of file Posts_model.php */
/* Location: ./application/models/Posts_model.php */