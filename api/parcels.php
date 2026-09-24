<?php
    header('Content-Type: application/json');
    require_once 'config.php';
    $bbox = $_GET['bbox'] ?? null;
    if(!$bbox){
        echo json_encode(['error' => 'Bounding box parameter is required']);
        exit;
    }
    [$minLon, $minLat, $maxLon, $maxLat] = explode(',', $bbox);
    $sql = 'SELECT id, parcel_number, ST_AsGeoJSON(geom) as geometry
            FROM parcels
            WHERE geom && ST_MakeEnvelope(:minLon, :minLat, :maxLon, :maxLat, 4326)';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':minLon' => $minLon,
        ':minLat' => $minLat,
        ':maxLon' => $maxLon,
        ':maxLat' => $maxLat
    ]);
    $places = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $places[] = [
        'type' => 'Feature',
        'geometry' => json_decode($row['geometry']),
        'properties' => [
            'id' => $row['id'],
            'parcel_number' => $row['parcel_number']
        ]
    ];
    }
    echo json_encode([
        'type' => 'FeatureCollection',
        'features' => $places
    ]);
?>