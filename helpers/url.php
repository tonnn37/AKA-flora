<?php  

    @session_start();

    $type = $_SESSION['userlevel'];



    function base_url($paht = ''){
        return 'http://localhost/AKA-flora/'.$paht; 
    }
    function base_admin($paht = ''){
        return base_url("admin.php?page=".$paht);
    }
    if ($type == 'ผู้ดูแลระบบ') {
    $menu = [
        "index" => ["name" => "หน้าแรก","paht" => base_url("admin.php") , "icon" => "tv" ,"color" => "#40E0D0"], 
        "user" => ["name" => "พนักงาน","paht" => base_admin("user") , "icon" => "users" ,"color" => "#0000CD"],
        "permissions" => ["name" => "ผู้ใช้งาน","paht" => base_admin("permissions") , "icon" => "user-cog" ,"color" => "#191970"],       
        "plant" => ["name" => "ข้อมูลพันธุ์ไม้","paht" => base_admin("plant") , "icon" => "tree" ,"color" => "#228B22"], 
        "material" => ["name" => "ข้อมูลวัสดุปลูก","paht" => base_admin("material") , "icon" => "prescription-bottle" ,"color" => "#b75b05"], 
        "drug" => ["name" => "ข้อมูลยา","paht" => base_admin("drug") , "icon" => "prescription-bottle-alt","color" => "#DC143C"], 	
        "drugformula" => ["name" => "สูตรยา","paht" => base_admin("drugformula") , "icon" => "book" ,"color" => "#B22222"], 
        "customer" => ["name" => "ข้อมูลลูกค้า","paht" => base_admin("customer") , "icon" => "user-tie" ,"color" => "#FF0000"],	
        "order" => ["name" => "รายการสั่งซื้อ","paht" => base_admin("order") , "icon" => "list-ol" ,"color" => "#FF69B4"], 	
        "planting" => ["name" => "รายการปลูก","paht" => base_admin("planting") , "icon" => "seedling" ,"color" => "#339900"],
        "stock_recieve" => ["name" => "คัดเกรดพันธุ์ไม้","paht" => base_admin("stock_recieve") , "icon" => "ad" ,"color" => "#FF6633"], 
        "stock_handover" => ["name" => "ส่งมอบพันธุ์ไม้","paht" => base_admin("stock_handover") , "icon" => "hand-holding-usd" ,"color" => "#9900FF"], 
        "stock" => ["name" => "สต็อกพันธุ์ไม้","paht" => base_admin("stock") , "icon" => "list-alt" ,"color" => "#330099"],      
        "settings" => ["name" => "ตั้งค่า","paht" => base_admin("settings") , "icon" => "cogs" ,"color" => "#FF1493	"],
        
    ];
    $head = [
        "page_report_order"=>["h"=>"รายงานข้อมูลการสั่งซื้อของลูกค้า"],
        "page_report_planting"=>["h"=>"รายงานข้อมูลรายการปลูก"],
        "page_report_handover"=>["h"=>"รายงานข้อมูลการส่งมอบ"],
        "page_report_handover_stock"=>["h"=>"รายงานข้อมูลการส่งมอบตามจำนวนสต็อค"],
        "page_report_payment"=>["h"=>"รายงานข้อมูลลูกค้า walk-in"],
        "page_report_top"=>["h"=>"รายงานข้อมูลยอดพันธุ์ไม้ขายดี"],
        "page_report_breeder"=>["h"=>"รายงานข้อมูลสต็อคพันธุ์ไม้"],
        "page_report_material"=>["h"=>'รายงานข้อมูลต้นทุนรายการปลูก']];
     
    }else {

        $menu = [
            "index" => ["name" => "หน้าแรก","paht" => base_url("admin.php") , "icon" => "tv" ,"color" => "#40E0D0"], 	
            "planting" => ["name" => "รายการปลูก","paht" => base_admin("planting") , "icon" => "seedling" ,"color" => "#339900"],
            "stock" => ["name" => "สต็อกพันธุ์ไม้","paht" => base_admin("stock") , "icon" => "list-alt" ,"color" => "#330099"],
            "stock_handover" => ["name" => "ส่งมอบพันธุ์ไม้","paht" => base_admin("stock_handover") , "icon" => "hand-holding-usd" ,"color" => "#9900FF"], 
           
        ];
    }
?>