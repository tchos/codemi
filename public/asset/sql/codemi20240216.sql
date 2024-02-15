PGDMP     (        	            |            codemi    13.11    13.11 ,    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    17334    codemi    DATABASE     [   CREATE DATABASE codemi WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE = 'en_GB.UTF-8';
    DROP DATABASE codemi;
                postgres    false            �           0    0    DATABASE codemi    ACL     &   GRANT ALL ON DATABASE codemi TO lolo;
                   postgres    false    4062            �            1259    17372    agents_invalides    TABLE     �  CREATE TABLE public.agents_invalides (
    id integer NOT NULL,
    page_id integer,
    nom character varying(255) NOT NULL,
    matricule_armee character varying(8) DEFAULT NULL::character varying,
    matricule_solde character varying(7) DEFAULT NULL::character varying,
    grade character varying(64) DEFAULT NULL::character varying,
    taux_invalidite integer,
    date_invalidite date,
    rang_instance integer,
    revalorisation_y_n boolean,
    type_agent character varying(32) DEFAULT NULL::character varying,
    auteur_invalide character varying(255) DEFAULT NULL::character varying,
    date_deces_auteur date,
    type_invalidite character varying(16) DEFAULT NULL::character varying,
    rang_decision integer,
    rang_page integer
);
 $   DROP TABLE public.agents_invalides;
       public         heap    postgres    false            �            1259    17366    agents_invalides_id_seq    SEQUENCE     �   CREATE SEQUENCE public.agents_invalides_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.agents_invalides_id_seq;
       public          postgres    false            �            1259    17387 	   decisions    TABLE     �  CREATE TABLE public.decisions (
    id integer NOT NULL,
    numero_decision character varying(255) NOT NULL,
    date_signature date NOT NULL,
    signataire character varying(64) NOT NULL,
    ministere character varying(64) NOT NULL,
    nbre_pages integer NOT NULL,
    nbre_agents_invalides_decision integer NOT NULL,
    copie character varying(255) NOT NULL,
    user_decision_id integer,
    is_deleted boolean DEFAULT false
);
    DROP TABLE public.decisions;
       public         heap    postgres    false            �            1259    17368    decisions_id_seq    SEQUENCE     y   CREATE SEQUENCE public.decisions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.decisions_id_seq;
       public          postgres    false            �            1259    17335    doctrine_migration_versions    TABLE     �   CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);
 /   DROP TABLE public.doctrine_migration_versions;
       public         heap    postgres    false            �            1259    17354    historiques    TABLE     %  CREATE TABLE public.historiques (
    id integer NOT NULL,
    nature character varying(64) NOT NULL,
    type_action character varying(32) NOT NULL,
    clef character varying(64) NOT NULL,
    auteur character varying(32) NOT NULL,
    date_action timestamp(0) without time zone NOT NULL
);
    DROP TABLE public.historiques;
       public         heap    postgres    false            �           0    0    COLUMN historiques.date_action    COMMENT     T   COMMENT ON COLUMN public.historiques.date_action IS '(DC2Type:datetime_immutable)';
          public          postgres    false    204            �            1259    17352    historiques_id_seq    SEQUENCE     {   CREATE SEQUENCE public.historiques_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.historiques_id_seq;
       public          postgres    false            �            1259    17392    pages    TABLE     �   CREATE TABLE public.pages (
    id integer NOT NULL,
    decision_id integer NOT NULL,
    numero_page character varying(8) NOT NULL,
    nbre_agents_invalides_page integer NOT NULL
);
    DROP TABLE public.pages;
       public         heap    postgres    false            �            1259    17370    pages_id_seq    SEQUENCE     u   CREATE SEQUENCE public.pages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.pages_id_seq;
       public          postgres    false            �            1259    17343    utilisateurs    TABLE       CREATE TABLE public.utilisateurs (
    id integer NOT NULL,
    username character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL,
    service character varying(255) NOT NULL,
    fullname character varying(255) NOT NULL,
    telephone character varying(32) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    date_dernier_connexion timestamp(0) without time zone NOT NULL,
    created_by_id integer,
    enable_y_n boolean NOT NULL,
    is_password_modified boolean
);
     DROP TABLE public.utilisateurs;
       public         heap    postgres    false            �           0    0    COLUMN utilisateurs.created_at    COMMENT     T   COMMENT ON COLUMN public.utilisateurs.created_at IS '(DC2Type:datetime_immutable)';
          public          postgres    false    202            �            1259    17341    utilisateurs_id_seq    SEQUENCE     |   CREATE SEQUENCE public.utilisateurs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.utilisateurs_id_seq;
       public          postgres    false            �          0    17372    agents_invalides 
   TABLE DATA             COPY public.agents_invalides (id, page_id, nom, matricule_armee, matricule_solde, grade, taux_invalidite, date_invalidite, rang_instance, revalorisation_y_n, type_agent, auteur_invalide, date_deces_auteur, type_invalidite, rang_decision, rang_page) FROM stdin;
    public          postgres    false    208   �7       �          0    17387 	   decisions 
   TABLE DATA           �   COPY public.decisions (id, numero_decision, date_signature, signataire, ministere, nbre_pages, nbre_agents_invalides_decision, copie, user_decision_id, is_deleted) FROM stdin;
    public          postgres    false    209   �7       �          0    17335    doctrine_migration_versions 
   TABLE DATA           [   COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
    public          postgres    false    200   8       �          0    17354    historiques 
   TABLE DATA           Y   COPY public.historiques (id, nature, type_action, clef, auteur, date_action) FROM stdin;
    public          postgres    false    204   =9       �          0    17392    pages 
   TABLE DATA           Y   COPY public.pages (id, decision_id, numero_page, nbre_agents_invalides_page) FROM stdin;
    public          postgres    false    210   &:       �          0    17343    utilisateurs 
   TABLE DATA           �   COPY public.utilisateurs (id, username, roles, password, service, fullname, telephone, created_at, date_dernier_connexion, created_by_id, enable_y_n, is_password_modified) FROM stdin;
    public          postgres    false    202   C:       �           0    0    agents_invalides_id_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.agents_invalides_id_seq', 1, false);
          public          postgres    false    205            �           0    0    decisions_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.decisions_id_seq', 3, true);
          public          postgres    false    206            �           0    0    historiques_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.historiques_id_seq', 17, true);
          public          postgres    false    203            �           0    0    pages_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.pages_id_seq', 1, false);
          public          postgres    false    207            �           0    0    utilisateurs_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.utilisateurs_id_seq', 12, true);
          public          postgres    false    201            @           2606    17385 &   agents_invalides agents_invalides_pkey 
   CONSTRAINT     d   ALTER TABLE ONLY public.agents_invalides
    ADD CONSTRAINT agents_invalides_pkey PRIMARY KEY (id);
 P   ALTER TABLE ONLY public.agents_invalides DROP CONSTRAINT agents_invalides_pkey;
       public            postgres    false    208            C           2606    17391    decisions decisions_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.decisions
    ADD CONSTRAINT decisions_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.decisions DROP CONSTRAINT decisions_pkey;
       public            postgres    false    209            8           2606    17340 <   doctrine_migration_versions doctrine_migration_versions_pkey 
   CONSTRAINT        ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);
 f   ALTER TABLE ONLY public.doctrine_migration_versions DROP CONSTRAINT doctrine_migration_versions_pkey;
       public            postgres    false    200            >           2606    17358    historiques historiques_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.historiques
    ADD CONSTRAINT historiques_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.historiques DROP CONSTRAINT historiques_pkey;
       public            postgres    false    204            G           2606    17396    pages pages_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.pages
    ADD CONSTRAINT pages_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.pages DROP CONSTRAINT pages_pkey;
       public            postgres    false    210            <           2606    17350    utilisateurs utilisateurs_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.utilisateurs
    ADD CONSTRAINT utilisateurs_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.utilisateurs DROP CONSTRAINT utilisateurs_pkey;
       public            postgres    false    202            E           1259    17397    idx_2074e575bdee7539    INDEX     M   CREATE INDEX idx_2074e575bdee7539 ON public.pages USING btree (decision_id);
 (   DROP INDEX public.idx_2074e575bdee7539;
       public            postgres    false    210            9           1259    17364    idx_497b315eb03a8386    INDEX     V   CREATE INDEX idx_497b315eb03a8386 ON public.utilisateurs USING btree (created_by_id);
 (   DROP INDEX public.idx_497b315eb03a8386;
       public            postgres    false    202            D           1259    17416    idx_638daa1714f5bcac    INDEX     V   CREATE INDEX idx_638daa1714f5bcac ON public.decisions USING btree (user_decision_id);
 (   DROP INDEX public.idx_638daa1714f5bcac;
       public            postgres    false    209            A           1259    17386    idx_ab503b69c4663e4    INDEX     S   CREATE INDEX idx_ab503b69c4663e4 ON public.agents_invalides USING btree (page_id);
 '   DROP INDEX public.idx_ab503b69c4663e4;
       public            postgres    false    208            :           1259    17351    uniq_497b315ef85e0677    INDEX     Y   CREATE UNIQUE INDEX uniq_497b315ef85e0677 ON public.utilisateurs USING btree (username);
 )   DROP INDEX public.uniq_497b315ef85e0677;
       public            postgres    false    202            K           2606    17403    pages fk_2074e575bdee7539    FK CONSTRAINT     �   ALTER TABLE ONLY public.pages
    ADD CONSTRAINT fk_2074e575bdee7539 FOREIGN KEY (decision_id) REFERENCES public.decisions(id);
 C   ALTER TABLE ONLY public.pages DROP CONSTRAINT fk_2074e575bdee7539;
       public          postgres    false    210    209    3907            H           2606    17359     utilisateurs fk_497b315eb03a8386    FK CONSTRAINT     �   ALTER TABLE ONLY public.utilisateurs
    ADD CONSTRAINT fk_497b315eb03a8386 FOREIGN KEY (created_by_id) REFERENCES public.utilisateurs(id);
 J   ALTER TABLE ONLY public.utilisateurs DROP CONSTRAINT fk_497b315eb03a8386;
       public          postgres    false    202    3900    202            J           2606    17411    decisions fk_638daa1714f5bcac    FK CONSTRAINT     �   ALTER TABLE ONLY public.decisions
    ADD CONSTRAINT fk_638daa1714f5bcac FOREIGN KEY (user_decision_id) REFERENCES public.utilisateurs(id);
 G   ALTER TABLE ONLY public.decisions DROP CONSTRAINT fk_638daa1714f5bcac;
       public          postgres    false    3900    209    202            I           2606    17398 #   agents_invalides fk_ab503b69c4663e4    FK CONSTRAINT     �   ALTER TABLE ONLY public.agents_invalides
    ADD CONSTRAINT fk_ab503b69c4663e4 FOREIGN KEY (page_id) REFERENCES public.pages(id);
 M   ALTER TABLE ONLY public.agents_invalides DROP CONSTRAINT fk_ab503b69c4663e4;
       public          postgres    false    208    3911    210            �      x������ � �      �   m   x�=�;�  ��^`eQ-1���R�ڽ����eh�r2Se|��Ȓ����ɣ!�ò�����p(o�4@N�g��Ba���&o��;��:���s����~�R�P-      �     x���1n�0Eg���~J�D�Y�v�RA�%���ܴ��X0`�ޣ�����������|����:M���'&���()
��9���Kɨ��+p�����H�c�]�Ja��jRL:�3�F�y�V?��;�C�(B)?�b�]|�He�{ ��A��DO�@����ATA�_4�����y*��<�������4D�$OA6�d��=;����t��8`��D~���3H#a��Z��3��RY^x�=�n^)������a~ Ap��      �   �   x�m��j�0��y/�d;M|+�Wk�]v�t�?>l0����em���'}�v؎�P�c�D;��.�ϧ��!��kL�5��@�H;b	�q��0y��Y��)��q�L&,|h�����6������%U�fi�����Bj�3�������J���?�T��������V�>�2nJ��"(T�ܜӮ��~=�����G��Í���]�      �      x������ � �      �   e  x�u�Ks�0��u����B�"��*��^���
Z����8��j7g�c���cB�v>��g��~�~Br�щ��D5�岞�Cd8S�\���&.�Y|�y�+>�CT'�q�l�9>
���S��$��u��Y@9"�*�TB�llؘ�4�*6 6�lJ�c��fZ h�/߿��'��kYq��SZd]��h�k1?�V�ɋ�L����j,e>e�Ou�4Eb�Ţ/%�"����)791n& �mß��$����-n����G�%��<�C�����=�Y�#�?;X�u��;����bY&k���������4��G&zI8T��E��bL��WU1�� 3[�_��j���l�     