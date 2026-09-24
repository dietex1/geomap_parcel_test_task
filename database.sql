CREATE EXTENSION IF NOT EXISTS postgis;

CREATE TABLE IF NOT EXISTS parcels(
    id SERIAL PRIMARY KEY,
    parcel_number VARCHAR(255) UNIQUE,
    katastr_name VARCHAR(100),
    area_meters INT,
    owner TEXT,
    geom GEOMETRY(Polygon, 4326)
);

CREATE INDEX idx_parcel_geom_bbox ON parcels USING GIST (geom);

INSERT INTO parcels (parcel_number, ku_nazev, area_m2, owner_info, geom) VALUES
                                                                             ('123/1', 'Jičín', 500, 'Jan Novák', ST_GeomFromText('POLYGON((15.350 50.435, 15.351 50.435, 15.351 50.436, 15.350 50.436, 15.350 50.435))', 4326)),
                                                                             ('124/2', 'Jičín', 750, 'Město Jičín', ST_GeomFromText('POLYGON((15.351 50.435, 15.352 50.435, 15.352 50.436, 15.351 50.436, 15.351 50.435))', 4326));