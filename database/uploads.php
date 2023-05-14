<?php
    declare(strict_types=1);
    class Upload {
        static public function uploadFile(string $username) : ?array{
            $upload_dir = __DIR__ . '/../uploads/';
            
            $error = $_FILES['documents']['error'];
            if ($error == UPLOAD_ERR_NO_FILE) exit('No file provided');
            
            $user_dir = $upload_dir . $username . '_'; 

            $file_paths = array();

            foreach ($_FILES['documents']['error'] as $key => $error){
                if ($error == UPLOAD_ERR_OK){
                    $upload_file = $user_dir . basename($_FILES['documents']['name'][$key]);
                    
                    $upload_file = Upload::newName($upload_file);

                    $tmp_name = $_FILES['documents']['tmp_name'][$key];
                    move_uploaded_file($tmp_name, $upload_file);
                    $file_paths[$key] = $upload_file;
                }
            }

            return $file_paths;
        }

        static function newName($fullpath) {
            $path = dirname($fullpath);
            if (!file_exists($fullpath)) return $fullpath;
            $fnameNoExt = pathinfo($fullpath,PATHINFO_FILENAME);
            $ext = pathinfo($fullpath, PATHINFO_EXTENSION);
          
            $i = 1;
            while(file_exists("$path/$fnameNoExt($i).$ext")) $i++;
            return "$path/$fnameNoExt($i).$ext";
          }
    }
?>