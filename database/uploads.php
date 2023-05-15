<?php
    declare(strict_types=1);
    class Upload {
        static public function uploadFile(string $username, bool $pfp) : ?array{
            $path_to_save = '/../uploads/';
            $upload_dir = __DIR__ . $path_to_save;
            
            if ($pfp){
                $upload_dir  = $upload_dir . 'pfp/';
                $path_to_save = $path_to_save . 'pfp/';
                $files_array = $_FILES['pfp'];
            }
            else{
                $files_array = $_FILES['documents'];
            }

            
            $error = $files_array['error'];
            if ($error == UPLOAD_ERR_NO_FILE) exit('No file provided');
            
            $user_dir = $upload_dir . $username . '_'; 
            
            $file_paths = array();
            
            if ($pfp){
                $error = $files_array['error'];
                if ($error == UPLOAD_ERR_OK){
                    $upload_file = $user_dir . basename($files_array['name']);
                    
                    $upload_file = Upload::newName($upload_file);

                    var_dump($upload_file);

                    $tmp_name =$files_array['tmp_name'];
                    move_uploaded_file($tmp_name, $upload_file);
                    $file_paths[0] = $path_to_save . $username . '_' . basename($files_array['name']);
                }
            }
            else{
                foreach ($files_array['error'] as $key => $error){
                    if ($error == UPLOAD_ERR_OK){
                        $upload_file = $user_dir . basename($files_array['name'][$key]);
                        
                        $upload_file = Upload::newName($upload_file);

                        var_dump($upload_file);

                        $tmp_name =$files_array['tmp_name'][$key];
                        move_uploaded_file($tmp_name, $upload_file);
                        $file_paths[$key] = $path_to_save . $username . '_' . basename($files_array['name'][$key]);
                    }
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