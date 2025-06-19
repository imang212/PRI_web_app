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


UPDATE staging_exoplanets SET name = regexp_replace(name, 'Canum Venaticorum', 'CVn', 'g') WHERE name LIKE '%Canum Venaticorum%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Canis Majoris', 'CMa', 'g') WHERE name LIKE '%Canis Majoris%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Canis Minoris', 'CMi', 'g') WHERE name LIKE '%Canis Minoris%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Comae Berenices', 'Com', 'g') WHERE name LIKE '%Comae Berenices%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Coronae Australis', 'CrA', 'g') WHERE name LIKE '%Coronae Australis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Coronae Borealis', 'CrB', 'g') WHERE name LIKE '%Coronae Borealis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Leonis Minoris', 'LMi', 'g') WHERE name LIKE '%Leonis Minoris%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Piscis Austrini', 'PsA', 'g') WHERE name LIKE '%Piscis Austrini%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Trianguli Australis', 'TrA', 'g') WHERE name LIKE '%Trianguli Australis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Ursae Majoris', 'UMa', 'g') WHERE name LIKE '%Ursae Majoris%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Ursae Minoris', 'UMi', 'g') WHERE name LIKE '%Ursae Minoris%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Andromedae', 'And', 'g') WHERE name LIKE '%Andromedae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Antliae', 'Ant', 'g') WHERE name LIKE '%Antliae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Apodis', 'Aps', 'g') WHERE name LIKE '%Apodis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Aquarii', 'Aqr', 'g') WHERE name LIKE '%Aquarii%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Aquilae', 'Aql', 'g') WHERE name LIKE '%Aquilae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Arae', 'Ara', 'g') WHERE name LIKE '%Arae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Arietis', 'Ari', 'g') WHERE name LIKE '%Arietis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Aurigae', 'Aur', 'g') WHERE name LIKE '%Aurigae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Bootis', 'Boo', 'g') WHERE name LIKE '%Bootis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Caeli', 'Cae', 'g') WHERE name LIKE '%Caeli%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Camelopardalis', 'Cam', 'g') WHERE name LIKE '%Camelopardalis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Cancri', 'Cnc', 'g') WHERE name LIKE '%Cancri%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Capricorni', 'Cap', 'g') WHERE name LIKE '%Capricorni%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Carinae', 'Car', 'g') WHERE name LIKE '%Carinae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Cassiopeiae', 'Cas', 'g') WHERE name LIKE '%Cassiopeiae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Centauri', 'Cen', 'g') WHERE name LIKE '%Centauri%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Cephei', 'Cep', 'g') WHERE name LIKE '%Cephei%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Ceti', 'Cet', 'g') WHERE name LIKE '%Ceti%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Chamaeleontis', 'Cha', 'g') WHERE name LIKE '%Chamaeleontis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Circini', 'Cir', 'g') WHERE name LIKE '%Circini%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Columbae', 'Col', 'g') WHERE name LIKE '%Columbae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Corvi', 'Crv', 'g') WHERE name LIKE '%Corvi%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Crateris', 'Crt', 'g') WHERE name LIKE '%Crateris%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Crucis', 'Cru', 'g') WHERE name LIKE '%Crucis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Cygni', 'Cyg', 'g') WHERE name LIKE '%Cygni%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Delphini', 'Del', 'g') WHERE name LIKE '%Delphini%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Doradus', 'Dor', 'g') WHERE name LIKE '%Doradus%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Draconis', 'Dra', 'g') WHERE name LIKE '%Draconis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Equulei', 'Equ', 'g') WHERE name LIKE '%Equulei%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Eridani', 'Eri', 'g') WHERE name LIKE '%Eridani%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Fornacis', 'For', 'g') WHERE name LIKE '%Fornacis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Geminorum', 'Gem', 'g') WHERE name LIKE '%Geminorum%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Gruis', 'Gru', 'g') WHERE name LIKE '%Gruis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Herculis', 'Her', 'g') WHERE name LIKE '%Herculis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Horologii', 'Hor', 'g') WHERE name LIKE '%Horologii%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Hydrae', 'Hya', 'g') WHERE name LIKE '%Hydrae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Hydri', 'Hyi', 'g') WHERE name LIKE '%Hydri%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Indi', 'Ind', 'g') WHERE name LIKE '%Indi%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Lacertae', 'Lac', 'g') WHERE name LIKE '%Lacertae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Leonis', 'Leo', 'g') WHERE name LIKE '%Leonis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Leporis', 'Lep', 'g') WHERE name LIKE '%Leporis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Librae', 'Lib', 'g') WHERE name LIKE '%Librae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Lupi', 'Lup', 'g') WHERE name LIKE '%Lupi%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Lyncis', 'Lyn', 'g') WHERE name LIKE '%Lyncis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Lyrae', 'Lyr', 'g') WHERE name LIKE '%Lyrae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Mensae', 'Men', 'g') WHERE name LIKE '%Mensae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Microscopii', 'Mic', 'g') WHERE name LIKE '%Microscopii%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Monocerotis', 'Mon', 'g') WHERE name LIKE '%Monocerotis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Muscae', 'Mus', 'g') WHERE name LIKE '%Muscae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Normae', 'Nor', 'g') WHERE name LIKE '%Normae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Octantis', 'Oct', 'g') WHERE name LIKE '%Octantis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Ophiuchi', 'Oph', 'g') WHERE name LIKE '%Ophiuchi%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Orionis', 'Ori', 'g') WHERE name LIKE '%Orionis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Pavonis', 'Pav', 'g') WHERE name LIKE '%Pavonis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Pegasi', 'Peg', 'g') WHERE name LIKE '%Pegasi%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Persei', 'Per', 'g') WHERE name LIKE '%Persei%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Phoenicis', 'Phe', 'g') WHERE name LIKE '%Phoenicis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Pictoris', 'Pic', 'g') WHERE name LIKE '%Pictoris%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Piscium', 'Psc', 'g') WHERE name LIKE '%Piscium%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Puppis', 'Pup', 'g') WHERE name LIKE '%Puppis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Pyxidis', 'Pyx', 'g') WHERE name LIKE '%Pyxidis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Reticuli', 'Ret', 'g') WHERE name LIKE '%Reticuli%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Sagittae', 'Sge', 'g') WHERE name LIKE '%Sagittae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Sagittarii', 'Sgr', 'g') WHERE name LIKE '%Sagittarii%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Scorpii', 'Sco', 'g') WHERE name LIKE '%Scorpii%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Sculptoris', 'Scl', 'g') WHERE name LIKE '%Sculptoris%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Scuti', 'Sct', 'g') WHERE name LIKE '%Scuti%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Serpentis', 'Ser', 'g') WHERE name LIKE '%Serpentis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Sextantis', 'Sex', 'g') WHERE name LIKE '%Sextantis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Tauri', 'Tau', 'g') WHERE name LIKE '%Tauri%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Telescopii', 'Tel', 'g') WHERE name LIKE '%Telescopii%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Trianguli', 'Tri', 'g') WHERE name LIKE '%Trianguli%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Tucanae', 'Tuc', 'g') WHERE name LIKE '%Tucanae%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Velorum', 'Vel', 'g') WHERE name LIKE '%Velorum%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Virginis', 'Vir', 'g') WHERE name LIKE '%Virginis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Volantis', 'Vol', 'g') WHERE name LIKE '%Volantis%';
UPDATE staging_exoplanets SET name = regexp_replace(name, 'Vulpeculae', 'Vul', 'g') WHERE name LIKE '%Vulpeculae%';


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
        -- Pokus o přímou konverzi
        WHEN trim(releasedate) ~ '^\d{4}-\d{2}-\d{2}$' THEN trim(releasedate)::DATE
        -- Rok-měsíc + první den
        WHEN trim(releasedate) ~ '^\d{4}-(0[1-9]|1[0-2])$' THEN (trim(releasedate) || '-01')::DATE
        -- Jen rok + první den roku
        WHEN trim(releasedate) ~ '^\d{4}$' THEN (trim(releasedate) || '-01-01')::DATE
        -- Formát bez leading zeros (2023-9-1)
        WHEN trim(releasedate) ~ '^\d{4}-\d{1,2}-\d{1,2}$' THEN trim(releasedate)::DATE
        ELSE NULL
    END
FROM temp_exoplanets_2;

CREATE TABLE exoplanets AS
SELECT
    e.*,
    n.pl_name,
    n.pl_pubdate,
    n.releasedate
FROM staging_exoplanets e
LEFT JOIN staging_exoplanets_2 n ON LOWER(e.name) = LOWER(n.pl_name);

ALTER TABLE exoplanets ADD COLUMN id SERIAL PRIMARY KEY;


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