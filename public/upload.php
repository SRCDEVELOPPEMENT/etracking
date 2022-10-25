    <?php
        if(isset($_POST['submit'])){
            echo $_FILES['file']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["file"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }        

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["file"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $file_name = $target_dir . basename($_FILES["file"]["name"]);
                    $id_livraison = intval($_POST['id']);

                    $serverName = "DEFFO-ARMEL\MSSQL2"; 
                    $uid = "sa";   
                    $pwd = "Password01*";  
                    $databaseName = "e-tracking"; 
                    $connectionInfo = array( "UID"=>$uid,                            
                                            "PWD"=>$pwd,                            
                                            "Database"=>$databaseName); 
                    $conn = sqlsrv_connect( $serverName, $connectionInfo);
                    $Query = "UPDATE livraisons
                              SET filename = '". $file_name ."'
                              WHERE id= '". $id_livraison ."'";

                    $stmt = sqlsrv_query( $conn, $Query);
                    if ($stmt)
                    {
                        header("Location: livraisons");
                    }else{
                        die( print_r( sqlsrv_errors(), true));
                    }
                    
                //echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
                } else {
                echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        if(isset($_POST['submit_download'])){
            $id_livraison =  $_POST['id'];
            
            $serverName = "DEFFO-ARMEL\MSSQL2";
            $uid = "sa";   
            $pwd = "Password01*";  
            $databaseName = "e-tracking"; 
            $connectionInfo = array( "UID"=>$uid,                            
                                    "PWD"=>$pwd,                            
                                    "Database"=>$databaseName); 
            $conn = sqlsrv_connect( $serverName, $connectionInfo);
            $Query = "SELECT filename FROM livraisons
                      WHERE id= '". $id_livraison ."'";

            $stmt = sqlsrv_query( $conn, $Query);
            if ($stmt)  
            {  
                while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC)) 
                {
                    $url = $row[0];
                }
                if(file_exists($url)){
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="'.basename($url).'"');
                    header('Content-Length: ' . filesize($url));
                    header('Pragma: public');

                    flush();
                    readfile($url,true);
                    header("Location: livraisons");
                }
            }else{
                die( print_r( sqlsrv_errors(), true));
            }
        }
    ?>