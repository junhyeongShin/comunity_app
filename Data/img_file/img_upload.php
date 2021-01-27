<?php

// include dirname(__FILE__,1)'';

require dirname(__FILE__,2).'/db_user_info.php';
// echo var_dump(dirname(__FILE__,2));

$target_path = dirname(__FILE__).'/';
// echo var_dump($target_path);

// echo "<br>";

// 파일 이상없는지 확인
if (isset($_FILES['image']['name'])) {
    $target_path = $target_path . basename($_FILES['image']['name']);

    // echo var_dump($target_path);

    try {

        // 예외처리
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // 에러결과 보내기
            echo json_encode(array('result_code' => '200','result_check' => 'could not move file'));

        }

        $img_path = $_FILES['image']['name'];

        //DB에 img 업로드
        $query_img_upload ="INSERT INTO image (img_path) VALUES( '".$img_path."' )";

        $conn = mysqli_connect($db_address, $db_userid, $db_userpw);
        mysqli_select_db($conn, $database);
        $result = $conn->query($query_img_upload);

        //DB 인덱스 번호 리턴
        $query_img_index ="SELECT MAX(id) FROM image";

        $result_img_index = $conn ->query($query_img_index);

        $row_img_index=mysqli_fetch_assoc($result_img_index);

                        
        // 업로드 성공시
        echo json_encode(array('result_code'=>'200', 'result_check'=>'OK', 'result_index'=>$row_img_index ));


    } catch (Exception $e) {

        // Exception occurred. Make error flag true
        echo json_encode(array('result_code'=>'200', 'result_check'=>$e->getMessage()));
    }
} else {

    // File parameter is missing
    echo json_encode(array('result_code'=>'400', 'result_check'=>'Not received any file'));
}


?>