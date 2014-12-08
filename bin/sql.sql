
SHOW DATABASES;

SHOW TABLES;

explain users;

EXPLAIN users;

EXPLAIN locations;


EXPLAIN wp_posts;

EXPLAIN wp_postmeta;

EXPLAIN wp_comments;

EXPLAIN wp_commentmeta;

EXPLAIN wp_ratings



-- UPDATE `locations` SET `googleID` = 'f41f1069eaf74a6fdb22561f37a40adf01de8dd0', `googleReference` = 'CkQxAAAADcJiIAokK8DI1Ib7zolRjkDgpBkHpwRQEiwZCBv7SGNcbnqflEq4S6qQHDZuuFI3X4l8lBFrRgyhcm750UDFQRIQPDUDqrotYjDDoiwnJSNBYxoUCd0rfXKXSIuZS1j5fSwnbv-yA-E' WHERE `id` = 520


SELECT id, name, deleted, googleID, googleReference FROM locations WHERE id IN (521, 522);

SELECT * FROM locations WHERE id > 522;

--UPDATE locations SET `deleted` = 1, deletedBy = 1, deleteDate = NOW() WHERE id IN (521, 522);


SELECT * FROM wp_links;




SELECT * FROM locationImages WHERE locationid = 523;


SELECT * FROM countries;


SELECT `iso2`, `short_name`
FROM (`countries`)
ORDER BY `short_name` asc

SELECT * FROM wp_term_relationships;

SELECT * FROM wp_posts ORDER BY ID DESC LIMIT 100;



SELECT id, post_content, post_name,  post_title FROM wp_posts WHERE post_type = 'place'

SELECT id, post_content, post_name,  post_title FROM wp_posts WHERE post_type = 'video'

SELECT * FROM wp_comments;

select * FROM wp_claim;

-- DELETE FROM wp_posts WHERE ID = 4850;

SELECT * FROM wp_usermeta WHERE user_id = 10;

SELECT * FROM wp_usermeta WHERE meta_key = 'facebookID';

SELECT * FROM wp_usermeta WHERE umeta_id IN (136, 137);

-- DELETE FROM wp_usermeta WHERE umeta_id IN (149);

SELECT * FROm wp_posts WHERE post_author = 4;

SELECT * FROM wp_posts WHERE post_author = 2;

--100,113

UPDATE wp_posts SET post_author = 4 WHERE ID IN(100, 113)


SELECT * FROM wp_ratings
WHERE

SELECT * FROM wp_commentmeta LIMIT 100;

SELECT * FROM wp_geotheme_custom_post_fields;
SELECT * FROM wp_gt_moderation;

SELECT * FROM wp_options LIMIT 100;

SELE

select * FROM wp_options WHERE option_value LIKE '%karate.local%'

-- UPDATE wp_options SET option_value = 'http://karate.sportsasylums.com' WHERE option_name = 'siteurl';

-- UPDATE wp_posts SET post_author = 4 WHERE ID IN (3757,4846)

SELECT * FROM wp_comments
WHERE comment_ID  = 3;

SELECT id, post_content, post_title FROM wp_posts WHERE post_type = 'place';


SELECT DISTINCT post_type FROM wp_posts;

SELECT ID FROM wp_posts WHERE post_type = 'attachment' AND post_parent = 3757

SELECT * FROM wp_posts WHERE post_type = 'attachment'


SELECT * FROM wp_postmeta WHERE post_id = 4848


SELECT * FROM wp_postmeta WHERE meta_key LIKE '%position%'

explain wp_posts;

SELECT * FROM wp_posts WHERE ID = 3757;


SELECT * FROM wp_postmeta WHERE post_id = 3757;

SELECT * FROM wp_postmeta WHERE post_id = 4846;

SELECT * FROM wp_posts WHERE ID = 4846;

SELECT * FROM wp_postmeta WHERE meta_key = 'IMAGE'



-- CREATEs dev db

-- CREATE DATABASE karate_wp_dev;

-- CREATE USER 'wgallios'@'localhost' IDENTIFIED BY 'kornman1';

-- GRANT ALL PRIVILEGES ON * . * TO 'wgallios'@'localhost';


SELECT * FROM wp_postmeta WHERE meta_key = 'claimed'


EXPLAIN wp_options;

SELECT * FROM wp_options;


SELECT * FROM wp_options WHERE option_value LIKE '%http%'


SELECT * FROM wp_options WHERE option_id IN (1,36)

-- UPDATE wp_options SET option_value = 'http://karate.local/wordpress/' WHERE option_id IN (1, 36)

EXPLAIN wp_postmeta;

SELECT * from wp_postmeta LIMIT 100;

explain
SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key IN ('geo_latitude', 'geo_longitude')


explain
SELECT post_id FROM wp_postmeta WHERE meta_key = 'geo_latitude'


SELECT * FROM wp_pos

EXPLAIN wp_


SELECT * FROM wp_comments;

SELECT * FROM wp_ratings;


explain wp_ratings;

-- DELETE FROM wp_comments WHERE comment_ID >= 4;
-- DELETE FROM wp_ratings WHERE rating_id = 4;


SELECT * FROM wp_users;


-- INSERT INTO `wp_usermeta` (`user_id`, `meta_key`, `meta_value`) VALUES (10, 'facebookID', '100007989211265')

SELECT * FROM wp_usermeta WHERE user_id = 4;

SELECT user_id FROM wp_usermeta WHERE meta_key = 'facebookID'

SELECT * FROM wp_usermeta WHERE meta_value LIKE '%karate.local%'

SELECT * FROM wp_options;


-- UPDATE wp_options SET option_value = 'http://karata'
