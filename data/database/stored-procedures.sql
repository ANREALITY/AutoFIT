-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema autofit
-- -----------------------------------------------------
-- AutoFIT database

-- -----------------------------------------------------
-- procedure p_sync_andb_applnames_to_my_applnames
-- -----------------------------------------------------

-- DELIMITER $$
CREATE DEFINER=`midan`@`%` PROCEDURE `p_sync_andb_applnames_to_my_applnames`()
NO SQL
  BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE my_techapplid VARCHAR(10);
    DECLARE my_techappl_short VARCHAR(100);

    DECLARE cnt_WRN_22001 INT DEFAULT 0;
    DECLARE cnt_WRN_23000 INT DEFAULT 0;
    DECLARE x INT;

    DECLARE cnt_WRN INT DEFAULT 0;
    DECLARE cnt_ERR INT DEFAULT 0;
    DECLARE RC VARCHAR(96);
    DECLARE SYNC_TIMESTAMP timestamp;
    DECLARE SYNC_TYPE varchar(16);

    DECLARE cur1 CURSOR FOR select distinct tech_appl_name_short as technical_short_name,tech_appl_id as technical_id  from midan.andb_t_stamm_appl_names where coalesce(state,'') <> 'Beendet' ;
    DECLARE cur2 CURSOR FOR select distinct tech_appl_name_short as technical_short_name,tech_appl_id as technical_id  from midan.andb_t_stamm_appl_names where coalesce(state,'') = 'Beendet' ;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 2;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '01000' SET done = 1;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '22001' SET cnt_WRN_22001=cnt_WRN_22001+1;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '23000' SET cnt_WRN_23000=cnt_WRN_23000+1;
    DECLARE CONTINUE HANDLER FOR SQLWARNING	SET cnt_WRN=cnt_WRN+1;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET  done = 3;

    set SYNC_TIMESTAMP=now();
    set SYNC_TYPE='application';

    INSERT INTO synchronization( in_progress,type,last_sync) VALUES (1,SYNC_TYPE,SYNC_TIMESTAMP)
    ON DUPLICATE KEY UPDATE
      in_progress=1,
      last_sync=SYNC_TIMESTAMP
    ;
    UPDATE application SET active=0 WHERE active=1;

    OPEN cur1;
    SET x = 0;

    REPEAT
      FETCH cur1 INTO my_techappl_short,my_techapplid ;
      IF done = 0
      THEN
        INSERT INTO `application`(`technical_short_name`, `technical_id`,active) VALUES (my_techappl_short,my_techapplid,0)
        ON DUPLICATE KEY
        UPDATE
          technical_short_name=my_techappl_short,
          active=0
        ;
        update application SET active=1 WHERE technical_short_name=my_techappl_short;
        SET  x = x + 1;
      END IF;
    UNTIL done END REPEAT;
    CLOSE cur1;

    UPDATE synchronization SET in_progress=0,last_sync=now() WHERE type = SYNC_TYPE ;

    select done as "CursExitCode",'Lines done:' as "read",x as "match",'Warnings:' as "Warnings",cnt_WRN as "WarnMsg",'tolong:',cnt_WRN_22001 as "Warn_tolong",'dupl:' as "dupl",cnt_WRN_23000 as "Warn_dupl",'Errors:' as "Errors",cnt_ERR as "Err";
  END; -- $$

-- DELIMITER ;

-- -----------------------------------------------------
-- procedure p_sync_andb_article_to_my_article
-- -----------------------------------------------------

-- DELIMITER $$
CREATE DEFINER=`midan`@`%` PROCEDURE `p_sync_andb_article_to_my_article`()
NO SQL
  BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE my_article char(16);
    DECLARE my_article_description char(100);
    DECLARE my_product VARCHAR(12);
    DECLARE my_articleclass VARCHAR(12);

    DECLARE cnt_WRN_22001 INT DEFAULT 0;
    DECLARE cnt_WRN_23000 INT DEFAULT 0;
    DECLARE x INT;

    DECLARE cnt_WRN INT DEFAULT 0;
    DECLARE cnt_ERR INT DEFAULT 0;
    DECLARE RC VARCHAR(96);

    DECLARE cur1 CURSOR FOR ( select article as sku,'basic' as type,article_description as description,product_name as product_type_name from midan.andb_t_stamm_article where product_name in('cd','fgw') and article like 'GMDWS%'  )
                            union
                            ( select article as sku,'personal' as type,article_description as description,product_name product_type_name from midan.andb_t_stamm_article where product_name in('cd','fgw') and article like 'GMDWP%' )
                            union
                            ( select article as sku,'on-demand' as type,article_description as description,product_name product_type_name from midan.andb_t_stamm_article where product_name in('cd','fgw') and article like 'GMDWO%' ) ;

    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 2;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '01000' SET done = 1;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '22001' SET cnt_WRN_22001=cnt_WRN_22001+1;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '23000' SET cnt_WRN_23000=cnt_WRN_23000+1;
    DECLARE CONTINUE HANDLER FOR SQLWARNING	SET cnt_WRN=cnt_WRN+1;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET  done = 3;

    OPEN cur1;
    SET x = 0;

    REPEAT
      FETCH cur1 INTO my_article,my_articleclass,my_article_description,my_product ;

      IF done = 0
      THEN 	set x=x+1;
        INSERT INTO product_type(name) VALUES (my_product) on duplicate key update name=my_product;
        INSERT INTO article(sku, description, type,product_type_name) VALUES (my_article,my_article_description,my_articleclass,my_product) on duplicate key update description=my_article_description ;
      END IF;

    UNTIL done END REPEAT;

    CLOSE cur1;

    select done as "CursExitCode",'Lines done:' as "read",x as "match",'Warnings:' as "Warnings",cnt_WRN as "WarnMsg",'tolong:',cnt_WRN_22001 as "Warn_tolong",'dupl:' as "dupl",cnt_WRN_23000 as "Warn_dupl",'Errors:' as "Errors",cnt_ERR as "Err";
  END; -- $$

-- DELIMITER ;

-- -----------------------------------------------------
-- procedure p_sync_andb_ls_and_lsp_to_my_ls_and_lsp
-- -----------------------------------------------------

-- DELIMITER $$
CREATE DEFINER=`midan`@`%` PROCEDURE `p_sync_andb_ls_and_lsp_to_my_ls_and_lsp`()
NO SQL
  BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE my_lsp_status char(32);
    DECLARE my_env_severity tinyint(1);
    DECLARE my_env char(32);
    DECLARE my_env_short char(1);
    DECLARE my_appl char(100);
    DECLARE my_ls_num char(16);
    DECLARE my_ls_desc char(128);
    DECLARE my_lsp_num char(16);
    DECLARE my_lsp_desc char(128);
    DECLARE my_order_quantity char(12);

    DECLARE my_article_description char(100);
    DECLARE my_product VARCHAR(12);
    DECLARE my_article VARCHAR(12);
    DECLARE my_articleclass VARCHAR(12);

    DECLARE cnt_WRN_22001 INT DEFAULT 0;
    DECLARE cnt_WRN_23000 INT DEFAULT 0;
    DECLARE x INT;

    DECLARE cnt_WRN INT DEFAULT 0;
    DECLARE cnt_ERR INT DEFAULT 0;
    DECLARE RC VARCHAR(96);
    DECLARE SYNC_TIMESTAMP timestamp;
    DECLARE SYNC_TYPE varchar(16);

    DECLARE cur1 CURSOR FOR select distinct status as name from midan.andb_t_stamm__lsp_status ;
    DECLARE cur2 CURSOR FOR select distinct env_severity as severity,env_name_long as name,env_name_short as name_short from midan.andb_t_stamm__env;
    DECLARE cur3 CURSOR FOR select distinct ls_num as number,ls_description as description,appl as application_technical_short_name,env as environment_severity from midan.andb_t_stamm_ls;
    DECLARE cur4 CURSOR FOR select distinct lsp_num as number,lsp_order_quantity as order_quantity,lsp_description as description,ls_num as service_invoice_number,article as article_sku,status as service_invoice_position_status_name from midan.andb_v_stamm_lsp;


    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 2;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '01000' SET done = 1;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '22001' SET cnt_WRN_22001=cnt_WRN_22001+1;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '23000' SET cnt_WRN_23000=cnt_WRN_23000+1;
    DECLARE CONTINUE HANDLER FOR SQLWARNING	SET cnt_WRN=cnt_WRN+1;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET  done = 3;

    set SYNC_TIMESTAMP=now();
    set SYNC_TYPE='billing';

    INSERT INTO synchronization( in_progress,type,last_sync) VALUES (1,SYNC_TYPE,SYNC_TIMESTAMP)
    ON DUPLICATE KEY UPDATE
      in_progress=1,
      last_sync=SYNC_TIMESTAMP
    ;

    /* ######################################################################################################## */
    /*
    OPEN cur1;
    SET x = 0;
    SET done = 0;

    REPEAT  FETCH cur1 INTO my_lsp_status ;

    IF done = 0
    THEN 	set x=x+1;
        INSERT INTO autofit.service_invoice_position_status(name)
          VALUES (my_lsp_status)
            on duplicate key update name=my_lsp_status;
    END IF;

    UNTIL done END REPEAT;
    CLOSE cur1;
    */
    /* ######################################################################################################## */
    OPEN cur2;
    SET x = 0;
    SET done = 0;

    REPEAT   FETCH cur2 INTO my_env_severity,my_env,my_env_short ;

      IF done = 0
      THEN 	set x=x+1;
        INSERT INTO environment(name,severity,short_name)
        VALUES (my_env,my_env_severity,my_env_short)
        on duplicate key update short_name=my_env_short;
      END IF;

    UNTIL done END REPEAT;
    CLOSE cur2;
    /* ######################################################################################################## */
    OPEN cur3;
    SET x = 0;
    SET done = 0;

    REPEAT   FETCH cur3 INTO my_ls_num,my_ls_desc,my_appl,my_env ;

      IF done = 0
      THEN 	set x=x+1;
        set my_env_severity=(select severity from environment where name = my_env);
        INSERT INTO service_invoice(`number`, `description`, `application_technical_short_name`, `environment_severity`)
        VALUES (my_ls_num,my_ls_desc,my_appl,my_env_severity);
      END IF;

    UNTIL done END REPEAT;
    CLOSE cur3;

    /* ######################################################################################################## */
    OPEN cur4;
    SET x = 0;
    SET done = 0;

    REPEAT   FETCH cur4 INTO my_lsp_num,my_order_quantity,my_lsp_desc,my_ls_num,my_article,my_lsp_status ;

      IF done = 0
      THEN 	set x=x+1;
        INSERT INTO `service_invoice_position`(`number`, `order_quantity`, `description`, `service_invoice_number`, `article_sku`, `status`)
        VALUES (my_lsp_num,my_order_quantity,my_lsp_desc,my_ls_num,my_article,my_lsp_status)
        on duplicate key
        update status='workinprogress',
          order_quantity=my_order_quantity;
        UPDATE `service_invoice_position` SET status=my_lsp_status WHERE number=my_lsp_num;

      END IF;

    UNTIL done END REPEAT;
    CLOSE cur4;
    UPDATE `service_invoice_position` SET status='Beendet' WHERE order_quantity=0;

    /* loesche Verfahrens-LS fuer die es keine MW-LSP gibt */
    delete FROM `service_invoice` WHERE number not  in (select distinct service_invoice_number from service_invoice_position);

    UPDATE synchronization SET in_progress=0,last_sync=now() WHERE type = SYNC_TYPE ;

    select done as "CursExitCode",'Lines done:' as "read",x as "match",'Warnings:' as "Warnings",cnt_WRN as "WarnMsg",'tolong:',cnt_WRN_22001 as "Warn_tolong",'dupl:' as "dupl",cnt_WRN_23000 as "Warn_dupl",'Errors:' as "Errors",cnt_ERR as "Err";
  END; -- $$

-- DELIMITER ;

-- -----------------------------------------------------
-- procedure p_sync_andb_server_to_my_server
-- -----------------------------------------------------

-- DELIMITER $$
CREATE DEFINER=`midan`@`%` PROCEDURE `p_sync_andb_server_to_my_server`()
NO SQL
  BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE my_typeid TINYINT(3);
    DECLARE my_servername VARCHAR(32);
    DECLARE my_servertype VARCHAR(50);

    DECLARE cnt_WRN_22001 INT DEFAULT 0;
    DECLARE cnt_WRN_23000 INT DEFAULT 0;
    DECLARE x INT;

    DECLARE cnt_WRN INT DEFAULT 0;
    DECLARE cnt_ERR INT DEFAULT 0;
    DECLARE RC VARCHAR(96);
    DECLARE SYNC_TIMESTAMP timestamp;
    DECLARE SYNC_TYPE varchar(16);

    DECLARE cur1 CURSOR FOR ( select distinct mw_host_name as name ,'as400' as server_type_id from midan.andb_v_stamm_hosts_as400 )
                            union
                            ( select distinct mw_host_name as name ,'mvs' as server_type_id from midan.andb_v_stamm_hosts_zos )
                            union
                            ( select distinct mw_host_name as name ,'tandem' as server_type_id from midan.andb_v_stamm_hosts_tandem )
                            union
                            ( select distinct mw_host_name as name ,'windows' as server_type_id from midan.andb_v_stamm_hosts_windows )
                            union
                            ( select distinct mw_host_name as name ,'linux' as server_type_id from midan.andb_v_stamm_hosts_linux )
                            union
                            ( select distinct mw_host_name as name ,'unix' as server_type_id from midan.andb_v_stamm_hosts_unix ) ;

    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 2;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '01000' SET done = 1;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '22001' SET cnt_WRN_22001=cnt_WRN_22001+1;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '23000' SET cnt_WRN_23000=cnt_WRN_23000+1;
    DECLARE CONTINUE HANDLER FOR SQLWARNING	SET cnt_WRN=cnt_WRN+1;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET  done = 3;


    set SYNC_TIMESTAMP=now();
    set SYNC_TYPE='server';

    INSERT INTO synchronization( in_progress,type,last_sync) VALUES (1,SYNC_TYPE,SYNC_TIMESTAMP)
    ON DUPLICATE KEY UPDATE
      in_progress=1,
      last_sync=SYNC_TIMESTAMP
    ;

    UPDATE server SET active=0 WHERE active=1;

    OPEN cur1;
    SET x = 0;

    REPEAT
      FETCH cur1 INTO my_servername,my_servertype ;

      IF done = 0
      THEN 	set x=x+1;

        set my_typeid=(select distinct id from server_type where name = my_servertype);
        if isnull (my_typeid)
        then	INSERT INTO server_type(name) VALUES (my_servertype);
          set my_typeid=(select distinct my_typeid from server_type where name = my_servertype);
        end if;
        INSERT INTO server(name,server_type_id,active) VALUES (my_servername,my_typeid,0)
        ON DUPLICATE KEY
        UPDATE
          active=0;
        UPDATE server SET active=1 WHERE name=my_servername;


      END IF;

    UNTIL done END REPEAT;

    CLOSE cur1;

    UPDATE synchronization SET in_progress=0,last_sync=now() WHERE type = SYNC_TYPE ;

    select done as "CursExitCode",'Lines done:' as "read",x as "match",'Warnings:' as "Warnings",cnt_WRN as "WarnMsg",'tolong:',cnt_WRN_22001 as "Warn_tolong",'dupl:' as "dupl",cnt_WRN_23000 as "Warn_dupl",'Errors:' as "Errors",cnt_ERR as "Err";
  END; -- $$

-- DELIMITER ;

-- -----------------------------------------------------
-- procedure p_sync_andb_winshareserver_to_my_server
-- -----------------------------------------------------

-- DELIMITER $$
CREATE DEFINER=`midan`@`%` PROCEDURE `p_sync_andb_winshareserver_to_my_server`()
NO SQL
  BEGIN


    DECLARE my_typeid TINYINT(3);
    DECLARE my_servername VARCHAR(32);
    DECLARE SYNC_TIMESTAMP timestamp;
    DECLARE SYNC_TYPE varchar(16);

    set SYNC_TIMESTAMP=now();
    set SYNC_TYPE='server';



    INSERT INTO synchronization( in_progress,type,last_sync) VALUES (1,SYNC_TYPE,SYNC_TIMESTAMP)
    ON DUPLICATE KEY UPDATE
      in_progress=1,
      last_sync=SYNC_TIMESTAMP
    ;

    set my_typeid=(select distinct id from server_type where name = 'windowsshare');

    set my_servername='wincdabn.tech.rz.db.de';
    INSERT INTO server(name,server_type_id,active) VALUES (my_servername,my_typeid,1)
    ON DUPLICATE KEY
    UPDATE
      active=0;
    UPDATE server SET active=1 WHERE name=my_servername;

    set my_servername='wincdprd.tech.rz.db.de';
    INSERT INTO server(name,server_type_id,active) VALUES (my_servername,my_typeid,1)
    ON DUPLICATE KEY
    UPDATE
      active=0;
    UPDATE server SET active=1 WHERE name=my_servername;


    UPDATE synchronization SET in_progress=0,last_sync=now() WHERE type = SYNC_TYPE ;


  END; -- $$

-- DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
