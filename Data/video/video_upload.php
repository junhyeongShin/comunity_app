<?php

// include dirname(__FILE__,1)'';

require dirname(__FILE__,2).'/db_user_info.php';
// echo var_dump(dirname(__FILE__,2));

$target_path = dirname(__FILE__).'/';
// echo var_dump($target_path);

// echo "<br>";

// 파일 이상없는지 확인
if (isset($_FILES['video']['name'])) {
    $target_path = $target_path . basename($_FILES['video']['name']);

    // echo var_dump($target_path);

    try {

        // 예외처리
        if (!move_uploaded_file($_FILES['video']['tmp_name'], $target_path)) {

            switch ($_FILES['video']['error']) {
              case UPLOAD_ERR_INI_SIZE:
              $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
              break;
              case UPLOAD_ERR_FORM_SIZE:
              $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
              break;
              case UPLOAD_ERR_PARTIAL:
              $message = "The uploaded file was only partially uploaded";
              break;
              case UPLOAD_ERR_NO_FILE:
              $message = "No file was uploaded";
              break;
              case UPLOAD_ERR_NO_TMP_DIR:
              $message = "Missing a temporary folder";
              break;
              case UPLOAD_ERR_CANT_WRITE:
              $message = "Failed to write file to disk";
              break;
              case UPLOAD_ERR_EXTENSION:
              $message = "File upload stopped by extension";
              break;
              default:
              $message = "Unknown upload error";
              break;
              }

             // 에러결과 보내기
            echo json_encode(array('result_code' => '200','result_check' => $message));

              
              
        }else{

        // 업로드 성공시
        echo json_encode(array('result_code'=>'200', 'result_check'=>'OK','video_name'=>$_FILES['video']['name'] ));


        }
                      

    } catch (Exception $e) {

        // Exception occurred. Make error flag true
        echo json_encode(array('result_code'=>'200', 'result_check'=>$e->getMessage()));
    }
} else {

    // File parameter is missing
    echo json_encode(array('result_code'=>'400', 'result_check'=>'Not received any file'));
}


?>