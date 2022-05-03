<?php
session_start();
ini_set("display_errors",1);
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST");
header("Content-type:application/json; charset=UTF-8");
include_once("../config/database.php");
include_once("../classes/users.php");

$db = new  Database();

$connection = $db->connect();

$user_obj = new  Users($connection);
    
if($_SERVER['REQUEST_METHOD'] === "POST"){
     
    if(!empty($_POST['vendorid']) && !empty($_POST['ajentid']) && !empty($_POST['flag'])){ 
    $user_obj->vendorid = $_POST['vendorid'];
    $user_obj->ajentid = $_POST['ajentid'];
    $user_obj->status = $_POST['flag'];
    $leads = $user_obj->get_ajent_leads();
    if($leads->num_rows>0){
        while($arr = $leads->fetch_assoc()){
            // pickup date time start
             
            if(!empty($arr['soon'])){
                $day = $arr['soon'];
                $month = $arr['day1'];
                $year = $arr['year'];
            }else{
                $day = $arr['day'];
                $month = $arr['day1'];
                $year = $arr['year'];
            };
             if($arr['offerprice'] >= 100){
                 $offerprice = $arr['offerprice'];
             }else{
                $offerprice = "sorry we can't purchase"; 
             }
             if(isset($_POST['ajentid'])){
                 $aj = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM `ajents` WHERE `id` = $_POST[ajentid]"));
                 $ajentname = $aj['ajentname'];
             }else{
               $ajentname = '';  
             }
             
               //  extra
             if(!empty($arr['varientid'])){
                 $aj = mysqli_fetch_assoc(mysqli_query($connection,"SELECT * FROM `varient` WHERE `id` = $arr[varientid] "));
                 $varientname = $aj['varient'];
             }else{
               $varientname = '';  
             }
            // picup date time end
            $leadinfo[]=array(
              "lead_id" => $arr['enquid'],
              "vendorname" => $arr['name'],
              "ajentname" => $ajentname,
              "model_name" => $arr['model_name'],
              "varientname" => $varientname,
              "catid" => "$arr[catid]",
              "imageurl"=> "https://sellit.co.in/admin/img/".$arr['mimg'],
              "price" => $offerprice,
              "lead_pick_status" => $arr['soon'],
              "lead_pick_date" =>  $day,
              "lead_pick_month" =>  $month,
               "lead_pick_year" =>  $year,
              "lead_pick_time" => $arr['time'],
              "modify_date" =>  $arr['modify_date'],
              "city" => $arr['city'],
              "lead_status" =>  $arr['status'],
            );
        }

        http_response_code(200);
        echo json_encode(array(
            "status" => "1",
            "message" => "success",
            "leads_information" => $leadinfo,
            // JSON_FORCE_OBJECT
        ));

    }else{
        http_response_code(200);
        echo json_encode(array(
            "status" => 0,
            "message" => "no records found"
        ));
    }
    }else{
          http_response_code(200);
    echo json_encode(array(
        "status" => 0,
        "message" => "pLEASE pass the vendor id and status"
    ));
    }

}else{
    http_response_code(503);
    echo json_encode(array(
        "status" => 0,
        "message" => "pLEASE SELECT POST DATA TYPE"
    ));
}


?>