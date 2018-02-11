-- 5 servers for every endpoint type.
-- But sometimes the server is suitable for multiple endpoint types. So, total number is 29 (and no 16*5=80).
-- No servers for 7 FtgwSelfService and 11 FtgwProtokollserver.
-- All servers excepting wincdabn and wincdprd are active (server.active=1).

INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('a34', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('a44', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrd90130', 1, '2017-03-13 14:08:39', NULL, NULL, 4, 1);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrd90131', 1, '2017-03-13 14:08:39', NULL, NULL, 4, 1);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrddakc0', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsva90132', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsva91028', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abweiler', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-100v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-101v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-200v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-201v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('bla2', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('blber200', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ble1', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ble2', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('efproxy', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('efserver', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('epa-neu', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('epa3', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ererf210', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ererf220', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('lab', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('lab-neu', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('via', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdabn', 0, '2016-11-10 09:53:32', NULL, NULL, 7, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdabn.tech.rz.db.de', 1, '2017-03-23 09:26:31', NULL, NULL, 7, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdprd', 0, '2016-11-10 09:53:32', NULL, NULL, 7, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdprd.tech.rz.db.de', 1, '2017-03-23 09:26:31', NULL, NULL, 7, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('s3.amazonaws.com', 1, '2017-03-23 09:26:31', NULL, NULL, 8, NULL);
