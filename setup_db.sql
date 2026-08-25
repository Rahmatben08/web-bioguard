CREATE USER bioguard_user WITH ENCRYPTED PASSWORD 'BioGuard2026!';
GRANT ALL PRIVILEGES ON DATABASE bioguard_db TO bioguard_user;
\c bioguard_db
GRANT ALL ON SCHEMA public TO bioguard_user;
