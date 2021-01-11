<?php

namespace mf\moustache;

class admin {


    public $match;
    public $theme;
    public $data;
    public $result;


    public function set_match($match)
    {
        $this->match = $match;
    }

    public function set_theme($theme)
    {
        $this->theme = $theme;
    }

    public function set_data($data)
    {
        $this->data = $data;
    }

    public function result()
    {
        return str_replace('{{'.$this->match.'}}', $this->result, $this->theme);
    }


    public function match()
    {
        if (current_user_can('edit_posts'))
        {
            $this->create_admin_button();
            $this->delete_if_set();
        }

        return;
    }

    public function create_admin_button()
    {

        $post_id = $this->data['post']->ID;

        // Selection
        $output = '<div class="andyp-grid__cell-meta andyp-grid__cell-admin">';

            $output .= '<input class="andyp-grid__cell-admin--delete" type="checkbox" value="checkbox" name="'.$post_id.'" /></input>';

            // Edit Button
            $output .= '<a class="andyp-grid__cell-admin--edit" href="'.get_edit_post_link($post_id).'" target="_blank">';
                $output .= '<span class="mdi mdi-pencil"></span>';
            $output .= '</a>';

        $output .= '</div>';

        $this->result = $output;
        
    }


    public function delete_if_set()
    {
        
        $command = '';
        
        if (!current_user_can('edit_posts')) {
            return;
        }

        if (!isset($_POST)){
            return;
        }

        if ( isset($_POST['command']) )
        {
            $command = $_POST['command'];
            unset($_POST['command']);
        }

        foreach($_POST as $id => $checkbox)
        {
            if ($command == 'Delete')
            {
                $this->trash($id);
            }

            if ($command == 'Highlight')
            {
                $this->highlight($id);
            }
        }
    }



    public function trash($id)
    {
        wp_trash_post($id);
    }
    

    public function highlight($id)
    {
        $term = get_term_by('slug', 'highlighted', 'scrapercategory');
        // 117 = 'highlighted'
        wp_set_post_terms($id, $term->term_id, 'scrapercategory', true);
        return;
    }

    
}