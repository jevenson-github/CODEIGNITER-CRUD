<?php


class Pages extends CI_Controller
{
     
    // now this is our custom index contoller in web 
    public function view($id = null)
    {
      
   

        //showing of pages and data's 
        if ($id == null) {
           
            $page = 'home';
            //type of pages or filename of the page 
          
            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) { 
                // show the error 
                show_404();
            }
            
            $data['title'] = 'New Post';
            $data['posts'] = $this->Posts_model->get_posts();
            $data['total'] = count($data['posts']);

            // this will load  , include or  structured the template in our views . 
            // para syang pinapalaman 
            $this->load->view('templates/header');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
        } else {


                
            $page = 'single';
            
            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            
            $data['posts'] = $this->Posts_model->get_posts_single($id);

            //if data is set or equal to id that has a value 
            if ($data['posts']) {
                
                $data['title'] = $data['posts']['title'];
                $data['body'] = $data['posts']['body'];

                $data['date_posted'] = $data['posts']['date_published'];
                $data['date'] = date_create($data['date_posted']);
                $data['id'] = $data['posts']['id'];
                // print_r($data['posts']); 

                // this will load  , include or  structured the template in our views . 
                // para syang pinapalaman 
                $this->load->view('templates/header');
                $this->load->view('pages/' . $page, $data);
                $this->load->view('templates/footer');
            } else {
                show_404();
            }
        }
    }

    //adding page or posts 
    public function add()
    {
           

        
        $page = 'add';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');  // for css 
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');


        //load the template 

        //file upload 
        $config= [
            'upload_path' => './uploads/',
            'allowed_types' =>  'jpeg|jpg|png', 
            'encrypt_name'=>TRUE
        ]; 
        $this->load->library('upload',$config); 

        //error is present 
        if ($this->form_validation->run() == FALSE ||  !$this->upload->do_upload('post_image')) {
            // if the papge is not existing 
            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            } 

            //showing of pages and data's 
            $data['title'] = 'Add Post';
            $data['img_error'] = $this->upload->display_errors('<p>','</p>');
            // this will load  , include or  structured the template in our views . 
            // para syang pinapalaman 
            $this->load->view('templates/header');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
        }
        //success input | and for the image. 
         else { 

           $img =  $this->upload->data(); 
            $image = $img['file_name']; 
            $this->Posts_model->insert_post($image);
            $this->session->set_flashdata('post_added', 'Post succesfuly added ');
            redirect(base_url());
        }
    }


    // edit function 
    public function edit($id)
    {

        $page = 'edit';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');  // for css 
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('body', 'Body', 'required');


        //load the template 
        if ($this->form_validation->run() == FALSE) {
            //showing of pages and data's 
            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

            $data['title'] = 'Edit Post';
            $data['posts'] = $this->Posts_model->get_posts_edit($id);
            //if data is set or equal to id that has a value
            $data['title'] = $data['posts']['title'];
            $data['body'] = $data['posts']['body'];
            $data['id'] = $data['posts']['id'];

            // this will load  , include or  structured the template in our views . 
            // para syang pinapalaman 
            $this->load->view('templates/header');
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
        } else {
            $this->Posts_model->update_post();
            $this->session->set_flashdata('post_update', 'Post succesfuly updated ');
            redirect(base_url() . 'edit/' . $id);
        }
    }

    // delete function 
    public function delete()
    {
        $this->Posts_model->delete_post();
        $this->session->set_flashdata('post_deleted', 'Post succesfuly deleted ');
        redirect(base_url());
    }

    //login function 
    public function login()
    {

        $page = 'login'; 

        // with validation 
        //  $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');  // for css 
        $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[20]');


        //this is for password confirmation
        // $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[20]'); 
        // $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]|min_length[8]|max_length[20]');


        //load the template 
        if ($this->form_validation->run() == FALSE) {
            //showing of pages and data's 
            if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
                show_404();
            }

                
            // this will load  , include or  structured the template in our views . 
            // para syang pinapalaman 
            $this->load->view('templates/header');
            $this->load->view('pages/' . $page);
            $this->load->view('templates/footer');
        } else {

            $user_id  = $this->Posts_model->login();

            //storing session data 
            if ($user_id) {
                $user_data = array(
                    'firstname' =>   $user_id['firstname'],
                    'lastname' =>   $user_id['lastname'],
                    'fullname' => $user_id['firstname'] . '  ' . $user_id['lastname'],
                    'id' =>   $user_id['id'],
                    'access' =>   $user_id['is_admin'],
                    'logged_in' => true
                );

                $this->session->set_userdata($user_data);
                $this->session->set_flashdata('user_loggedin', ' You are now logged in as :    ' . $this->session->firstname);
                redirect(base_url());
            } else {
                $this->session->set_flashdata('login_failed', 'Credentials not found' . $this->session->firstname);
                redirect('login');
            }
        }
    }

    //logout unsetting the sessions 
    public function logout()
    {   
        // #1 
        $this->session->sess_destroy(); 
        // or #2 
        // $this->session->unset_userdata('firstname');
        // $this->session->unset_userdata('lastname');
        // $this->session->unset_userdata('fullname');
        // $this->session->unset_userdata('id');
        // $this->session->unset_userdata('access');
        // $this->session->unset_userdata('logged_in');
        
        $this->session->set_flashdata('log_out', 'You are now logged out');
        redirect('login');
    }

    //search function 
    public function search()
    {     
   
        $page = 'home';
        $param = $this->input->post('search');
        //type of pages or filename of the page 
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404();
        }

        

        $data['title'] = 'New Post';
        $data['posts'] = $this->Posts_model->get_post_search($param);
        $data['total'] = count($data['posts']);
        
        // this will load  , include or  structured the template in our views . 
        // para syang pinapalaman 
        $this->load->view('templates/header');
        $this->load->view('pages/' . $page, $data);
        $this->load->view('templates/footer');
    }
}
