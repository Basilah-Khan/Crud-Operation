
<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

require_once 'config.php'; 
session_start();
$userID = @$_SESSION['sess_id'];
 
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value
// echo $columnName;
// print_r($_REQUEST);exit;

$searchArray = array();

## Search 
$filterQuery = " AND added_by = $userID ";
if (!empty($searchValue)) {
	if ($searchValue == 'yes' || $searchValue == 'no') {
		$active = ($searchValue == 'yes') ? 'Y': 'N';
		$filterQuery .= " AND isActive = '$active' ";
	}else{
		$filterQuery .= " AND name LIKE '%$searchValue%' OR email LIKE '%$searchValue%' OR mobile LIKE '%$searchValue%' OR address LIKE '%$searchValue%' ";
	}
}

if ($columnIndex != 0 || $columnSortOrder != 'asc') {
	$filterQuery .= " ORDER BY $columnName $columnSortOrder";
}

#echo $filterQuery;exit;
## Total number of records without filtering
$stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM customer_info WHERE added_by = $userID");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount']; 


## Total number of records with filtering
$stmt = $pdo->prepare("SELECT COUNT(*) AS allcount FROM  customer_info WHERE 1 ".$filterQuery);
$stmt->execute();
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records 
$stmt = $pdo->prepare("SELECT * FROM  customer_info WHERE 1 ".$filterQuery." LIMIT $row, $rowperpage"); 
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array(); 
foreach($empRecords as $row){
	$id = $row['cid'];
	$date = date('d M y h:iA', strtotime($row['datec']));
	$name = $row['name'];
	$email = $row['email'];
	$mobile = $row['mobile'];
	$address = $row['address'];
	$isActive = $row['isActive'];

	$active = '';
    if($isActive == 'Y'){
        $active='Yes';  
    }else{
        $active='No';
    }

    $btnEdit = '<a class="btn btn-round btnSuccess" href="edit.php?id='.$id.'"> <i class="fa fa-pen fa-volume-high"></i></a>';
    $btnView = '<a class="btn btn-round btnInfo" href="detail.php?id='.$id.'"> <i class="fa fa-eye fa-volume-high"></i></a>';
    $btnDelete = '<button class="btn btn-round btnDanger" onclick="detail('.$id.');"> <i class="fa fa-trash fa-volume-high"></i></button>';
    $btns = $btnEdit . $btnView . $btnDelete;

	
    $data[] = array(
            "edate"=> $date,
            "name"=>$name,
            "email"=>$email,
            "mobile"=>$mobile,
            "address"=>$address,
            "isActive"=>$active,
            "btns"=>$btns
        );
}
#print_r($data);exit;

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);
echo json_encode($response);
