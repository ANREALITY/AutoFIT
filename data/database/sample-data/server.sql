-- 5 servers for every endpoint type.
-- Exception: 4 servers for 4 CdWindowsShare and for 8 FtgwWindowsShare.
-- Exception: No servers for 7 FtgwSelfService and 11 FtgwProtokollserver.
-- Every server group (grouped by endpoint type) contains at 2-4 inactive servers (server.active=0).

-- endpoint 1 CdAs400
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('blber200', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('efproxy', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('efserver', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ererf210', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ererf220', 0, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
-- endpoint 2 CdTandem
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('epa-neu', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('epa3', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('lab', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('lab-neu', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('via', 0, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
-- endpoint 3 CdLinuxUnix
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abweiler', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-100v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-101v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-200v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-201v', 0, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
-- endpoint 4 CdWindowsShare
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdabn', 0, '2016-11-10 09:53:32', NULL, NULL, 7, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdabn.tech.rz.db.de', 1, '2017-03-23 09:26:31', NULL, NULL, 7, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdprd', 0, '2016-11-10 09:53:32', NULL, NULL, 7, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdprd.tech.rz.db.de', 1, '2017-03-23 09:26:31', NULL, NULL, 7, NULL);
-- endpoint 5 CdWindows
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrd90130', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrd90131', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrddakc0', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsva90132', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsva91028', 0, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
-- endpoint 6 CdZos
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('a34', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('a44', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('bla2', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ble1', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ble2', 0, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
-- endpoint 7 FtgwSelfService
-- endpoint 8 FtgwWindowsShare
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdabn', 0, '2016-11-10 09:53:32', NULL, NULL, 7, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdabn.tech.rz.db.de', 1, '2017-03-23 09:26:31', NULL, NULL, 7, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdprd', 0, '2016-11-10 09:53:32', NULL, NULL, 7, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('wincdprd.tech.rz.db.de', 1, '2017-03-23 09:26:31', NULL, NULL, 7, NULL);
-- endpoint 9 FtgwWindows
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrd90130', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrd90131', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrddakc0', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsva90132', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsva91028', 0, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
-- endpoint 10 FtgwLinuxunix
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abweiler', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-100v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-101v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-200v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-201v', 0, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
-- endpoint 11 FtgwProtokollserver
-- endpoint 12 FtgwCdLinux/unix
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abweiler', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-100v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-101v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-200v', 1, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('aceip-201v', 0, '2017-03-13 14:08:44', NULL, NULL, 5, NULL);
-- endpoint 13 FtgwCdWindows
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrd90130', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrd90131', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsrddakc0', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsva90132', 1, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('abnsva91028', 0, '2017-03-13 14:08:39', NULL, NULL, 4, NULL);
-- endpoint 14 FtgwCdTandem
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('epa-neu', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('epa3', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('lab', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('lab-neu', 1, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('via', 0, '2017-03-13 14:08:39', NULL, NULL, 3, NULL);
-- endpoint 15 FtgwCdAs400
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('blber200', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('efproxy', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('efserver', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ererf210', 1, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ererf220', 0, '2017-03-13 14:08:39', NULL, NULL, 1, NULL);
-- endpoint 16 FtgwCdZos
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('a34', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('a44', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('bla2', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ble1', 1, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
INSERT INTO `server` (`name`, `active`, `updated`, `node_name`, `virtual_node_name`, `server_type_id`, `cluster_id`) VALUES ('ble2', 0, '2017-03-13 14:08:39', NULL, NULL, 2, NULL);
