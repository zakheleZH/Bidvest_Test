<?php

class Student
{
    public $id;
    public $name;
    public $surname;
    public $age;
    public $curriculum;


      function set_id($id)
      {
          if(!empty($id) && (is_numeric($id) ==1) && (strlen($id) ==7))
          {
            $this->id = $id;
          }
          else
          {
              die("Please Enter a Valid Student ID");
          }
      }


      function set_name($name)
      {
          if(!empty($name))
          {
            $this->name = $name;
          }
          else
          {
              die("Name is Empty: Please Enter Student Name");
          }
         
      }


      function set_surname($surname)
      {
          if(!empty($surname))
          {
            $this->surname = $surname;
          }
          else
          {
              die("Surname is Empty: Please Enter Student Surname");
          }
         
      }


      function set_age($age)
      {
          if(!empty($age) && (is_numeric($age) ==1))
          {
            $this->age = $age;
          }
          else
          {
              die("Please Enter a Valid Student Age");
          }
         
      }

      function set_curriculum($curriculum)
      {
          if(!empty($curriculum))
          {
            $this->curriculum = $curriculum;
          }
          else
          {
              die("Curriculum is Empty: Please Enter Curriculum");
          }
         
      }

          // function to create student folder and json file
          public function Create_student_folder_file()
          {
            $get_first_second_number = substr($this->id,0,2);
            @$folder_name .= $get_first_second_number. "/";


            if (!file_exists($folder_name))
            {
               mkdir($folder_name);
            
               $array = array('id' => $this->id,'name' => $this->name,'surname' => $this->surname,'age'=>$this->age,'curriculum'=>$this->curriculum);
               $fp = fopen($folder_name.'/'."$this->id.json", 'w'); // creating student Json file name
               fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   // here it will print the array pretty
               fclose($fp);
               die("Student Record Created Successfully");
            }
           else
           {
               echo "Folder name Already Exist\n";
           } 

          }

// delete function

    public  function deleteDir($dirPath)
     {
    if (!is_dir($dirPath)) {
        if (file_exists($dirPath) !== false) {
            unlink($dirPath);
        }
        return;
    }

    if ($dirPath[strlen($dirPath) - 1] != '/') {
        $dirPath .= '/';
    }

    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }

    // try,catch exception code 
 try{
    rmdir($dirPath);
    echo "Student Record Deleted Successfully";
 }catch(Exception $ex) {
    $code = $ex->getCode();
    $message = $ex->getMessage();
    $file = $ex->getFile();
    $line = $ex->getLine();
    echo "Exception thrown in $file on line $line: [Code $code]
    $message";
  }
   
}


}

?>