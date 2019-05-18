--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: OgrenciBilgiSistemi; Type: DATABASE; Schema: -; Owner: postgres
--

CREATE DATABASE "OgrenciBilgiSistemi" WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'tr_TR.UTF-8' LC_CTYPE = 'tr_TR.UTF-8';


ALTER DATABASE "OgrenciBilgiSistemi" OWNER TO postgres;

\connect "OgrenciBilgiSistemi"

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: AkademikPersonel; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "AkademikPersonel" (
    id integer NOT NULL,
    "sicilNo" character varying(10) NOT NULL,
    adi character varying(40) NOT NULL,
    soyadi character varying(40) NOT NULL,
    bolum integer NOT NULL
);


ALTER TABLE "AkademikPersonel" OWNER TO postgres;

--
-- Name: AkademikPersonel_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "AkademikPersonel_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "AkademikPersonel_id_seq" OWNER TO postgres;

--
-- Name: AkademikPersonel_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "AkademikPersonel_id_seq" OWNED BY "AkademikPersonel".id;


--
-- Name: Bolum; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Bolum" (
    id integer NOT NULL,
    "bolumKodu" character varying(4) NOT NULL,
    "bolumAdi" character varying(60) NOT NULL,
    "bolumBaskani" integer
);


ALTER TABLE "Bolum" OWNER TO postgres;

--
-- Name: Bolum_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Bolum_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Bolum_id_seq" OWNER TO postgres;

--
-- Name: Bolum_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Bolum_id_seq" OWNED BY "Bolum".id;


--
-- Name: Ogrenci; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Ogrenci" (
    id integer NOT NULL,
    "ogrenciNo" character(10) NOT NULL,
    adi character varying(50) DEFAULT 'aa'::character varying NOT NULL,
    soyadi character varying(50) DEFAULT 'aa'::character varying NOT NULL,
    bolum integer,
    danisman integer
);


ALTER TABLE "Ogrenci" OWNER TO postgres;

--
-- Name: Ogrenciler_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Ogrenciler_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Ogrenciler_id_seq" OWNER TO postgres;

--
-- Name: Ogrenciler_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Ogrenciler_id_seq" OWNED BY "Ogrenci".id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "AkademikPersonel" ALTER COLUMN id SET DEFAULT nextval('"AkademikPersonel_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Bolum" ALTER COLUMN id SET DEFAULT nextval('"Bolum_id_seq"'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Ogrenci" ALTER COLUMN id SET DEFAULT nextval('"Ogrenciler_id_seq"'::regclass);


--
-- Data for Name: AkademikPersonel; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "AkademikPersonel" VALUES (3, 'A1', 'Ahmet', 'Yılmaz', 1);


--
-- Name: AkademikPersonel_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"AkademikPersonel_id_seq"', 3, true);


--
-- Data for Name: Bolum; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "Bolum" VALUES (1, '1212', 'Bilgisayar Mühendisliği', 1);
INSERT INTO "Bolum" VALUES (2, '1213', 'Bilişim Sistemleri Mühendisliği', NULL);


--
-- Name: Bolum_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Bolum_id_seq"', 2, true);


--
-- Data for Name: Ogrenci; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO "Ogrenci" VALUES (3, 'B151212322', 'Ayşe', 'Güler', 1, 3);
INSERT INTO "Ogrenci" VALUES (1, 'B151212323', 'Mehmet', 'Ayaz', 1, 3);
INSERT INTO "Ogrenci" VALUES (2, 'B121212122', 'Ayten', 'Yılmaz', 2, 3);
INSERT INTO "Ogrenci" VALUES (4, 'B111212134', 'Ayşen', 'Şahin', 1, 3);


--
-- Name: Ogrenciler_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"Ogrenciler_id_seq"', 4, true);


--
-- Name: AkademikPersonel_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "AkademikPersonel"
    ADD CONSTRAINT "AkademikPersonel_pkey" PRIMARY KEY (id);


--
-- Name: Bolum_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Bolum"
    ADD CONSTRAINT "Bolum_pkey" PRIMARY KEY (id);


--
-- Name: Ogrenci_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Ogrenci"
    ADD CONSTRAINT "Ogrenci_pkey" PRIMARY KEY (id);


--
-- Name: adNX; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "adNX" ON "AkademikPersonel" USING btree (adi);


--
-- Name: index_adi; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX index_adi ON "Ogrenci" USING btree (adi);


--
-- Name: index_ogrenciNo; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "index_ogrenciNo" ON "Ogrenci" USING btree ("ogrenciNo");


--
-- Name: index_soyadi; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX index_soyadi ON "Ogrenci" USING btree (soyadi);


--
-- Name: soyadNX; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "soyadNX" ON "AkademikPersonel" USING btree (soyadi);


--
-- Name: AkademikPersonelBolumLNK; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "AkademikPersonel"
    ADD CONSTRAINT "AkademikPersonelBolumLNK" FOREIGN KEY (bolum) REFERENCES "Bolum"(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: OgrenciBolumLNK; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Ogrenci"
    ADD CONSTRAINT "OgrenciBolumLNK" FOREIGN KEY (bolum) REFERENCES "Bolum"(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: lnk_Ogrenci_AkademikPersonel; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Ogrenci"
    ADD CONSTRAINT "lnk_Ogrenci_AkademikPersonel" FOREIGN KEY (danisman) REFERENCES "AkademikPersonel"(id) MATCH FULL ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

