<?php

include dirname(__FILE__)'';

$target_path = dirname(__FILE__).'.';



// 파일 이상없는지 확인
if (isset($_FILES['image']['name'])) {
    $target_path = $target_path . basename($_FILES['image']['name']);

    try {

        // 예외처리
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // 에러결과 보내기
            echo json_encode(array('result_code' => '200','result_check' => 'could not move file'));

        }

        // 업로드 성공시
        echo json_encode(array('result_code'=>'200', 'result_check'=>'OK'));

    } catch (Exception $e) {

        // Exception occurred. Make error flag true
        echo json_encode(array('result_code'=>'200', 'result_check'=>$e->getMessage()));
    }
} else {

    // File parameter is missing
    echo json_encode(array('result_code'=>'400', 'result_check'=>'Not received any file'));
}


?>