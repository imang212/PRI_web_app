DROP TABLE IF EXISTS staging_exoplanets;
DROP TABLE IF EXISTS staging_exoplanets_2;
DROP TABLE IF EXISTS exoplanets;
DROP TABLE IF EXISTS dim_planet_type;
DROP TABLE IF EXISTS dim_detection_method;
DROP TABLE IF EXISTS dim_stellar_type;
DROP TABLE IF EXISTS dim_mass_category;
DROP TABLE IF EXISTS dim_distance_category;
DROP TABLE IF EXISTS dim_orbit_category;
DROP TABLE IF EXISTS dim_brightness_category;
DROP TABLE IF EXISTS dim_discovery_era;
DROP TABLE IF EXISTS dim_date;

CREATE TABLE staging_exoplanets (
    "name" TEXT,
    distance DOUBLE PRECISION,
    stellar_magnitude DOUBLE PRECISION,
    planet_type TEXT,
    discovery_year INTEGER,
    mass_multiplier DOUBLE PRECISION,
    mass_wrt TEXT,
    radius_multiplier DOUBLE PRECISION,
    radius_wrt TEXT,
    orbital_radius DOUBLE PRECISION,
    orbital_period DOUBLE PRECISION,
    eccentricity DOUBLE PRECISION,
    detection_method TEXT
);
COPY staging_exoplanets FROM '/data/cleaned_5250.csv' DELIMITER ',' CSV HEADER;

CREATE TABLE temp_exoplanets_2 (
    pl_name TEXT,
    pl_pubdate TEXT,
    releasedate TEXT
);
COPY temp_exoplanets_2 FROM '/data/exoplanets_cleaned.csv' DELIMITER ',' CSV HEADER NULL '';

CREATE TABLE staging_exoplanets_2 (
    pl_name TEXT,
    pl_pubdate DATE,
    releasedate DATE
);
INSERT INTO staging_exoplanets_2
SELECT
    pl_name,
    CASE
        WHEN pl_pubdate = '' OR pl_pubdate IS NULL THEN NULL
        WHEN pl_pubdate ~ '^\d{4}-(0[1-9]|1[0-2])$' THEN (pl_pubdate || '-01')::DATE
        WHEN pl_pubdate ~ '^\d{4}-\d{2}-\d{2}$' THEN pl_pubdate::DATE
        ELSE NULL  -- fallback for invalid formats like '2015-00'
    END,
    CASE
        WHEN releasedate = '' OR releasedate IS NULL THEN NULL
        WHEN releasedate ~ '^\d{4}-(0[1-9]|1[0-2])$' THEN (releasedate || '-01')::DATE
        WHEN releasedate ~ '^\d{4}-\d{2}-\d{2}$' THEN releasedate::DATE
        ELSE NULL
    END
FROM temp_exoplanets_2;


CREATE TABLE exoplanets AS
SELECT e.*, n.pl_pubdate, n.releasedate
FROM staging_exoplanets e
LEFT JOIN staging_exoplanets_2 n ON LOWER(e.name) = LOWER(n.pl_name);

CREATE TABLE dim_planet_type AS
SELECT ROW_NUMBER() OVER () AS planet_type_id, planet_type
FROM (
    SELECT DISTINCT planet_type
    FROM exoplanets
    WHERE planet_type IS NOT NULL
) t;

CREATE TABLE dim_detection_method AS
    SELECT ROW_NUMBER() OVER () AS detection_method_id, detection_method
    FROM (
        SELECT DISTINCT detection_method
        FROM exoplanets
        WHERE detection_method IS NOT NULL
    ) t;

CREATE TABLE dim_stellar_type AS
SELECT ROW_NUMBER() OVER () AS stellar_type_id, distance, stellar_magnitude,
    CASE
        WHEN stellar_magnitude < 0 THEN 'very bright'
        WHEN stellar_magnitude BETWEEN 0 AND 2 THEN 'bright'
        WHEN stellar_magnitude BETWEEN 2 AND 5 THEN 'moderate'
        WHEN stellar_magnitude BETWEEN 5 AND 10 THEN 'dim'
        ELSE 'very dim'
    END AS brightness_category
FROM (
    SELECT DISTINCT distance, stellar_magnitude
    FROM exoplanets
    WHERE distance IS NOT NULL AND stellar_magnitude IS NOT NULL
) t;

CREATE TABLE dim_mass_category AS
    SELECT ROW_NUMBER() OVER () AS mass_category_id, mass_multiplier,
        CASE
            WHEN mass_multiplier < 0.1 THEN 'Very Low Mass'
            WHEN mass_multiplier < 1 THEN 'Low Mass'
            WHEN mass_multiplier < 5 THEN 'Medium Mass'
            WHEN mass_multiplier < 20 THEN 'High Mass'
            ELSE 'Very High Mass'
        END AS mass_category
    FROM (
        SELECT DISTINCT mass_multiplier
        FROM exoplanets
        WHERE mass_multiplier IS NOT NULL
    ) t;

CREATE TABLE dim_distance_category AS
    SELECT ROW_NUMBER() OVER () AS distance_category_id, distance,
      CASE
        WHEN distance < 10 THEN 'Very Close (<10 ly)'
        WHEN distance < 100 THEN 'Close (<100 ly)'
        WHEN distance < 1000 THEN 'Medium (<1000 ly)'
        ELSE 'Far (>1000 ly)'
      END AS distance_category
    FROM (
        SELECT DISTINCT distance
        FROM exoplanets
        WHERE distance IS NOT NULL
    ) t;

CREATE TABLE dim_orbit_category AS
    SELECT ROW_NUMBER() OVER () AS orbit_category_id, orbital_period,
        CASE
            WHEN orbital_period < 10 THEN 'Very Short'
            WHEN orbital_period < 100 THEN 'Short'
            WHEN orbital_period < 1000 THEN 'Moderate'
            ELSE 'Long'
        END AS period_class
    FROM (
        SELECT DISTINCT orbital_period
        FROM exoplanets
        WHERE orbital_period IS NOT NULL
    ) t;

CREATE TABLE dim_brightness_category AS
    SELECT ROW_NUMBER() OVER () AS brightness_category_id, stellar_magnitude,
      CASE
        WHEN stellar_magnitude < 5 THEN 'Very Bright'
        WHEN stellar_magnitude < 10 THEN 'Bright'
        WHEN stellar_magnitude < 15 THEN 'Dim'
        ELSE 'Very Dim'
      END AS brightness_category
    FROM (
        SELECT DISTINCT stellar_magnitude
        FROM exoplanets
        WHERE stellar_magnitude IS NOT NULL
    ) t;

CREATE TABLE dim_discovery_era AS
    SELECT ROW_NUMBER() OVER () AS discovery_era_id, discovery_year,
      CASE
        WHEN discovery_year < 2000 THEN '<2000'
        WHEN discovery_year < 2010 THEN 'Early 21st Century'
        WHEN discovery_year < 2020 THEN 'Kepler Era'
        ELSE 'Modern Era'
      END AS discovery_era
    FROM (
        SELECT DISTINCT discovery_year
        FROM exoplanets
        WHERE discovery_year IS NOT NULL
    ) t;

CREATE TABLE dim_date AS
SELECT
    ROW_NUMBER() OVER () AS date_id,
    releasedate::DATE AS date,
    EXTRACT(YEAR FROM releasedate::DATE) AS year,
    EXTRACT(MONTH FROM releasedate::DATE) AS month,
    TO_CHAR(releasedate::DATE, 'Month') AS month_name,
    EXTRACT(DAY FROM releasedate::DATE) AS day,
    TO_CHAR(releasedate::DATE, 'Day') AS weekday_name
FROM (
    SELECT DISTINCT releasedate
    FROM exoplanets
    WHERE releasedate IS NOT NULL
) t;

CREATE TABLE exoplanets_full AS
SELECT e.*,
    p.planet_type_id,
    d.detection_method_id,
    s.stellar_type_id,
    m.mass_category_id,
    dc.distance_category_id,
    o.orbit_category_id,
    b.brightness_category_id,
    de.discovery_era_id,
    dt.date_id
FROM exoplanets e
LEFT JOIN dim_planet_type p ON e.planet_type = p.planet_type
LEFT JOIN dim_detection_method d ON e.detection_method = d.detection_method
LEFT JOIN dim_stellar_type s ON e.distance = s.distance AND e.stellar_magnitude = s.stellar_magnitude
LEFT JOIN dim_mass_category m ON e.mass_multiplier = m.mass_multiplier
LEFT JOIN dim_distance_category dc ON e.distance = dc.distance
LEFT JOIN dim_orbit_category o ON e.orbital_period = o.orbital_period
LEFT JOIN dim_brightness_category b ON e.stellar_magnitude = b.stellar_magnitude
LEFT JOIN dim_discovery_era de ON e.discovery_year = de.discovery_year
LEFT JOIN dim_date dt ON e.releasedate::DATE = dt.date;