--
-- PostgreSQL database dump
--

\restrict 4IgVob0tqHNPC8RwZX0wBMiZcDlxgKcBcdT1zLb4LnpTL62A1SZDwf0bsYDuHjf

-- Dumped from database version 17.10
-- Dumped by pg_dump version 18.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: merkel
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO merkel;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: merkel
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: contexte; Type: TABLE; Schema: public; Owner: merkel
--

CREATE TABLE public.contexte (
    id_contexte integer NOT NULL,
    nom_contexte character varying(50) NOT NULL
);


ALTER TABLE public.contexte OWNER TO merkel;

--
-- Name: contexte_id_contexte_seq; Type: SEQUENCE; Schema: public; Owner: merkel
--

CREATE SEQUENCE public.contexte_id_contexte_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.contexte_id_contexte_seq OWNER TO merkel;

--
-- Name: contexte_id_contexte_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: merkel
--

ALTER SEQUENCE public.contexte_id_contexte_seq OWNED BY public.contexte.id_contexte;


--
-- Name: priorites; Type: TABLE; Schema: public; Owner: merkel
--

CREATE TABLE public.priorites (
    id_priorite integer NOT NULL,
    nom_priorite character varying(50) NOT NULL
);


ALTER TABLE public.priorites OWNER TO merkel;

--
-- Name: priorites_id_priorite_seq; Type: SEQUENCE; Schema: public; Owner: merkel
--

CREATE SEQUENCE public.priorites_id_priorite_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.priorites_id_priorite_seq OWNER TO merkel;

--
-- Name: priorites_id_priorite_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: merkel
--

ALTER SEQUENCE public.priorites_id_priorite_seq OWNED BY public.priorites.id_priorite;


--
-- Name: statuts; Type: TABLE; Schema: public; Owner: merkel
--

CREATE TABLE public.statuts (
    id_statut integer NOT NULL,
    libelle character varying(50) NOT NULL
);


ALTER TABLE public.statuts OWNER TO merkel;

--
-- Name: statuts_id_statut_seq; Type: SEQUENCE; Schema: public; Owner: merkel
--

CREATE SEQUENCE public.statuts_id_statut_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.statuts_id_statut_seq OWNER TO merkel;

--
-- Name: statuts_id_statut_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: merkel
--

ALTER SEQUENCE public.statuts_id_statut_seq OWNED BY public.statuts.id_statut;


--
-- Name: tache; Type: TABLE; Schema: public; Owner: merkel
--

CREATE TABLE public.tache (
    id_tache integer NOT NULL,
    titre character varying(255) NOT NULL,
    description text,
    date_crea date,
    id_priorite integer,
    id_contexte integer,
    id_type integer,
    id_statut integer
);


ALTER TABLE public.tache OWNER TO merkel;

--
-- Name: tache_id_tache_seq; Type: SEQUENCE; Schema: public; Owner: merkel
--

CREATE SEQUENCE public.tache_id_tache_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tache_id_tache_seq OWNER TO merkel;

--
-- Name: tache_id_tache_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: merkel
--

ALTER SEQUENCE public.tache_id_tache_seq OWNED BY public.tache.id_tache;


--
-- Name: tache_tag; Type: TABLE; Schema: public; Owner: merkel
--

CREATE TABLE public.tache_tag (
    id_tache integer NOT NULL,
    id_tag integer NOT NULL
);


ALTER TABLE public.tache_tag OWNER TO merkel;

--
-- Name: tags; Type: TABLE; Schema: public; Owner: merkel
--

CREATE TABLE public.tags (
    id_tag integer NOT NULL,
    nom_tag character varying(50) NOT NULL
);


ALTER TABLE public.tags OWNER TO merkel;

--
-- Name: tags_id_tag_seq; Type: SEQUENCE; Schema: public; Owner: merkel
--

CREATE SEQUENCE public.tags_id_tag_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tags_id_tag_seq OWNER TO merkel;

--
-- Name: tags_id_tag_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: merkel
--

ALTER SEQUENCE public.tags_id_tag_seq OWNED BY public.tags.id_tag;


--
-- Name: type_tache; Type: TABLE; Schema: public; Owner: merkel
--

CREATE TABLE public.type_tache (
    id_type integer NOT NULL,
    nom_type character varying(50) NOT NULL
);


ALTER TABLE public.type_tache OWNER TO merkel;

--
-- Name: type_tache_id_type_seq; Type: SEQUENCE; Schema: public; Owner: merkel
--

CREATE SEQUENCE public.type_tache_id_type_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.type_tache_id_type_seq OWNER TO merkel;

--
-- Name: type_tache_id_type_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: merkel
--

ALTER SEQUENCE public.type_tache_id_type_seq OWNED BY public.type_tache.id_type;


--
-- Name: contexte id_contexte; Type: DEFAULT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.contexte ALTER COLUMN id_contexte SET DEFAULT nextval('public.contexte_id_contexte_seq'::regclass);


--
-- Name: priorites id_priorite; Type: DEFAULT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.priorites ALTER COLUMN id_priorite SET DEFAULT nextval('public.priorites_id_priorite_seq'::regclass);


--
-- Name: statuts id_statut; Type: DEFAULT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.statuts ALTER COLUMN id_statut SET DEFAULT nextval('public.statuts_id_statut_seq'::regclass);


--
-- Name: tache id_tache; Type: DEFAULT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tache ALTER COLUMN id_tache SET DEFAULT nextval('public.tache_id_tache_seq'::regclass);


--
-- Name: tags id_tag; Type: DEFAULT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tags ALTER COLUMN id_tag SET DEFAULT nextval('public.tags_id_tag_seq'::regclass);


--
-- Name: type_tache id_type; Type: DEFAULT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.type_tache ALTER COLUMN id_type SET DEFAULT nextval('public.type_tache_id_type_seq'::regclass);


--
-- Data for Name: contexte; Type: TABLE DATA; Schema: public; Owner: merkel
--

INSERT INTO public.contexte VALUES (1, 'Bureau');
INSERT INTO public.contexte VALUES (2, 'Domicile');
INSERT INTO public.contexte VALUES (3, 'Deplacement');
INSERT INTO public.contexte VALUES (4, 'En ligne');


--
-- Data for Name: priorites; Type: TABLE DATA; Schema: public; Owner: merkel
--

INSERT INTO public.priorites VALUES (1, 'Faible');
INSERT INTO public.priorites VALUES (2, 'Normal');
INSERT INTO public.priorites VALUES (3, 'Urgent');
INSERT INTO public.priorites VALUES (4, 'Critique');


--
-- Data for Name: statuts; Type: TABLE DATA; Schema: public; Owner: merkel
--

INSERT INTO public.statuts VALUES (1, 'A faire');
INSERT INTO public.statuts VALUES (2, 'En cours');
INSERT INTO public.statuts VALUES (3, 'Bloquée');
INSERT INTO public.statuts VALUES (4, 'En attente');
INSERT INTO public.statuts VALUES (5, 'Termine');


--
-- Data for Name: tache; Type: TABLE DATA; Schema: public; Owner: merkel
--

INSERT INTO public.tache VALUES (1, 'Configurer le cluster Redis sur les nouveaux serveurs OpenStack', 'Vérifier la persistance des données, adapter le fichier de configuration et tester la réplication avant la bascule définitive.', '2026-05-31', 3, 1, 5, 2);
INSERT INTO public.tache VALUES (2, 'Mettre à jour les mots de passe de la base de données', 'Rotation trimestrielle des accès admin. Ne pas oublier de mettre à jour le .env en production.', '2026-05-31', 4, 4, 5, 3);
INSERT INTO public.tache VALUES (3, 'Préparer les slides pour la réunion client', 'Synthétiser les résultats du trimestre et préparer les graphiques pour la présentation de mardi.', '2026-05-31', 3, 1, 3, 1);


--
-- Data for Name: tache_tag; Type: TABLE DATA; Schema: public; Owner: merkel
--

INSERT INTO public.tache_tag VALUES (1, 1);
INSERT INTO public.tache_tag VALUES (1, 2);
INSERT INTO public.tache_tag VALUES (1, 3);
INSERT INTO public.tache_tag VALUES (2, 1);
INSERT INTO public.tache_tag VALUES (2, 2);
INSERT INTO public.tache_tag VALUES (2, 4);


--
-- Data for Name: tags; Type: TABLE DATA; Schema: public; Owner: merkel
--

INSERT INTO public.tags VALUES (1, 'DevOps');
INSERT INTO public.tags VALUES (2, 'Migration');
INSERT INTO public.tags VALUES (3, 'Redis');
INSERT INTO public.tags VALUES (4, 'Securité');


--
-- Data for Name: type_tache; Type: TABLE DATA; Schema: public; Owner: merkel
--

INSERT INTO public.type_tache VALUES (1, 'Appel');
INSERT INTO public.type_tache VALUES (2, 'Email');
INSERT INTO public.type_tache VALUES (3, 'Redaction');
INSERT INTO public.type_tache VALUES (4, 'Réunion');
INSERT INTO public.type_tache VALUES (5, 'Maintenance');


--
-- Name: contexte_id_contexte_seq; Type: SEQUENCE SET; Schema: public; Owner: merkel
--

SELECT pg_catalog.setval('public.contexte_id_contexte_seq', 4, true);


--
-- Name: priorites_id_priorite_seq; Type: SEQUENCE SET; Schema: public; Owner: merkel
--

SELECT pg_catalog.setval('public.priorites_id_priorite_seq', 4, true);


--
-- Name: statuts_id_statut_seq; Type: SEQUENCE SET; Schema: public; Owner: merkel
--

SELECT pg_catalog.setval('public.statuts_id_statut_seq', 5, true);


--
-- Name: tache_id_tache_seq; Type: SEQUENCE SET; Schema: public; Owner: merkel
--

SELECT pg_catalog.setval('public.tache_id_tache_seq', 4, true);


--
-- Name: tags_id_tag_seq; Type: SEQUENCE SET; Schema: public; Owner: merkel
--

SELECT pg_catalog.setval('public.tags_id_tag_seq', 4, true);


--
-- Name: type_tache_id_type_seq; Type: SEQUENCE SET; Schema: public; Owner: merkel
--

SELECT pg_catalog.setval('public.type_tache_id_type_seq', 5, true);


--
-- Name: contexte contexte_pkey; Type: CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.contexte
    ADD CONSTRAINT contexte_pkey PRIMARY KEY (id_contexte);


--
-- Name: priorites priorites_pkey; Type: CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.priorites
    ADD CONSTRAINT priorites_pkey PRIMARY KEY (id_priorite);


--
-- Name: statuts statuts_pkey; Type: CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.statuts
    ADD CONSTRAINT statuts_pkey PRIMARY KEY (id_statut);


--
-- Name: tache tache_pkey; Type: CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tache
    ADD CONSTRAINT tache_pkey PRIMARY KEY (id_tache);


--
-- Name: tache_tag tache_tag_pkey; Type: CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tache_tag
    ADD CONSTRAINT tache_tag_pkey PRIMARY KEY (id_tache, id_tag);


--
-- Name: tags tags_pkey; Type: CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tags
    ADD CONSTRAINT tags_pkey PRIMARY KEY (id_tag);


--
-- Name: type_tache type_tache_pkey; Type: CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.type_tache
    ADD CONSTRAINT type_tache_pkey PRIMARY KEY (id_type);


--
-- Name: tache tache_id_contexte_fkey; Type: FK CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tache
    ADD CONSTRAINT tache_id_contexte_fkey FOREIGN KEY (id_contexte) REFERENCES public.contexte(id_contexte);


--
-- Name: tache tache_id_priorite_fkey; Type: FK CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tache
    ADD CONSTRAINT tache_id_priorite_fkey FOREIGN KEY (id_priorite) REFERENCES public.priorites(id_priorite);


--
-- Name: tache tache_id_statut_fkey; Type: FK CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tache
    ADD CONSTRAINT tache_id_statut_fkey FOREIGN KEY (id_statut) REFERENCES public.statuts(id_statut);


--
-- Name: tache tache_id_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tache
    ADD CONSTRAINT tache_id_type_fkey FOREIGN KEY (id_type) REFERENCES public.type_tache(id_type);


--
-- Name: tache_tag tache_tag_id_tache_fkey; Type: FK CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tache_tag
    ADD CONSTRAINT tache_tag_id_tache_fkey FOREIGN KEY (id_tache) REFERENCES public.tache(id_tache);


--
-- Name: tache_tag tache_tag_id_tag_fkey; Type: FK CONSTRAINT; Schema: public; Owner: merkel
--

ALTER TABLE ONLY public.tache_tag
    ADD CONSTRAINT tache_tag_id_tag_fkey FOREIGN KEY (id_tag) REFERENCES public.tags(id_tag);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: merkel
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;


--
-- PostgreSQL database dump complete
--

\unrestrict 4IgVob0tqHNPC8RwZX0wBMiZcDlxgKcBcdT1zLb4LnpTL62A1SZDwf0bsYDuHjf

