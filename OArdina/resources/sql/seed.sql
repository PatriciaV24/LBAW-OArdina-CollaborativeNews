DROP SCHEMA IF EXISTS lbaw2163 CASCADE;
CREATE SCHEMA lbaw2163;
SET search_path TO "lbaw2163"; 

DROP TABLE IF EXISTS faq CASCADE;
DROP TABLE IF EXISTS comment_notification CASCADE;
DROP TABLE IF EXISTS vote_notification CASCADE;
DROP TABLE IF EXISTS follow_notification CASCADE;
DROP TABLE IF EXISTS vote CASCADE;
DROP TABLE IF EXISTS unban_appeal CASCADE;
DROP TABLE IF EXISTS report_content CASCADE;
DROP TABLE IF EXISTS report_users CASCADE;
DROP TABLE IF EXISTS request CASCADE;
DROP TABLE IF EXISTS news_tag CASCADE;
DROP TABLE IF EXISTS news CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS ban CASCADE;
DROP TABLE IF EXISTS content CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS follow CASCADE;
DROP TABLE IF EXISTS users CASCADE;

DROP TYPE IF EXISTS GENDER_TYPE CASCADE;
DROP TYPE IF EXISTS STATUS_TYPE CASCADE;

CREATE TYPE GENDER_TYPE AS ENUM('m','f','n');
CREATE TYPE STATUS_TYPE AS ENUM('approved', 'rejected');

CREATE TABLE users(
    id INTEGER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
    username VARCHAR(20) NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    photo TEXT,
    contact INTEGER NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT false,
    is_banned BOOLEAN NOT NULL DEFAULT false,
    is_deleted BOOLEAN NOT NULL DEFAULT false,
    PRIMARY KEY(id)
);

CREATE TABLE follow(
    follower_id INTEGER NOT NULL,
    users_id INTEGER NOT NULL,
    PRIMARY KEY(follower_id, users_id),
    CONSTRAINT fk_follower_id
        FOREIGN KEY(follower_id)
            REFERENCES users (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_users_id
        FOREIGN KEY(users_id)
            REFERENCES users (id)
            ON DELETE CASCADE
);

CREATE TABLE ban(
    id INTEGER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
    users_id INTEGER NOT NULL,
    admin_id INTEGER NOT NULL, /*CHECK users.is_admin == true with triggers*/
    start_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    end_date TIMESTAMP WITH TIME ZONE  DEFAULT NULL CHECK (end_date > start_date),
    reason TEXT NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_admin_id
        FOREIGN KEY(admin_id)
            REFERENCES users (id)
            ON DELETE CASCADE,
     CONSTRAINT fk_users_id
        FOREIGN KEY(users_id)
            REFERENCES users (id)
            ON DELETE CASCADE

);

CREATE TABLE content (
    id INTEGER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
    author_id INTEGER NOT NULL,
    body TEXT NOT NULL,
    is_edited BOOLEAN DEFAULT FALSE,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    nr_votes INTEGER NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    CONSTRAINT fk_author_id
        FOREIGN KEY(author_id)
            REFERENCES users (id)
            ON DELETE CASCADE
);

CREATE TABLE tag (
    id INTEGER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
    name VARCHAR(40) NOT NULL UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE news (
    content_id INTEGER NOT NULL,
    title TEXT NOT NULL,
    image TEXT,
    trending_score INTEGER NOT NULL DEFAULT 0,
    nr_comments INTEGER NOT NULL DEFAULT 0,
    PRIMARY KEY(content_id),
    CONSTRAINT fk_content_id
        FOREIGN KEY(content_id)
            REFERENCES content (id)
            ON DELETE CASCADE

);

CREATE TABLE news_tag (
    news_id INTEGER,
    tag_id INTEGER,
    PRIMARY KEY(news_id, tag_id),
    CONSTRAINT fk_news_id
        FOREIGN KEY(news_id)
            REFERENCES  news (content_id)
            ON DELETE CASCADE,
    CONSTRAINT fk_tag_id
        FOREIGN KEY(tag_id)
            REFERENCES  tag (id)
            ON DELETE CASCADE
);

CREATE TABLE comment (
    content_id INTEGER NOT NULL,
    news_id INTEGER NOT NULL,
    reply_to_id INTEGER,
    level INTEGER DEFAULT 0,
    PRIMARY KEY(content_id),
    CONSTRAINT fk_content_id
        FOREIGN KEY(content_id)
            REFERENCES content (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_news_id
        FOREIGN KEY(news_id)
            REFERENCES news (content_id)
            ON DELETE CASCADE,
    CONSTRAINT fk_reply_to_id
        FOREIGN KEY(reply_to_id)
            REFERENCES comment (content_id)
            ON DELETE CASCADE
);

CREATE TABLE request (
   id INTEGER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
   from_id INTEGER NOT NULL,
   admin_id INTEGER, /* CHECK admin_id.is_admin == true WITH TRIGGERS*/
   reason TEXT NOT NULL,
   creation_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
   status STATUS_TYPE,
   revision_date TIMESTAMP WITH TIME ZONE CHECK (revision_date > creation_date),
   PRIMARY KEY(id),
   CONSTRAINT fk_from_id
        FOREIGN KEY(from_id)
            REFERENCES users (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_admin_id
        FOREIGN KEY(admin_id)
            REFERENCES users (id)
            ON DELETE CASCADE
);

CREATE TABLE report_users (
    request_id INTEGER NOT NULL,
    to_users_id INTEGER NOT NULL,
    PRIMARY KEY(request_id),
    CONSTRAINT fk_request_id
        FOREIGN KEY(request_id)
            REFERENCES request (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_to_users_id
        FOREIGN KEY(to_users_id)
            REFERENCES users (id)
            ON DELETE CASCADE
);

CREATE TABLE report_content (
    request_id INTEGER NOT NULL,
    to_content_id INTEGER,
    PRIMARY KEY(request_id),
    CONSTRAINT fk_request_id
        FOREIGN KEY(request_id)
            REFERENCES request (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_to_content_id
        FOREIGN KEY(to_content_id)
            REFERENCES content (id)
            ON DELETE SET NULL
);

CREATE TABLE unban_appeal (
    request_id INTEGER NOT NULL,
    ban_id INTEGER NOT NULL,
    PRIMARY KEY(request_id),
    CONSTRAINT fk_request_id
        FOREIGN KEY(request_id)
            REFERENCES request (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_ban_id
        FOREIGN KEY(ban_id)
            REFERENCES ban (id)
            ON DELETE CASCADE
);

CREATE TABLE vote (
    users_id INTEGER,
    content_id INTEGER, /*CHECK content.author_id != users_id */
    value INTEGER NOT NULL,
    PRIMARY KEY(users_id, content_id),
    CONSTRAINT fk_users_id
        FOREIGN KEY(users_id)
            REFERENCES users (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_content_id
        FOREIGN KEY(content_id)
            REFERENCES content (id)
            ON DELETE CASCADE
);

CREATE TABLE follow_notification (
    id INTEGER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
    follower_id INTEGER NOT NULL,
    users_id INTEGER NOT NULL,
    is_new BOOLEAN NOT NULL DEFAULT true,
    creation_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(follower_id, users_id),
    CONSTRAINT fk_follower_id
        FOREIGN KEY(follower_id)
            REFERENCES users (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_users_id
        FOREIGN KEY(users_id)
            REFERENCES users (id)
            ON DELETE CASCADE
);

CREATE TABLE vote_notification (
    id INTEGER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
    voter_id INTEGER NOT NULL,
    content_id INTEGER NOT NULL,
    author_id INTEGER NOT NULL,
    is_new BOOLEAN NOT NULL DEFAULT true,
    creation_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(voter_id, content_id, author_id),
    CONSTRAINT fk_voter_id
        FOREIGN KEY(voter_id)
            REFERENCES users (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_content_id
        FOREIGN KEY(content_id)
            REFERENCES content (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_author_id
        FOREIGN KEY(author_id)
            REFERENCES users (id)
            ON DELETE CASCADE
);

CREATE TABLE comment_notification (
    id INTEGER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
    users_id INTEGER NOT NULL,
    comment_id INTEGER NOT NULL,
    is_new BOOLEAN NOT NULL DEFAULT true,
    creation_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(users_id, comment_id),
    CONSTRAINT fk_users_id
        FOREIGN KEY(users_id)
            REFERENCES users (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_comment_id
        FOREIGN KEY(comment_id)
            REFERENCES comment (content_id)
            ON DELETE CASCADE
);

CREATE TABLE faq (
    id INTEGER GENERATED ALWAYS AS IDENTITY (START WITH 1 INCREMENT BY 1),
    question TEXT NOT NULL UNIQUE,
    answer TEXT NOT NULL,
    PRIMARY KEY(id)
);


/**
 *   Indices
 */
DROP INDEX IF EXISTS is_banned_idx;
DROP INDEX IF EXISTS is_deleted_idx;
DROP INDEX IF EXISTS trending_score_idx;
DROP INDEX IF EXISTS content_date_idx;
DROP INDEX IF EXISTS content_vote_idx;
DROP INDEX IF EXISTS search_users_idx;
DROP INDEX IF EXISTS content_author_idx;

CREATE INDEX is_banned_idx ON users USING hash(is_banned);
CREATE INDEX is_deleted_idx ON users USING hash(is_deleted);
CREATE INDEX trending_score_idx ON news USING btree(trending_score);
CREATE INDEX content_date_idx ON content USING btree(date);
CREATE INDEX content_vote_idx ON content USING btree(nr_votes);
CREATE INDEX content_author_idx ON content USING hash(author_id);

ALTER TABLE news ADD COLUMN search TSVECTOR;
CREATE INDEX search_news_idx ON news USING GIST (search);
ALTER TABLE users ADD COLUMN search TSVECTOR;
CREATE INDEX search_users_idx ON users USING GIN (search);


/**
 *  Triggers
 */

--Trigger 1 - Ensure that only admins can approve / reject requests
DROP FUNCTION IF EXISTS action_is_from_admin() CASCADE;
DROP TRIGGER IF EXISTS trigger_is_from_admin ON request;

CREATE OR REPLACE FUNCTION action_is_from_admin() RETURNS TRIGGER AS
    $BODY$
        BEGIN
            IF NOT (SELECT is_admin FROM users WHERE users.id = new.admin_id) THEN
                RAISE EXCEPTION 'There must be a admin to update a request status.';
            END IF;
            RETURN NEW;
        END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER trigger_is_from_admin
    BEFORE UPDATE OF status ON request
    FOR EACH ROW
    EXECUTE PROCEDURE action_is_from_admin();


--Trigger 2 - A user cannot follow himself
DROP FUNCTION IF EXISTS follow_self() CASCADE;
DROP TRIGGER IF EXISTS follow_self ON follow;

CREATE OR REPLACE FUNCTION follow_self() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        IF NEW.follower_id = NEW.users_id THEN
            RAISE EXCEPTION 'An user cannot follow himself';
        END IF;
        RETURN New;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER follow_self
    BEFORE INSERT ON follow
    FOR EACH ROW
    EXECUTE PROCEDURE follow_self();

--Trigger 3 - Maximum of 5 reputation points per day from voting
DROP FUNCTION IF EXISTS maximum_rep_day() CASCADE;
DROP TRIGGER IF EXISTS maximum_rep_day ON vote;

CREATE OR REPLACE FUNCTION maximum_rep_day() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        IF CURRENT_DATE = (SELECT last_day_of_vote FROM users u WHERE new.users_id = u.id) THEN
            IF 5 > (SELECT count_last_day_rep FROM users u WHERE new.users_id = u.id) THEN
                UPDATE users u
                SET count_last_day_rep = count_last_day_rep + 1,
                    reputation = reputation + 1
                WHERE new.users_id = u.id;
            END IF;
        ELSE
            UPDATE users u
            SET last_day_of_vote = CURRENT_DATE,
                count_last_day_rep = 1,
                reputation = reputation + 1
            WHERE new.users_id = u.id;
        END IF;
        RETURN New;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER maximum_rep_day
    BEFORE INSERT ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE maximum_rep_day();


--Trigger 4 - The minimum age for a user to be registers is 13 years old


--Trigger 5 - An Authenticated User can't vote on his own news/comments
DROP FUNCTION IF EXISTS vote_self() CASCADE;
DROP TRIGGER IF EXISTS vote_self ON vote;

CREATE OR REPLACE FUNCTION vote_self() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        IF new.users_id = (SELECT author_id FROM content WHERE new.content_id = content.id) THEN
            RAISE EXCEPTION 'A user cannot vote in his own content';
        END IF;
        RETURN new;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER vote_self
    BEFORE INSERT ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE vote_self();

--Trigger 6 - Deal with Request
DROP FUNCTION IF EXISTS deal_with_request() CASCADE;
DROP TRIGGER IF EXISTS deal_with_request ON request;

CREATE OR REPLACE FUNCTION deal_with_request() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        IF new.status='approved' THEN
            -- UNBAN APPEAL REQUEST
            IF EXISTS (SELECT * FROM unban_appeal, users WHERE new.id=request_id AND users.id=new.from_id) THEN
                UPDATE users SET is_banned=false WHERE new.from_id=users.id;
                IF EXISTS (SELECT * FROM ban WHERE ban.id IN (SELECT ban_id FROM unban_appeal WHERE new.id=request_id)) THEN
                UPDATE ban SET end_date=NOW() WHERE ban.id IN (SELECT ban_id FROM unban_appeal WHERE new.id=request_id);
                END IF;
            END IF;
            new.revision_date=NOW();
        END IF;
        RETURN new;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER deal_with_request
    AFTER UPDATE ON request
    FOR EACH ROW
    EXECUTE PROCEDURE deal_with_request();


--Trigger 7 - Increase Number of Comments in a News Post
DROP FUNCTION IF EXISTS increase_comments() CASCADE;
DROP TRIGGER IF EXISTS increase_comments ON comment;

CREATE OR REPLACE FUNCTION increase_comments() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        UPDATE news SET nr_comments = news.nr_comments + 1
        WHERE new.news_id=news.content_id;

        IF new.reply_to_id IS NOT NULL THEN
            UPDATE comment SET level = ((SELECT c2.level FROM comment c2 WHERE c2.content_id = new.reply_to_id) + 1)
            WHERE comment.content_id = new.content_id;
        END IF;
        RETURN new;
    END

    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER increase_comments
    AFTER INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE increase_comments();


--Trigger 8 - Decrease Number of Comments in a News Post
DROP FUNCTION IF EXISTS decrease_comments() CASCADE;
DROP TRIGGER IF EXISTS decrease_comments ON comment;

CREATE OR REPLACE FUNCTION decrease_comments() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        UPDATE news SET nr_comments = nr_comments - 1
        WHERE old.news_id = content_id;
        RETURN old;
    END

    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER decrease_comments
    AFTER DELETE ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE decrease_comments();

--Trigger 9 - Increase Trending Score and Number of Votes with a Vote
DROP FUNCTION IF EXISTS increase_ts_and_votes() CASCADE;
DROP TRIGGER IF EXISTS increase_ts_and_votes ON vote;

CREATE OR REPLACE FUNCTION increase_ts_and_votes() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        UPDATE news
        SET trending_score = trending_score + new.value
        WHERE news.content_id=new.content_id;

        UPDATE content
        SET nr_votes = nr_votes + new.value
        WHERE content.id=new.content_id;

        RETURN new;
    END

    $BODY$
LANGUAGE plpgsql;


CREATE TRIGGER increase_ts_and_votes
    AFTER INSERT ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE increase_ts_and_votes();


--Trigger 10 - Decrease Trending Score and Number of Votes with a Vote
DROP FUNCTION IF EXISTS decrease_ts_and_votes() CASCADE;
DROP TRIGGER IF EXISTS decrease_ts_and_votes ON vote;

CREATE OR REPLACE FUNCTION decrease_ts_and_votes() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        UPDATE news
        SET trending_score = news.trending_score - old.value
        WHERE old.content_id=news.content_id ;

        UPDATE content
        SET nr_votes = nr_votes - old.value
        WHERE old.content_id = content.id ;

        UPDATE users
        SET reputation = reputation - 1
        WHERE new.users_id = users.id;

        RETURN old;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER decrease_ts_and_votes
    AFTER DELETE ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE decrease_ts_and_votes();



--Update reputação do owner
DROP FUNCTION IF EXISTS update_reputation() CASCADE;
DROP TRIGGER IF EXISTS update_reputation ON vote;

CREATE OR REPLACE FUNCTION update_reputation() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        UPDATE users
        SET reputation = reputation + (new.value-old.value)
        from content
        WHERE new.content_id=content.id AND content.author_id=users.id;
        RETURN new;
    END

    $BODY$
LANGUAGE plpgsql;


CREATE TRIGGER update_reputation
    AFTER UPDATE ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE update_reputation();



--Diminuir reputação do owner
DROP FUNCTION IF EXISTS decrease_reputation() CASCADE;
DROP TRIGGER IF EXISTS decrease_reputation ON vote;

CREATE OR REPLACE FUNCTION decrease_reputation() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        UPDATE users
        SET reputation = reputation - old.value
        from content
        WHERE old.content_id=content.id AND content.author_id=users.id;
        RETURN old;
    END

    $BODY$
LANGUAGE plpgsql;


CREATE TRIGGER decrease_reputation
    before DELETE ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE decrease_reputation();



--Aumentar reputação do owner
DROP FUNCTION IF EXISTS increase_reputation() CASCADE;
DROP TRIGGER IF EXISTS increase_reputation ON vote;

CREATE OR REPLACE FUNCTION increase_reputation() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        UPDATE users
        SET reputation = reputation + new.value --and last_day_of_vote=CURRENT_DATE
        from content
        WHERE new.content_id=content.id AND content.author_id=users.id;
        RETURN new;
    END

    $BODY$
LANGUAGE plpgsql;


CREATE TRIGGER increase_reputation
    AFTER INSERT ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE increase_reputation();




--Trigger 11 -A trigger is needed to create a new follow notification when an user starts following another.
DROP FUNCTION IF EXISTS create_follow_notification() CASCADE;
DROP TRIGGER IF EXISTS create_follow_notification ON follow;

CREATE OR REPLACE FUNCTION create_follow_notification() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        INSERT INTO follow_notification (follower_id, users_id, is_new, creation_date)
        VALUES (new.follower_id, new.users_id, true, now());

        RETURN new;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER create_follow_notification
    AFTER INSERT ON follow
    FOR EACH ROW
    EXECUTE PROCEDURE create_follow_notification();


-- Trigger 12 - Create Vote Notification
DROP FUNCTION IF EXISTS create_vote_notification() CASCADE;
DROP TRIGGER IF EXISTS create_vote_notification ON vote;

CREATE OR REPLACE FUNCTION create_vote_notification() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        INSERT INTO vote_notification(voter_id, content_id, author_id, is_new, creation_date)
            SELECT new.users_id, c.id, c.author_id, true, now()
            FROM content c
            WHERE new.content_id = c.id;
        RETURN new;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER create_vote_notification
    AFTER INSERT ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE create_vote_notification();


-- Trigger 12 - Delete Vote Notification
DROP FUNCTION IF EXISTS delete_vote_notification() CASCADE;
DROP TRIGGER IF EXISTS delete_vote_notification ON vote;

CREATE OR REPLACE FUNCTION delete_vote_notification() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        DELETE FROM vote_notification
            WHERE vote_notification.voter_id=old.users_id
            and old.content_id = vote_notification.content_id;
        RETURN old;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_vote_notification
    AFTER DELETE ON vote
    FOR EACH ROW
    EXECUTE PROCEDURE delete_vote_notification();


-- Trigger  - Delete Follow Notification
DROP FUNCTION IF EXISTS delete_follow_notification() CASCADE;
DROP TRIGGER IF EXISTS delete_follow_notification ON follow;

CREATE OR REPLACE FUNCTION delete_follow_notification() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        DELETE FROM follow_notification
            WHERE follow_notification.users_id=old.users_id
            and old.follower_id = follow_notification.follower_id;
        RETURN old;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_follow_notification
    AFTER DELETE ON follow
    FOR EACH ROW
    EXECUTE PROCEDURE delete_follow_notification();

--Trigger 13 - Create Comment Notification
DROP FUNCTION IF EXISTS create_comment_notification() CASCADE;
DROP TRIGGER IF EXISTS create_comment_notification ON comment;

CREATE OR REPLACE FUNCTION create_comment_notification() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        IF (SELECT author_id FROM content WHERE NEW.news_id = id) <> (SELECT author_id FROM content WHERE NEW.content_id = id) THEN
            INSERT INTO comment_notification(users_id, comment_id, is_new, creation_date)
                SELECT news.author_id, NEW.content_id, true, now()
                FROM content news
                WHERE NEW.news_id = news.id;
        END IF;

        IF NEW.reply_to_id IS NOT NULL AND (SELECT author_id FROM content WHERE NEW.content_id = id) <> (SELECT author_id FROM content WHERE NEW.reply_to_id = id) THEN
            INSERT INTO comment_notification(users_id, comment_id, is_new, creation_date)
            VALUES (
                (SELECT author_id FROM content WHERE content.id = new.reply_to_id),
                NEW.content_id,
                true,
                now()
            );
        END IF;
        RETURN new;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER create_comment_notification
    AFTER INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE create_comment_notification();


--Trigger 14 - Update TSVECTOR (News)
DROP FUNCTION IF EXISTS news_search_update() CASCADE;
DROP TRIGGER IF EXISTS news_search_update ON news;

CREATE OR REPLACE FUNCTION news_search_update() RETURNS TRIGGER AS
    $BODY$
    DECLARE news_body TEXT = (SELECT c.body FROM content c WHERE c.id = new.content_id);
    BEGIN
        IF TG_OP = 'INSERT' THEN
            NEW.search =
                setweight(to_tsvector(coalesce(NEW.title, '')), 'B') ||
                setweight(to_tsvector(coalesce(news_body, '')), 'C');
        END IF;
        IF TG_OP = 'UPDATE' THEN
            IF NEW.title <> OLD.title THEN
                NEW.search =
                    setweight(to_tsvector(coalesce(NEW.title, '')), 'B') ||
                    setweight(to_tsvector(coalesce(news_body, '')), 'C');
            END IF;
        END IF;

        RETURN NEW;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER news_search_update
    BEFORE INSERT OR UPDATE ON news
    FOR EACH ROW
    EXECUTE PROCEDURE news_search_update();


--Trigger 15 - Update TSVECTOR (News)
DROP FUNCTION IF EXISTS news_body_search_update() CASCADE;
DROP TRIGGER IF EXISTS news_body_search_update ON content;

CREATE OR REPLACE FUNCTION news_body_search_update() RETURNS TRIGGER AS
    $BODY$
    DECLARE news_title TEXT = (SELECT title FROM news WHERE news.content_id = new.id);
    BEGIN
        IF news_title IS NOT NULL THEN
            IF NEW.body <> OLD.body THEN
                UPDATE news
                SET search =
                        setweight(to_tsvector(coalesce(news_title, '')), 'B') ||
                        setweight(to_tsvector(coalesce(NEW.body, '')), 'C')
                WHERE news.content_id = new.id;
            END IF;
        END IF;

        RETURN NEW;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER news_body_search_update
    BEFORE UPDATE ON content
    FOR EACH ROW
    EXECUTE PROCEDURE news_body_search_update();



--Trigger 16 - Update TSVECTOR (Users)
DROP FUNCTION IF EXISTS users_search_update() CASCADE;
DROP TRIGGER IF EXISTS users_search_update ON users;

CREATE OR REPLACE FUNCTION users_search_update() RETURNS TRIGGER AS
    $BODY$
    BEGIN
        IF TG_OP = 'INSERT' THEN
            NEW.search = setweight(to_tsvector(coalesce(NEW.username, '')), 'A');
        END IF;
        IF TG_OP = 'UPDATE' THEN
            IF NEW.username <> OLD.username THEN
                NEW.search =
                    setweight(to_tsvector(coalesce(NEW.username, '')), 'A');
            END IF;
        END IF;
        RETURN NEW;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER cnews_search_update
    BEFORE INSERT OR UPDATE ON users
    FOR EACH ROW
    EXECUTE PROCEDURE users_search_update();


--Trigger 17 - Update TSVECTOR (News)
DROP FUNCTION IF EXISTS tags_insert_search_update() CASCADE;
DROP TRIGGER IF EXISTS tags_insert_search_update ON content;

CREATE OR REPLACE FUNCTION tags_insert_search_update() RETURNS TRIGGER AS
    $BODY$
    DECLARE tag TEXT = (SELECT name FROM tag WHERE tag.id = new.tag_id);
    BEGIN
        UPDATE news
        SET search = search || setweight(to_tsvector(coalesce(tag, '')), 'A')
        WHERE news.content_id = new.news_id;

        RETURN NEW;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER tags_insert_search_update
    AFTER INSERT ON news_tag
    FOR EACH ROW
    EXECUTE PROCEDURE tags_insert_search_update();

--Trigger 18 - Update TSVECTOR (News)
DROP FUNCTION IF EXISTS tags_delete_search_update() CASCADE;
DROP TRIGGER IF EXISTS tags_delete_search_update ON content;

CREATE OR REPLACE FUNCTION tags_delete_search_update() RETURNS TRIGGER AS
    $BODY$
    DECLARE tag TEXT = (SELECT name FROM tag WHERE tag.id = old.tag_id);
    BEGIN
        UPDATE news
        SET search = ts_delete(search, coalesce(tag, ''))
        WHERE news.content_id = old.news_id;

        RETURN old;
    END
    $BODY$
LANGUAGE plpgsql;

CREATE TRIGGER tags_delete_search_update
    AFTER DELETE ON news_tag
    FOR EACH ROW
    EXECUTE PROCEDURE tags_delete_search_update();