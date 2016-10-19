USE `mydb`;

CREATE FUNCTION customRand(startValue INT, endValue INT)
  RETURNS INTEGER
  begin
    RETURN floor(startValue + rand() * (endValue - startValue));
  end;

CREATE PROCEDURE users()
  BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= 100 DO
      INSERT INTO `users` (first_name, last_name, login, password)
      VALUES (CONCAT('First_name_', i), CONCAT('Last_name_', i), CONCAT('login', i), MD5(CONCAT('login', i)));
      SET i = i + 1;
    END WHILE;
  END;

CREATE PROCEDURE countries()
  BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= 100 DO
      INSERT INTO `country` (name) VALUES (CONCAT('Country_name_', i));
      SET i = i + 1;
    END WHILE;
  END;

CREATE PROCEDURE cities()
  BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE j INT DEFAULT 1;
    WHILE i <= 100 DO
      INSERT INTO `city` (country_id, NAME) VALUES (customRand(1, 100), CONCAT('City_name_', i));
      SET i = i + 1;
    END WHILE;
  END;

CREATE PROCEDURE adresses()
  BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= 100 DO
      INSERT INTO `adress` (user_id, city_id, adress)
      VALUES (customRand(1, 100), customRand(1, 100), CONCAT('Adress_name_', i));
      SET i = i + 1;
    END WHILE;
  END;

CALL users();
CALL countries();
CALL cities();
CALL adresses();