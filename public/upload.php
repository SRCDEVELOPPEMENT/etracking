    <?php
        if(isset($_POST['submit'])){
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $file_name = $target_dir . basename($_FILES["file"]["name"]);
                    $id_livraison = intval($_POST['id']);

                    $serverName = "SRVALFRESCO"; 
                    $uid = "sa";   
                    $pwd = "dir@SIEX!1989";  
                    $databaseName = "e-tracking"; 
                    $connectionInfo = array( "UID"=>$uid,                            
                                                    "PWD"=>$pwd,                            
                                                    "Database"=>$databaseName, 
                                                    "Encrypt"=>true, 
                                                    "TrustServerCertificate"=>true); 
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
                }
        }

        if(isset($_POST['submit_download'])){
            $id_livraison =  $_POST['id'];
            
            $serverName = "SRVALFRESCO"; 
            $uid = "sa";   
            $pwd = "dir@SIEX!1989";  
            $databaseName = "e-tracking"; 
            $connectionInfo = array( "UID"=>$uid,                            
                                            "PWD"=>$pwd,                            
                                            "Database"=>$databaseName, 
                                            "Encrypt"=>true, 
                                            "TrustServerCertificate"=>true); 
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