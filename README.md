<p align="left">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=flat&logo=javascript&logoColor=black" />
  <img src="https://img.shields.io/badge/PostgreSQL-17-4169E1?style=flat&logo=postgresql&logoColor=white" />
  <img src="https://img.shields.io/badge/Docker-Infrastructure-2496ED?style=flat&logo=docker&logoColor=white" />
  <img src="https://img.shields.io/badge/Tailwind-CSS-06B6D4?style=flat&logo=tailwindcss&logoColor=white" />
</p>

# Exoplanets Web App
<p align="center">
  <img src="https://github.com/user-attachments/assets/0fc859d3-5dc8-4c22-835c-6e1ddf38eda1" alt="ExoWorlds Dashboard Preview">
</p>

**ExoWorlds** is a specialized web-based application designed for the exploration and management of NASA exoplanet data. The project leverages structured data formats and high-performance server-side processing to provide a seamless interface for interacting with celestial datasets.

### Tech stack
- **Backend**: PHP 8.2(Apache) with **AJAX** for asynchronous data retrieval.
- **Database**: **PostgreSQL** (Pre-processed via Python/Pandas for star schema compatibility).
- **Data Formats**: **XML** and **XSD** for structured data exchange and validation.
- **Frontend**: Vanilla JavaScript, HTML5, CSS3, and **Tailwind CSS** for modern styling.
- **Infrastructure:** Docker (Containers: `web_exoplanets`, `Tailwind`, `postgres_db_exoplanets`, `adminer_exoplanets`).

### Data Pipeline
The application uses official data from the [**NASA Exoplanet Archive**](https://exoplanetarchive.ipac.caltech.edu/) downloaded as csv and preprocessed in Python Pandas to format compatible with PostgreSQL. And data from [**Aditya Mishra (kaggle.com)**](https://www.kaggle.com/datasets/adityamishraml/nasaexoplanets) - Enriched dataset providing more descriptive columns and detailed metadata.
1. **Preprocessing:** Python (Pandas) is used to clean and merge CSV data from NASA and Kaggle.
2. **Modeling:** Data is transformed into a relational **Star Schema** within PostgreSQL.
3. **Delivery:** The web app fetches and manages this data using PHP, ensuring integrity via XSD validation.

### Quick Start
To launch the entire environment, ensure you have Docker installed and run:
```bash
docker-compose up --build
```
- **Web App:** `http://localhost:8080` (or your mapped port)
- **Database Admin (Adminer):** `http://localhost:8081`

### Key Features
- **AJAX Integration:** Dynamic data loading without page refreshes.
- **XML Validation:** Robust data exchange using XSD schemas to ensure astronomical data accuracy.
- **Dockerized Workflow:** Isolated environment for easy deployment and database management.
- **Comprehensive Datasets:** Combined insights from multiple NASA-based sources.

**Author:** imang212
