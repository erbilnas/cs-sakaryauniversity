--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.6
-- Dumped by pg_dump version 9.6.6

-- Started on 2017-12-07 23:26:11

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 1 (class 3079 OID 12387)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2287 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 188 (class 1259 OID 16416)
-- Name: Badges; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "Badges" (
    "Id" integer NOT NULL,
    "UserId" integer,
    "Name" character varying(50),
    "Date" timestamp(4) without time zone,
    "Class" smallint,
    "TagBased" bit(1)
);


ALTER TABLE "Badges" OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 16410)
-- Name: Comments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "Comments" (
    "Id" integer NOT NULL,
    "PostId" integer,
    "Score" integer,
    "Text" character varying(600),
    "CreationDate" timestamp(4) without time zone,
    "UserDisplayName" character varying(30),
    "UserId" integer
);


ALTER TABLE "Comments" OWNER TO postgres;

--
-- TOC entry 198 (class 1259 OID 16476)
-- Name: PostFeedback; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "PostFeedback" (
    "Id" integer NOT NULL,
    "PostId" integer,
    "IsAnonymous" bit(1),
    "VoteTypeId" smallint,
    "CreationDate" timestamp(4) without time zone
);


ALTER TABLE "PostFeedback" OWNER TO postgres;

--
-- TOC entry 199 (class 1259 OID 16481)
-- Name: PostHistory; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "PostHistory" (
    "Id" integer NOT NULL,
    "PostHistoryTypeId" smallint,
    "PostId" integer,
    "CreationDate" timestamp(4) without time zone,
    "UserId" integer,
    "UserDisplayName" character varying(40),
    "Comment" character varying(400),
    "Text" character varying,
    "RevisionGUID" integer NOT NULL
);


ALTER TABLE "PostHistory" OWNER TO postgres;

--
-- TOC entry 200 (class 1259 OID 16489)
-- Name: PostHistoryTypes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "PostHistoryTypes" (
    "Id" smallint NOT NULL,
    "Name" character varying(50)
);


ALTER TABLE "PostHistoryTypes" OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 16612)
-- Name: PostHistory_RevisionGUID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "PostHistory_RevisionGUID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "PostHistory_RevisionGUID_seq" OWNER TO postgres;

--
-- TOC entry 2288 (class 0 OID 0)
-- Dependencies: 202
-- Name: PostHistory_RevisionGUID_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "PostHistory_RevisionGUID_seq" OWNED BY "PostHistory"."RevisionGUID";


--
-- TOC entry 197 (class 1259 OID 16468)
-- Name: PostNoticeTypes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "PostNoticeTypes" (
    "Id" integer NOT NULL,
    "ClassId" smallint,
    "Name" character varying(80),
    "Body" character varying,
    "IsHidden" bit(1),
    "Predefined" bit(1),
    "PostNoticeDurationId" integer
);


ALTER TABLE "PostNoticeTypes" OWNER TO postgres;

--
-- TOC entry 196 (class 1259 OID 16460)
-- Name: PostNotices; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "PostNotices" (
    "Id" integer NOT NULL,
    "PostId" integer,
    "PostNoticeTypeId" integer,
    "CreationDate" timestamp(4) without time zone,
    "DeletionDate" timestamp(4) without time zone,
    "ExpiryDate" timestamp(4) without time zone,
    "Body" character varying,
    "OwnerUserId" integer,
    "DeletionUserId" integer
);


ALTER TABLE "PostNotices" OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 16448)
-- Name: PostTags; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "PostTags" (
    "TagId" integer,
    "PostId" integer
);


ALTER TABLE "PostTags" OWNER TO postgres;

--
-- TOC entry 195 (class 1259 OID 16455)
-- Name: PostTypes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "PostTypes" (
    "Id" smallint NOT NULL,
    "Name" character varying(50)
);


ALTER TABLE "PostTypes" OWNER TO postgres;

--
-- TOC entry 185 (class 1259 OID 16394)
-- Name: Posts; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "Posts" (
    "Id" integer NOT NULL,
    "PostTypeId" smallint,
    "AcceptedAnswerId" integer,
    "ParentId" integer,
    "CreationDate" timestamp(4) without time zone,
    "DeletionDate" timestamp(4) without time zone,
    "Score" integer,
    "ViewCount" integer,
    "Body" character varying,
    "OwnerUserId" integer,
    "OwnerDisplayName" character varying(40),
    "LastEditorUserId" integer,
    "LastEditorDisplayName" character varying(40),
    "LastEditDate" timestamp(4) without time zone,
    "LastActivityDate" timestamp(4) without time zone,
    "Title" character varying(250),
    "Tags" character varying(250),
    "AnswerCount" integer,
    "CommentCount" integer,
    "FavoriteCount" integer,
    "ClosedDate" timestamp(4) without time zone,
    "CommunityOwnedDate" timestamp(4) without time zone
);


ALTER TABLE "Posts" OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 16433)
-- Name: ReviewTaskStates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "ReviewTaskStates" (
    "Id" smallint NOT NULL,
    "Name" character varying(50),
    "Description" character varying(300)
);


ALTER TABLE "ReviewTaskStates" OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 16438)
-- Name: ReviewTaskTypes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "ReviewTaskTypes" (
    "Id" smallint NOT NULL,
    "Name" character varying(50),
    "Description" character varying(300)
);


ALTER TABLE "ReviewTaskTypes" OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 16422)
-- Name: ReviewTasks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "ReviewTasks" (
    "Id" integer NOT NULL,
    "ReviewTaskTypeId" smallint,
    "CreationDate" timestamp(4) without time zone,
    "DeletionDate" timestamp(4) without time zone,
    "ReviewTaskStateId" smallint,
    "PostId" integer,
    "SuggestedEditId" integer,
    "CompletedByReviewTaskId" integer
);


ALTER TABLE "ReviewTasks" OWNER TO postgres;

--
-- TOC entry 201 (class 1259 OID 16495)
-- Name: Tags; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "Tags" (
    "Id" integer NOT NULL,
    "TagName" character varying(40),
    "Count" integer
);


ALTER TABLE "Tags" OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 16402)
-- Name: Users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "Users" (
    "Id" integer NOT NULL,
    "Reputation" integer,
    "CreationDate" timestamp(4) without time zone,
    "DisplayName" character varying(40),
    "LastAccessDate" timestamp(4) without time zone,
    "WebsiteUrl" character varying(200),
    "Location" character varying(100),
    "AboutMe" character varying,
    "Views" integer,
    "UpVotes" integer,
    "DownVotes" integer,
    "ProfileImageUrl" character varying(200),
    "EmailHash" character varying(32),
    "Age" integer,
    "AccountId" integer
);


ALTER TABLE "Users" OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 16419)
-- Name: VoteTypes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "VoteTypes" (
    "Id" smallint NOT NULL,
    "Name" character varying(50)
);


ALTER TABLE "VoteTypes" OWNER TO postgres;

--
-- TOC entry 193 (class 1259 OID 16443)
-- Name: Votes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE "Votes" (
    "Id" integer NOT NULL,
    "PostId" integer,
    "VoteTypeId" smallint,
    "UserId" integer,
    "CreationDate" timestamp(4) without time zone,
    "BountyAmount" integer
);


ALTER TABLE "Votes" OWNER TO postgres;

--
-- TOC entry 2071 (class 2604 OID 16614)
-- Name: PostHistory RevisionGUID; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostHistory" ALTER COLUMN "RevisionGUID" SET DEFAULT nextval('"PostHistory_RevisionGUID_seq"'::regclass);


--
-- TOC entry 2266 (class 0 OID 16416)
-- Dependencies: 188
-- Data for Name: Badges; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Badges" ("Id", "UserId", "Name", "Date", "Class", "TagBased") FROM stdin;
\.


--
-- TOC entry 2265 (class 0 OID 16410)
-- Dependencies: 187
-- Data for Name: Comments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Comments" ("Id", "PostId", "Score", "Text", "CreationDate", "UserDisplayName", "UserId") FROM stdin;
\.


--
-- TOC entry 2276 (class 0 OID 16476)
-- Dependencies: 198
-- Data for Name: PostFeedback; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "PostFeedback" ("Id", "PostId", "IsAnonymous", "VoteTypeId", "CreationDate") FROM stdin;
\.


--
-- TOC entry 2277 (class 0 OID 16481)
-- Dependencies: 199
-- Data for Name: PostHistory; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "PostHistory" ("Id", "PostHistoryTypeId", "PostId", "CreationDate", "UserId", "UserDisplayName", "Comment", "Text", "RevisionGUID") FROM stdin;
\.


--
-- TOC entry 2278 (class 0 OID 16489)
-- Dependencies: 200
-- Data for Name: PostHistoryTypes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "PostHistoryTypes" ("Id", "Name") FROM stdin;
\.


--
-- TOC entry 2289 (class 0 OID 0)
-- Dependencies: 202
-- Name: PostHistory_RevisionGUID_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('"PostHistory_RevisionGUID_seq"', 1, false);


--
-- TOC entry 2275 (class 0 OID 16468)
-- Dependencies: 197
-- Data for Name: PostNoticeTypes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "PostNoticeTypes" ("Id", "ClassId", "Name", "Body", "IsHidden", "Predefined", "PostNoticeDurationId") FROM stdin;
\.


--
-- TOC entry 2274 (class 0 OID 16460)
-- Dependencies: 196
-- Data for Name: PostNotices; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "PostNotices" ("Id", "PostId", "PostNoticeTypeId", "CreationDate", "DeletionDate", "ExpiryDate", "Body", "OwnerUserId", "DeletionUserId") FROM stdin;
\.


--
-- TOC entry 2272 (class 0 OID 16448)
-- Dependencies: 194
-- Data for Name: PostTags; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "PostTags" ("TagId", "PostId") FROM stdin;
\.


--
-- TOC entry 2273 (class 0 OID 16455)
-- Dependencies: 195
-- Data for Name: PostTypes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "PostTypes" ("Id", "Name") FROM stdin;
\.


--
-- TOC entry 2263 (class 0 OID 16394)
-- Dependencies: 185
-- Data for Name: Posts; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Posts" ("Id", "PostTypeId", "AcceptedAnswerId", "ParentId", "CreationDate", "DeletionDate", "Score", "ViewCount", "Body", "OwnerUserId", "OwnerDisplayName", "LastEditorUserId", "LastEditorDisplayName", "LastEditDate", "LastActivityDate", "Title", "Tags", "AnswerCount", "CommentCount", "FavoriteCount", "ClosedDate", "CommunityOwnedDate") FROM stdin;
\.


--
-- TOC entry 2269 (class 0 OID 16433)
-- Dependencies: 191
-- Data for Name: ReviewTaskStates; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "ReviewTaskStates" ("Id", "Name", "Description") FROM stdin;
\.


--
-- TOC entry 2270 (class 0 OID 16438)
-- Dependencies: 192
-- Data for Name: ReviewTaskTypes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "ReviewTaskTypes" ("Id", "Name", "Description") FROM stdin;
\.


--
-- TOC entry 2268 (class 0 OID 16422)
-- Dependencies: 190
-- Data for Name: ReviewTasks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "ReviewTasks" ("Id", "ReviewTaskTypeId", "CreationDate", "DeletionDate", "ReviewTaskStateId", "PostId", "SuggestedEditId", "CompletedByReviewTaskId") FROM stdin;
\.


--
-- TOC entry 2279 (class 0 OID 16495)
-- Dependencies: 201
-- Data for Name: Tags; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Tags" ("Id", "TagName", "Count") FROM stdin;
\.


--
-- TOC entry 2264 (class 0 OID 16402)
-- Dependencies: 186
-- Data for Name: Users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Users" ("Id", "Reputation", "CreationDate", "DisplayName", "LastAccessDate", "WebsiteUrl", "Location", "AboutMe", "Views", "UpVotes", "DownVotes", "ProfileImageUrl", "EmailHash", "Age", "AccountId") FROM stdin;
\.


--
-- TOC entry 2267 (class 0 OID 16419)
-- Dependencies: 189
-- Data for Name: VoteTypes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "VoteTypes" ("Id", "Name") FROM stdin;
\.


--
-- TOC entry 2271 (class 0 OID 16443)
-- Dependencies: 193
-- Data for Name: Votes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY "Votes" ("Id", "PostId", "VoteTypeId", "UserId", "CreationDate", "BountyAmount") FROM stdin;
\.


--
-- TOC entry 2084 (class 2606 OID 16428)
-- Name: Badges Badges_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Badges"
    ADD CONSTRAINT "Badges_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2080 (class 2606 OID 16430)
-- Name: Comments Comments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Comments"
    ADD CONSTRAINT "Comments_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2111 (class 2606 OID 16480)
-- Name: PostFeedback PostFeedback_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostFeedback"
    ADD CONSTRAINT "PostFeedback_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2119 (class 2606 OID 16493)
-- Name: PostHistoryTypes PostHistoryTypes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostHistoryTypes"
    ADD CONSTRAINT "PostHistoryTypes_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2115 (class 2606 OID 16488)
-- Name: PostHistory PostHistory_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostHistory"
    ADD CONSTRAINT "PostHistory_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2108 (class 2606 OID 16475)
-- Name: PostNoticeTypes PostNoticeTypes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostNoticeTypes"
    ADD CONSTRAINT "PostNoticeTypes_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2105 (class 2606 OID 16467)
-- Name: PostNotices PostNotices_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostNotices"
    ADD CONSTRAINT "PostNotices_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2100 (class 2606 OID 16459)
-- Name: PostTypes PostTypes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostTypes"
    ADD CONSTRAINT "PostTypes_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2076 (class 2606 OID 16401)
-- Name: Posts Posts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Posts"
    ADD CONSTRAINT "Posts_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2093 (class 2606 OID 16437)
-- Name: ReviewTaskStates ReviewTaskStates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "ReviewTaskStates"
    ADD CONSTRAINT "ReviewTaskStates_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2095 (class 2606 OID 16442)
-- Name: ReviewTaskTypes ReviewTaskTypes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "ReviewTaskTypes"
    ADD CONSTRAINT "ReviewTaskTypes_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2091 (class 2606 OID 16426)
-- Name: ReviewTasks ReviewTasks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "ReviewTasks"
    ADD CONSTRAINT "ReviewTasks_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2121 (class 2606 OID 16499)
-- Name: Tags Tags_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Tags"
    ADD CONSTRAINT "Tags_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2078 (class 2606 OID 16409)
-- Name: Users Users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Users"
    ADD CONSTRAINT "Users_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2087 (class 2606 OID 16432)
-- Name: VoteTypes VoteTypes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "VoteTypes"
    ADD CONSTRAINT "VoteTypes_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2097 (class 2606 OID 16447)
-- Name: Votes Votes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Votes"
    ADD CONSTRAINT "Votes_pkey" PRIMARY KEY ("Id");


--
-- TOC entry 2072 (class 1259 OID 16751)
-- Name: AcceptedAnswerId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "AcceptedAnswerId" ON "Posts" USING btree ("AcceptedAnswerId");


--
-- TOC entry 2101 (class 1259 OID 16728)
-- Name: DeletionUserId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "DeletionUserId" ON "PostNotices" USING btree ("DeletionUserId");


--
-- TOC entry 2073 (class 1259 OID 16762)
-- Name: LastEditorUserId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "LastEditorUserId" ON "Posts" USING btree ("LastEditorUserId");


--
-- TOC entry 2102 (class 1259 OID 16722)
-- Name: OwnerUserId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "OwnerUserId" ON "PostNotices" USING btree ("OwnerUserId");


--
-- TOC entry 2109 (class 1259 OID 16650)
-- Name: PostFeedback.PostId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "PostFeedback.PostId" ON "PostFeedback" USING btree ("PostId");


--
-- TOC entry 2113 (class 1259 OID 16677)
-- Name: PostHistoryTypeId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "PostHistoryTypeId" ON "PostHistory" USING btree ("PostHistoryTypeId");


--
-- TOC entry 2081 (class 1259 OID 16633)
-- Name: PostId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "PostId" ON "Comments" USING btree ("PostId");


--
-- TOC entry 2103 (class 1259 OID 16716)
-- Name: PostNoticeTypeId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "PostNoticeTypeId" ON "PostNotices" USING btree ("PostNoticeTypeId");


--
-- TOC entry 2074 (class 1259 OID 16745)
-- Name: PostTypeId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "PostTypeId" ON "Posts" USING btree ("PostTypeId");


--
-- TOC entry 2088 (class 1259 OID 16774)
-- Name: ReviewTaskStateId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "ReviewTaskStateId" ON "ReviewTasks" USING btree ("ReviewTaskStateId");


--
-- TOC entry 2089 (class 1259 OID 16768)
-- Name: ReviewTaskTypeId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "ReviewTaskTypeId" ON "ReviewTasks" USING btree ("ReviewTaskTypeId");


--
-- TOC entry 2098 (class 1259 OID 16734)
-- Name: TagId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "TagId" ON "PostTags" USING btree ("TagId");


--
-- TOC entry 2082 (class 1259 OID 16639)
-- Name: UserId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "UserId" ON "Comments" USING btree ("UserId");


--
-- TOC entry 2085 (class 1259 OID 16627)
-- Name: Users.Id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "Users.Id" ON "Badges" USING btree ("UserId");


--
-- TOC entry 2112 (class 1259 OID 16671)
-- Name: VoteTypeId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "VoteTypeId" ON "PostFeedback" USING btree ("VoteTypeId");


--
-- TOC entry 2116 (class 1259 OID 16698)
-- Name: postId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "postId" ON "PostHistory" USING btree ("PostId");


--
-- TOC entry 2106 (class 1259 OID 16710)
-- Name: postid; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX postid ON "PostNotices" USING btree ("PostId");


--
-- TOC entry 2117 (class 1259 OID 16704)
-- Name: userId; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "userId" ON "PostHistory" USING btree ("UserId");


--
-- TOC entry 2128 (class 2606 OID 16622)
-- Name: Badges Badges_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Badges"
    ADD CONSTRAINT "Badges_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "Users"("Id");


--
-- TOC entry 2126 (class 2606 OID 16651)
-- Name: Comments Comments_PostId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Comments"
    ADD CONSTRAINT "Comments_PostId_fkey" FOREIGN KEY ("PostId") REFERENCES "Posts"("Id");


--
-- TOC entry 2127 (class 2606 OID 16656)
-- Name: Comments Comments_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Comments"
    ADD CONSTRAINT "Comments_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "Users"("Id");


--
-- TOC entry 2141 (class 2606 OID 16661)
-- Name: PostFeedback PostFeedback_PostId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostFeedback"
    ADD CONSTRAINT "PostFeedback_PostId_fkey" FOREIGN KEY ("PostId") REFERENCES "Posts"("Id");


--
-- TOC entry 2142 (class 2606 OID 16666)
-- Name: PostFeedback PostFeedback_VoteTypeId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostFeedback"
    ADD CONSTRAINT "PostFeedback_VoteTypeId_fkey" FOREIGN KEY ("VoteTypeId") REFERENCES "VoteTypes"("Id");


--
-- TOC entry 2143 (class 2606 OID 16672)
-- Name: PostHistory PostHistory_PostHistoryTypeId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostHistory"
    ADD CONSTRAINT "PostHistory_PostHistoryTypeId_fkey" FOREIGN KEY ("PostHistoryTypeId") REFERENCES "PostHistoryTypes"("Id");


--
-- TOC entry 2144 (class 2606 OID 16693)
-- Name: PostHistory PostHistory_PostId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostHistory"
    ADD CONSTRAINT "PostHistory_PostId_fkey" FOREIGN KEY ("PostId") REFERENCES "Posts"("Id");


--
-- TOC entry 2145 (class 2606 OID 16699)
-- Name: PostHistory PostHistory_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostHistory"
    ADD CONSTRAINT "PostHistory_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "Users"("Id");


--
-- TOC entry 2140 (class 2606 OID 16723)
-- Name: PostNotices PostNotices_DeletionUserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostNotices"
    ADD CONSTRAINT "PostNotices_DeletionUserId_fkey" FOREIGN KEY ("DeletionUserId") REFERENCES "Users"("Id");


--
-- TOC entry 2139 (class 2606 OID 16717)
-- Name: PostNotices PostNotices_OwnerUserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostNotices"
    ADD CONSTRAINT "PostNotices_OwnerUserId_fkey" FOREIGN KEY ("OwnerUserId") REFERENCES "Users"("Id");


--
-- TOC entry 2137 (class 2606 OID 16705)
-- Name: PostNotices PostNotices_PostId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostNotices"
    ADD CONSTRAINT "PostNotices_PostId_fkey" FOREIGN KEY ("PostId") REFERENCES "Posts"("Id");


--
-- TOC entry 2138 (class 2606 OID 16711)
-- Name: PostNotices PostNotices_PostNoticeTypeId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostNotices"
    ADD CONSTRAINT "PostNotices_PostNoticeTypeId_fkey" FOREIGN KEY ("PostNoticeTypeId") REFERENCES "PostNoticeTypes"("Id");


--
-- TOC entry 2136 (class 2606 OID 16735)
-- Name: PostTags PostTags_PostId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostTags"
    ADD CONSTRAINT "PostTags_PostId_fkey" FOREIGN KEY ("PostId") REFERENCES "Posts"("Id");


--
-- TOC entry 2135 (class 2606 OID 16729)
-- Name: PostTags PostTags_TagId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "PostTags"
    ADD CONSTRAINT "PostTags_TagId_fkey" FOREIGN KEY ("TagId") REFERENCES "Tags"("Id");


--
-- TOC entry 2123 (class 2606 OID 16746)
-- Name: Posts Posts_AcceptedAnswerId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Posts"
    ADD CONSTRAINT "Posts_AcceptedAnswerId_fkey" FOREIGN KEY ("AcceptedAnswerId") REFERENCES "PostFeedback"("Id");


--
-- TOC entry 2125 (class 2606 OID 16757)
-- Name: Posts Posts_LastEditorUserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Posts"
    ADD CONSTRAINT "Posts_LastEditorUserId_fkey" FOREIGN KEY ("LastEditorUserId") REFERENCES "Users"("Id");


--
-- TOC entry 2124 (class 2606 OID 16752)
-- Name: Posts Posts_OwnerUserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Posts"
    ADD CONSTRAINT "Posts_OwnerUserId_fkey" FOREIGN KEY ("OwnerUserId") REFERENCES "Users"("Id");


--
-- TOC entry 2122 (class 2606 OID 16740)
-- Name: Posts Posts_PostTypeId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Posts"
    ADD CONSTRAINT "Posts_PostTypeId_fkey" FOREIGN KEY ("PostTypeId") REFERENCES "PostTypes"("Id");


--
-- TOC entry 2131 (class 2606 OID 16775)
-- Name: ReviewTasks ReviewTasks_PostId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "ReviewTasks"
    ADD CONSTRAINT "ReviewTasks_PostId_fkey" FOREIGN KEY ("PostId") REFERENCES "Posts"("Id");


--
-- TOC entry 2130 (class 2606 OID 16769)
-- Name: ReviewTasks ReviewTasks_ReviewTaskStateId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "ReviewTasks"
    ADD CONSTRAINT "ReviewTasks_ReviewTaskStateId_fkey" FOREIGN KEY ("ReviewTaskStateId") REFERENCES "ReviewTaskStates"("Id");


--
-- TOC entry 2129 (class 2606 OID 16763)
-- Name: ReviewTasks ReviewTasks_ReviewTaskTypeId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "ReviewTasks"
    ADD CONSTRAINT "ReviewTasks_ReviewTaskTypeId_fkey" FOREIGN KEY ("ReviewTaskTypeId") REFERENCES "ReviewTaskTypes"("Id");


--
-- TOC entry 2132 (class 2606 OID 16780)
-- Name: Votes Votes_PostId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Votes"
    ADD CONSTRAINT "Votes_PostId_fkey" FOREIGN KEY ("PostId") REFERENCES "Posts"("Id");


--
-- TOC entry 2134 (class 2606 OID 16790)
-- Name: Votes Votes_UserId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Votes"
    ADD CONSTRAINT "Votes_UserId_fkey" FOREIGN KEY ("UserId") REFERENCES "Users"("Id");


--
-- TOC entry 2133 (class 2606 OID 16785)
-- Name: Votes Votes_VoteTypeId_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Votes"
    ADD CONSTRAINT "Votes_VoteTypeId_fkey" FOREIGN KEY ("VoteTypeId") REFERENCES "VoteTypes"("Id");


-- Completed on 2017-12-07 23:26:12

--
-- PostgreSQL database dump complete
--

