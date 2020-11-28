<?php
include("classes/index.php");

// checking which Action must be perform(add,edit,delete)
$Action =  $_SERVER['argv'];

$Student_class = new Student(); // creating an Instance of student Class


if(strtolower($Action[1]) == "--action=add")
{
    $id = readline("Enter id: ");
    $Student_class->set_id($id);

    $name = readline("Enter name: ");
    $Student_class->set_name($name);

    $surname = readline("Enter Surname: ");
    $Student_class->set_surname($surname);
    
    $age = readline("Enter age: ");
    $Student_class->set_age($age);
    
    $curriculum = readline("Enter Curriculum: ");
    $Student_class->set_curriculum($curriculum);
  // entering Student information

 

  
  // creating student folder
  $Student_class->Create_student_folder_file();

    
}

// end add



// edit student information
if(strtolower($Action[1]) == "--action=edit")
{
     //getting the student Id 
    $strStudentID = substr($Action[2],5,7);
    if(strlen($strStudentID) ==7)
    {
        $get_folder_name = substr($strStudentID,0,2); 
        
 
            if (file_exists($get_folder_name)) // checking if student Folder Exist
            { 
                             
                $data = file_get_contents($get_folder_name.'/'.$strStudentID.'.'.'json'); // reading student Json file
                $data_array = json_decode($data, true);
                $student_id = $data_array['id'];
                $student_name = $data_array['name'];
                $student_surname = $data_array['surname'];
                $student_age = $data_array['age'];
                $student_curriculum = $data_array['curriculum'];

                if($student_id == $strStudentID)
                {
                    echo "Leave the field blank to keep previous value\n";
                    $student_name_update = readline("Enter name [$student_name]: ");
                    $student_surname_update = readline("Enter surname [$student_surname]: ");
                    $student_age_update = readline("Enter age [$student_age]: ");
                    $student_curriculum_update = readline("Enter curriculum[$student_curriculum]: ");

                    if(!empty($student_name_update))
                    {
                        $student_name =  $student_name_update;
                    }

                    if(!empty($student_surname_update))
                    {
                        $student_surname =  $student_surname_update;
                    }
                    if(!empty($student_age_update))
                    {
                        $student_age =  $student_age_update;
                    }
                    if(!empty($student_curriculum_update))
                    {
                        $student_curriculum =  $student_curriculum_update;
                    }
                    echo "$student_name\n";
                    echo "$student_surname\n";
                    echo "$student_age\n";
                    echo "$student_curriculum\n";

                    $array = array('id' => $student_id,'name' => $student_name,'surname' => $student_surname,'age'=>$student_age,'curriculum'=>$student_curriculum);
                    $fp = fopen($get_folder_name.'/'."$strStudentID.json", 'w'); // saving student data on the json file
                    fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));   
                    fclose($fp);
                }

                else
                {
                    die("Invalid student ID");
                }
               
            }
            else
            {
               
                die("Your Folder Does Not Exist\n");
            }         
    }
    else
    {
        echo "Invalide Student ID\n";
    }

}

if(strtolower($Action[1]) == "--action=delete")
{

    $strStudentID = substr($Action[2],5,7);
    if(strlen($strStudentID) ==7 && (is_numeric($strStudentID) ==1))
    {
        $ask_user = readline("are you sure you want to delete(yes/no)? : ");
       
        $prompt_user  = strtolower($ask_user);

        if($prompt_user == "yes")
        {
            $get_folder_name = substr($strStudentID,0,2);

            $Student_class->deleteDir($get_folder_name); //deleting student record
        }

        elseif($prompt_user == "no")
        {
            die("student record not deleted");
        }

        else
        {
            die("Invalide Input please enter (yes/no)");
        }
      
    }

    else
    {
        die("Please Enter Valide Student ID");
    }

}

// search by student name
if(strtolower($Action[1]) == "--action=search")
{
    $student_search_criteria = readline("Enter search criteria:name= ");

  $dir = new DirectoryIterator(dirname(__FILE__)); 
   $folder = scandir($dir);
   $get_folder_name = $folder[2];
   $get_file_name = scandir($get_folder_name);
   $file_name = $get_file_name[2];

   $data = file_get_contents($get_folder_name.'/'.$file_name); // reading student Json file
   $data_array = json_decode($data, true);
   $student_id = $data_array['id'];
   $student_name = $data_array['name'];
   $student_surname = $data_array['surname'];
   $student_age = $data_array['age'];
   $student_curriculum = $data_array['curriculum'];

   if($student_search_criteria == $student_name) // searching student records
   {
    echo "-------------------------------------------------------------------------\n";
    echo "|id  |Name |Surname |Age |Curriculum\n";
    echo "-------------------------------------------------------------------------\n";
    echo "|$student_id |$student_name |$student_surname |$student_age |$student_curriculum\n ";
    echo "-------------------------------------------------------------------------\n";
   }

   else
   {
       die("Invalide Search");
   }

}

?>