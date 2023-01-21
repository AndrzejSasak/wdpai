CREATE TABLE category (
                          id_category SERIAL PRIMARY KEY,
                          category_name varchar(255) NOT NULL
);

CREATE TABLE user_details (
                              id_user_details SERIAL PRIMARY KEY,
                              name VARCHAR(255) NOT NULL,
                              surname VARCHAR(255) NOT NULL
);

CREATE TABLE role (
                      id_role SERIAL PRIMARY KEY,
                      role varchar(255) NOT NULL
);

CREATE TABLE _user (
                       id_user SERIAL PRIMARY KEY,
                       email VARCHAR(255) NOT NULL,
                       password VARCHAR(255) NOT NULL,
                       enabled BOOL NOT NULL,
                       created_at timestamp NOT NULL,
                       id_user_details INT,
                       id_role INT,
                       CONSTRAINT fk_user_details
                           FOREIGN KEY(id_user_details)
                               REFERENCES user_details(id_user_details)
                               on update cascade on delete cascade,
                       CONSTRAINT fk_role
                           FOREIGN KEY(id_role)
                               REFERENCES role(id_role)
                               on update cascade on delete cascade
);

CREATE TABLE clothing (
                          id_clothing serial primary key,
                          name varchar(100) not null,
                          created_at timestamp not null,
                          image varchar(255) not null,
                          id_category int not null,
                          id_user int not null,
                          constraint fk_id_user
                              foreign key (id_user)
                                  references _user(id_user)
                                  on update cascade on delete cascade,
                          constraint fk_id_category
                              foreign key (id_category)
                                  references category(id_category)
                                  on update no action on delete no action
);

CREATE TABLE outfit (
                        id_outfit serial primary key,
                        name varchar(100),
                        id_user int,
                        constraint fk_id_user
                            foreign key (id_user)
                                references _user(id_user)
                                on update cascade on delete cascade
);


create table clothing_outfit (
                                 id_clothing INT,
                                 id_outfit INT,
                                 constraint fk_id_clothing
                                     foreign key (id_clothing)
                                         references clothing(id_clothing)
                                         on update cascade on delete cascade,
                                 constraint fk_id_outfit
                                     foreign key (id_outfit)
                                         references outfit(id_outfit)
                                         on update cascade on delete cascade
);

create table favourite_outfit (
                                  id_outfit INT,
                                  id_user int,
                                  constraint fk_id_outfit
                                      foreign key (id_outfit)
                                          references outfit(id_outfit)
                                          on update cascade on delete cascade,
                                  constraint fk_id_user
                                      foreign key (id_user)
                                          references _user(id_user)
                                          on update cascade on delete cascade
);

CREATE SEQUENCE filename_sequence;

SELECT nextval('filename_sequence');

CREATE OR REPLACE FUNCTION prepend_value_func() RETURNS TRIGGER
    LANGUAGE plpgsql
AS $$
DECLARE val varchar(20);
BEGIN
    SELECT nextval('filename_sequence') INTO val;
    NEW.image := concat(val, '_', NEW.image);
    RETURN NEW;
END;
$$;

CREATE TRIGGER prepend_value
    BEFORE INSERT ON clothing
    FOR EACH ROW
EXECUTE FUNCTION prepend_value_func();

