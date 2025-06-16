import pandas as pd
import re

def strip_html(text):
    return re.sub(r"<[^>]*>", "", str(text))

df = pd.read_csv(r"C:\docker_weby\PRI_web_app\db\data\PS_2025.04.28_06.13.44.csv", comment="#", dtype=str)
df = df.map(strip_html)
columns_to_keep = ["pl_name", "pl_pubdate", "releasedate"]
df = df[columns_to_keep]
df.to_csv(r"C:\docker_weby\PRI_web_app\db\data\exoplanets_cleaned.csv", index=False)