<?php
// รับค่ามาแปลงเป็นออบเจ็ค รูปแบบที่เอามาทำงานได้
$objJSON = json_decode($_POST["json"]);

$typeQuery = $objJSON->{'type'};

$sea = "";
$id = null;
// รับค่ามาใส่ตัวแปรตามเงื่อนไข พิมหา,กด+
if ($typeQuery == 'search-input') {
    $sea = $objJSON->{'name'};
} else if ($typeQuery == 'more-button') {
    $id =  $objJSON->{'id'};
}

$servernameDB = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbnameDB = "rfs2";
// $conn = mysqli_connect($servernameDB, $usernameDB, $passwordDB, $dbnameDB);
// mysqli_set_charset($conn, 'utf8');

// รูปแบการเชื่อมต่อ PDO
try {

    $conn = new PDO("mysql:host=$servernameDB;dbname=$dbnameDB", $usernameDB, $passwordDB);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("set names utf8");
} catch (PDOException $e) {
    echo "Connected failed: " . $e->getMessage();
}

// เงื่อนไขเวลาหาข้อมูล แล้วดึงข้อมูลมา
if ($typeQuery == 'search-input'){
    $stmt = $conn->prepare("
        SELECT invoice_id, company_id, company_format, invoice_number, name, organization, address, email, create_dt 
     FROM invoice WHERE Name LIKE '%" . $sea . "%' OR email LIKE '%" . $sea . "%' OR create_dt LIKE '%" . $sea . "%' 
     OR address LIKE '%" . $sea . "%' OR organization LIKE '%" . $sea . "%' OR invoice_number LIKE '%" . $sea . "%'
     OR company_format LIKE '%" . $sea . "%' OR company_id LIKE '%" . $sea . "%' OR invoice_id LIKE '%" . $sea . "%'
     ORDER BY invoice_id ASC LIMIT 0,10;
    ");

// $check = $stmt->execute();
$stmt->execute();

$dd = $stmt->fetchAll(PDO::FETCH_ASSOC);
exit(json_encode($dd));

// เงื่อนไขเวลาคลิ๊ก แล้วดึงข้อมูลมา
} else if ($typeQuery == 'more-button') {
    $stmt1 = $conn->prepare("
        SELECT invoice_item.invoice_id,invoice.name,invoice_item.item_id,invoice_item.company_id,
invoice_item.description,invoice_item.price,invoice_item.total 
FROM invoice INNER JOIN invoice_item 
ON invoice.invoice_id = invoice_item.invoice_id 
WHERE invoice_item.invoice_id = ".$id."
LIMIT 0,10;
    ");
$stmt1->execute();
$ss = $stmt1->fetchAll(PDO::FETCH_ASSOC);
exit(json_encode($ss));
}

// $output = [];

//     // เอาไว้เช็ค
//     if( empty( $check ) )
//     {
//         $output["message"] = "เกิดข้อผิดพลาด";
//         $output["success"] = 0;
//         exit( json_encode($output ) );
//     } 
//     else 
//     {
//         $output["message"] = "บันทึกข้อมูลสำเร็จ";
//         $output["success"] = 1;
//         exit( json_encode($output ) );
//     }
//     // $conn = null;
?>