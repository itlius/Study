<?php
    function uploadify()
    {
        $sub=$this->input->post();
        if(!empty($_FILES))
        {
            $source=$sub['source'];
            $year=date("Y",time());
            $month=date("n",time());
            $day=date("j",time());
            $ext=end(explode('.', $_FILES["Filedata"]["name"]));
            
            $_dir = "./uploads/$source/$year/$month/$day/";
            if (!is_dir($his_dir)) {
                $this->commfunctions->mkpath($_dir);
            }
             move_uploaded_file($_FILES["Filedata"]["tmp_name"],$_dir.md5(time()).'_'.md5($_FILES["Filedata"]["name"]).'.'.$ext);
             echo "/uploads/$source/$year/$month/$day/".md5(time()).'_'.md5($_FILES["Filedata"]["name"]).'.'.$ext;
        }
    }