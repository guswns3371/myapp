<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon.php');


//$stmt = $con->prepare('select * from UserInfo');
//$stmt->execute();
//
//if ($stmt->rowCount() > 0)
//{
//    $data['userinfo'] = array();
//
//    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
//    {
//        extract($row);
//
//        $data['userinfo'][]=
//            array(
//                'idx'=>$idx,
//                'Email'=>$Email,
//                'Password'=>$Password,
//                'Username'=>$Username,
//                'Photo'=>$Photo,
//                'Birthday'=>$Birthday,
//                'Session'=>$Session,
//                'Introduce'=>$Introduce
//
//            );
//    }
//
//    header('Content-Type: application/json; charset=utf8');
//
//}

$stmt2 = $con->prepare("select * from ChatRoom");
$stmt2->execute();

if ($stmt2->rowCount() > 0) {
    $data['chatroomlist'] = array();

    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

        extract($row2);

//        $data['chatroomlist'][] =
//            array(
//                'idx' => $idx,
//                'ChatPeopleNum' => $ChatPeopleNum,
//                'ChatPeople' => $ChatPeople,
//                'ChatRoomName' => $ChatRoomName,
//                'ChatRoomPhoto' => $ChatRoomPhoto,
//                'ChatRoomTime' => $ChatRoomTime,
//                'ChatRoomDes' => $ChatRoomDes
//            );
        $chatroom_idx=$idx;
        $json_chatpeople=json_decode($ChatPeople);
        $IDX=$json_chatpeople[0];
        error_log("IDX_".$IDX);
        foreach ($json_chatpeople as $json_chatpeople){
                error_log("innerdata_".$json_chatpeople);

            $stmt = $con->prepare("select * from UserInfo where idx = '$json_chatpeople'");
            $stmt->execute();

            if ($stmt->rowCount() > 0)
            {
//                $data2['info'][] = array();

                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
                {
                    extract($row);

                    $data2[]=
                        array(
                            'idx'=>$idx,
                            'Email'=>$Email,
                            'Password'=>$Password,
                            'Username'=>$Username,
                            'Photo'=>$Photo,
                            'Birthday'=>$Birthday,
                            'Token'=>$Token,
                            'Introduce'=>$Introduce

                        );
                }
            }

//            $data['chatroomlist'][]['ChatRoomPeopleInfos'][] =
//                array(
//                    'chatroomidx'=>$chatroom_idx,
//                    'useridx'=>$json_chatpeople,
//                    'useridx_info'=>$data2
//                );

        }
        $data['chatroomlist'][] =
            array(
                'ChatRoomIdx'=>$chatroom_idx,
                'ChatPeopleNum' => $ChatPeopleNum,
                'ChatPeople' => $ChatPeople,
                'ChatRoomName' => $ChatRoomName,
                'ChatRoomPhoto' => $ChatRoomPhoto,
                'ChatRoomOutTime' => $ChatRoomOutTime,
                'ChatRoomOutMessage' => $ChatRoomOutMessage,

                'UserIdx'=>$json_chatpeople,
                'UserIdx_Info'=>$data2
            );
        if($chatroom_idx!=$idx){
            //$idx 는 new ChatRoomidx 이고
            //$chatroom_idx는 old ChatRoomidx 이다.
            $data2=null;
        }
    }
}

header('Content-Type: application/json; charset=utf8');
$json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
echo $json;
?>