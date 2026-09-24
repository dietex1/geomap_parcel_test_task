<?php
    header('Content-Type: application/json');
    require_once 'config.php';
    $id = $_GET['id'] ?? null;
    if (!$id){
        echo json_encode(['error' => 'Parcel ID  is required']);
        exit;
    }
    $sql = 'SELECT id, parcel_number, katastr_name, area_meters, owner FROM parcels WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $parcel = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$parcel){
        echo json_encode(['error' => 'Parcel not found']);
        exit;
    }
    echo json_encode($parcel);
?>