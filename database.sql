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