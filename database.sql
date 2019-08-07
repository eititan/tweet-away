create table student.eititan_feed
(
    id           int auto_increment
        primary key,
    username     varchar(256)                        null,
    post_message varchar(2048)                       null,
    posted_on    timestamp default CURRENT_TIMESTAMP null
);
