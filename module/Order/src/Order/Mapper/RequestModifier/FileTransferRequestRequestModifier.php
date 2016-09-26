<?php
namespace Order\Mapper\RequestModifier;

use Zend\Db\Sql\Select;

class FileTransferRequestRequestModifier
{

    const REQUEST_MODE_BASIC = 'basic';

    const REQUEST_MODE_REDUCED = 'reduced';

    const REQUEST_MODE_FULL = 'full';

    public function addEndpoint(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint', 'endpoint.physical_connection_id = physical_connection.id',
            [
                'endpoint' . '__' . 'id' => 'id',
                'endpoint' . '__' . 'physical_connection_id' => 'physical_connection_id',
                'endpoint' . '__' . 'role' => 'role',
                'endpoint' . '__' . 'type' => 'type',
                'endpoint' . '__' . 'server_place' => 'server_place',
                'endpoint' . '__' . 'contact_person' => 'contact_person'
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_REDUCED || $requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_application' => 'application'],
                'endpoint_application.technical_short_name = endpoint.application_technical_short_name',
                [
                    'endpoint_application' . '__' . 'technical_short_name' => 'technical_short_name',
                    'endpoint_application' . '__' . 'technical_id' => 'technical_id'
                ], Select::JOIN_LEFT);
            $select->join('endpoint_server_config',
                'endpoint_server_config.id = endpoint.endpoint_server_config_id',
                [
                    'endpoint_server_config' . '__' . 'id' => 'id',
                    'endpoint_server_config' . '__' . 'dns_address' => 'dns_address',
                    'endpoint_server_config' . '__' . 'server_name' => 'server_name'
                ], Select::JOIN_LEFT);
            $select->join('server',
                'server.name = endpoint_server_config.server_name',
                [
                    'server' . '__' . 'name' => 'name',
                    'server' . '__' . 'active' => 'active',
                    'server' . '__' . 'node_name' => 'node_name',
                    'server' . '__' . 'virtual_node_name' => 'virtual_node_name'
                ], Select::JOIN_LEFT);
            $select->join('external_server',
                'external_server.id = endpoint.external_server_id',
                [
                    'external_server' . '__' . 'id' => 'id',
                    'external_server' . '__' . 'name' => 'name',
                ], Select::JOIN_LEFT);
            $select->join('customer',
                'customer.id = endpoint.customer_id',
                [
                    'customer' . '__' . 'id' => 'id',
                    'customer' . '__' . 'name' => 'name'
                ], Select::JOIN_LEFT);
        }
    }

    public function addCdAs400(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_cd_as400', 'endpoint_cd_as400.endpoint_id = endpoint.id',
            [
                'endpoint_cd_as400' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_cd_as400' . '__' . 'username' => 'username',
                'endpoint_cd_as400' . '__' . 'folder' => 'folder'
            ], Select::JOIN_LEFT);
    }
    
    public function addCdTandem(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_cd_tandem', 'endpoint_cd_tandem.endpoint_id = endpoint.id',
            [
                'endpoint_cd_tandem' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_cd_tandem' . '__' . 'username' => 'username',
                'endpoint_cd_tandem' . '__' . 'folder' => 'folder'
            ], Select::JOIN_LEFT);
    }
    
    public function addCdLinuxUnix(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_cd_linux_unix', 'endpoint_cd_linux_unix.endpoint_id = endpoint.id',
            [
                'endpoint_cd_linux_unix' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_cd_linux_unix' . '__' . 'username' => 'username',
                'endpoint_cd_linux_unix' . '__' . 'folder' => 'folder',
                'endpoint_cd_linux_unix' . '__' . 'transmission_type' => 'transmission_type',
                'endpoint_cd_linux_unix' . '__' . 'transmission_interval' => 'transmission_interval',
                'endpoint_cd_linux_unix' . '__' . 'service_address' => 'service_address'
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_REDUCED || $requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['cd_linux_unix_cluster_config' => 'endpoint_cluster_config'], 'cd_linux_unix_cluster_config.id = endpoint_cd_linux_unix.endpoint_cluster_config_id',
                [
                    'cd_linux_unix_cluster_config' . '__' . 'id' => 'id',
                    'cd_linux_unix_cluster_config' . '__' . 'dns_address' => 'dns_address',
                    'cd_linux_unix_cluster_config' . '__' . 'cluster_id' => 'cluster_id',
                ], Select::JOIN_LEFT);
            $select->join(['cd_linux_unix_cluster' => 'cluster'], 'cd_linux_unix_cluster.id = cd_linux_unix_cluster_config.cluster_id',
                [
                    'cd_linux_unix_cluster' . '__' . 'id' => 'id',
                    'cd_linux_unix_cluster' . '__' . 'virtual_node_name' => 'virtual_node_name',
                ], Select::JOIN_LEFT);
            $select->join(['cd_linux_unix_server' => 'server'],
                'cd_linux_unix_server.cluster_id = cd_linux_unix_cluster.id',
                [
                    'cd_linux_unix_server' . '__' . 'name' => 'name',
                    'cd_linux_unix_server' . '__' . 'node_name' => 'node_name',
                    'cd_linux_unix_server' . '__' . 'virtual_node_name' => 'virtual_node_name',
                    'cd_linux_unix_server' . '__' . 'cluster_id' => 'cluster_id',
                ], Select::JOIN_LEFT);
        }
        if ($requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_cd_linux_unix_include_parameter_set' => 'include_parameter_set'], 'endpoint_cd_linux_unix_include_parameter_set.id = endpoint_cd_linux_unix.include_parameter_set_id',
                [
                    'endpoint_cd_linux_unix_include_parameter_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_cd_linux_unix_include_parameter' => 'include_parameter'], 'endpoint_cd_linux_unix_include_parameter.include_parameter_set_id = endpoint_cd_linux_unix_include_parameter_set.id',
                [
                    'endpoint_cd_linux_unix_include_parameter' . '__' . 'id' => 'id',
                    'endpoint_cd_linux_unix_include_parameter' . '__' . 'expression' => 'expression',
                    'endpoint_cd_linux_unix_include_parameter' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id'
                ], Select::JOIN_LEFT);
        }
    }
    
    public function addCdWindows(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_cd_windows', 'endpoint_cd_windows.endpoint_id = endpoint.id',
            [
                'endpoint_cd_windows' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_cd_windows' . '__' . 'folder' => 'folder',
                'endpoint_cd_windows' . '__' . 'transmission_type' => 'transmission_type',
                'endpoint_cd_windows' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id'
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_cd_windows_include_parameter_set' => 'include_parameter_set'], 'endpoint_cd_windows_include_parameter_set.id = endpoint_cd_windows.include_parameter_set_id',
                [
                    'endpoint_cd_windows_include_parameter_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_cd_windows_include_parameter' => 'include_parameter'], 'endpoint_cd_windows_include_parameter.include_parameter_set_id = endpoint_cd_windows_include_parameter_set.id',
                [
                    'endpoint_cd_windows_include_parameter' . '__' . 'id' => 'id',
                    'endpoint_cd_windows_include_parameter' . '__' . 'expression' => 'expression',
                    'endpoint_cd_windows_include_parameter' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id'
                ], Select::JOIN_LEFT);
        }
    }
    
    public function addCdWindowsShare(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_cd_windows_share', 'endpoint_cd_windows_share.endpoint_id = endpoint.id',
            [
                'endpoint_cd_windows_share' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_cd_windows_share' . '__' . 'sharename' => 'sharename',
                'endpoint_cd_windows_share' . '__' . 'folder' => 'folder',
                'endpoint_cd_windows_share' . '__' . 'transmission_type' => 'transmission_type',
                'endpoint_cd_windows_share' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id',
                'endpoint_cd_windows_share' . '__' . 'access_config_set_id' => 'access_config_set_id'
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_cd_windows_share_include_parameter_set' => 'include_parameter_set'], 'endpoint_cd_windows_share_include_parameter_set.id = endpoint_cd_windows_share.include_parameter_set_id',
                [
                    'endpoint_cd_windows_share_include_parameter_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_cd_windows_share_include_parameter' => 'include_parameter'], 'endpoint_cd_windows_share_include_parameter.include_parameter_set_id = endpoint_cd_windows_share_include_parameter_set.id',
                [
                    'endpoint_cd_windows_share_include_parameter' . '__' . 'id' => 'id',
                    'endpoint_cd_windows_share_include_parameter' . '__' . 'expression' => 'expression',
                    'endpoint_cd_windows_share_include_parameter' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_cd_windows_share_access_config_set' => 'access_config_set'], 'endpoint_cd_windows_share_access_config_set.id = endpoint_cd_windows_share.access_config_set_id',
                [
                    'endpoint_cd_windows_share_access_config_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_cd_windows_share_access_config' => 'access_config'], 'endpoint_cd_windows_share_access_config.access_config_set_id = endpoint_cd_windows_share_access_config_set.id',
                [
                    'endpoint_cd_windows_share_access_config' . '__' . 'id' => 'id',
                    'endpoint_cd_windows_share_access_config' . '__' . 'username' => 'username',
                    'endpoint_cd_windows_share_access_config' . '__' . 'permission_read' => 'permission_read',
                    'endpoint_cd_windows_share_access_config' . '__' . 'permission_write' => 'permission_write',
                    'endpoint_cd_windows_share_access_config' . '__' . 'permission_delete' => 'permission_delete',
                    'endpoint_cd_windows_share_access_config' . '__' . 'access_config_set_id' => 'access_config_set_id'
                ], Select::JOIN_LEFT);
        }
    }
    
    public function addCdZos(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_cd_zos', 'endpoint_cd_zos.endpoint_id = endpoint.id',
            [
                'endpoint_cd_zos' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_cd_zos' . '__' . 'username' => 'username',
                'endpoint_cd_zos' . '__' . 'file_parameter_set_id' => 'file_parameter_set_id',
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_cd_zos_file_parameter_set' => 'file_parameter_set'], 'endpoint_cd_zos_file_parameter_set.id = endpoint_cd_zos.file_parameter_set_id',
                [
                    'endpoint_cd_zos_file_parameter_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_cd_zos_file_parameter' => 'file_parameter'], 'endpoint_cd_zos_file_parameter.file_parameter_set_id = endpoint_cd_zos_file_parameter_set.id',
                [
                    'endpoint_cd_zos_file_parameter' . '__' . 'id' => 'id',
                    'endpoint_cd_zos_file_parameter' . '__' . 'filename' => 'filename',
                    'endpoint_cd_zos_file_parameter' . '__' . 'record_length' => 'record_length',
                    'endpoint_cd_zos_file_parameter' . '__' . 'blocking' => 'blocking',
                    'endpoint_cd_zos_file_parameter' . '__' . 'block_size' => 'block_size',
                    'endpoint_cd_zos_file_parameter' . '__' . 'file_parameter_set_id' => 'file_parameter_set_id'
                ], Select::JOIN_LEFT);
        }
    }
    
    public function addFtgwWindows(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_ftgw_windows', 'endpoint_ftgw_windows.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_windows' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_ftgw_windows' . '__' . 'folder' => 'folder',
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_ftgw_windows_include_parameter_set' => 'include_parameter_set'], 'endpoint_ftgw_windows_include_parameter_set.id = endpoint_ftgw_windows.include_parameter_set_id',
                [
                    'endpoint_ftgw_windows_include_parameter_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_ftgw_windows_include_parameter' => 'include_parameter'], 'endpoint_ftgw_windows_include_parameter.include_parameter_set_id = endpoint_ftgw_windows_include_parameter_set.id',
                [
                    'endpoint_ftgw_windows_include_parameter' . '__' . 'id' => 'id',
                    'endpoint_ftgw_windows_include_parameter' . '__' . 'expression' => 'expression',
                    'endpoint_ftgw_windows_include_parameter' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id'
                ], Select::JOIN_LEFT);
        }
    }
    
    public function addFtgwSelfService(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_ftgw_self_service', 'endpoint_ftgw_self_service.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_self_service' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_ftgw_self_service' . '__' . 'ftgw_username' => 'ftgw_username',
                'endpoint_ftgw_self_service' . '__' . 'mailbox' => 'mailbox',
                'endpoint_ftgw_self_service' . '__' . 'connection_type' => 'connection_type',
                'endpoint_ftgw_self_service' . '__' . 'protocol_set_id' => 'protocol_set_id'
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_ftgw_self_service_protocol_set' => 'protocol_set'], 'endpoint_ftgw_self_service_protocol_set.id = endpoint_ftgw_self_service.protocol_set_id',
                [
                    'endpoint_ftgw_self_service_protocol_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_ftgw_self_service_protocol' => 'protocol'], 'endpoint_ftgw_self_service_protocol.protocol_set_id = endpoint_ftgw_self_service_protocol_set.id',
                [
                    'endpoint_ftgw_self_service_protocol' . '__' . 'id' => 'id',
                    'endpoint_ftgw_self_service_protocol' . '__' . 'name' => 'name',
                    'endpoint_ftgw_self_service_protocol' . '__' . 'protocol_set_id' => 'protocol_set_id'
                ], Select::JOIN_LEFT);
        }
    }
    
    public function addFtgwProtocolServer(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_ftgw_protocol_server', 'endpoint_ftgw_protocol_server.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_protocol_server' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_ftgw_protocol_server' . '__' . 'username' => 'username',
                'endpoint_ftgw_protocol_server' . '__' . 'folder' => 'folder',
                'endpoint_ftgw_protocol_server' . '__' . 'dns_address' => 'dns_address',
                'endpoint_ftgw_protocol_server' . '__' . 'ip' => 'ip',
                'endpoint_ftgw_protocol_server' . '__' . 'port' => 'port',
                'endpoint_ftgw_protocol_server' . '__' . 'transmission_type' => 'transmission_type',
                'endpoint_ftgw_protocol_server' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id',
                'endpoint_ftgw_protocol_server' . '__' . 'protocol_set_id' => 'protocol_set_id',
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_ftgw_protocol_server_include_parameter_set' => 'include_parameter_set'], 'endpoint_ftgw_protocol_server_include_parameter_set.id = endpoint_ftgw_protocol_server.include_parameter_set_id',
                [
                    'endpoint_ftgw_protocol_server_include_parameter_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_ftgw_protocol_server_include_parameter' => 'include_parameter'], 'endpoint_ftgw_protocol_server_include_parameter.include_parameter_set_id = endpoint_ftgw_protocol_server_include_parameter_set.id',
                [
                    'endpoint_ftgw_protocol_server_include_parameter' . '__' . 'id' => 'id',
                    'endpoint_ftgw_protocol_server_include_parameter' . '__' . 'expression' => 'expression',
                    'endpoint_ftgw_protocol_server_include_parameter' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_ftgw_protocol_server_protocol_set' => 'protocol_set'], 'endpoint_ftgw_protocol_server_protocol_set.id = endpoint_ftgw_protocol_server.protocol_set_id',
                [
                    'endpoint_ftgw_protocol_server_protocol_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_ftgw_protocol_server_protocol' => 'protocol'], 'endpoint_ftgw_protocol_server_protocol.protocol_set_id = endpoint_ftgw_protocol_server_protocol_set.id',
                [
                    'endpoint_ftgw_protocol_server_protocol' . '__' . 'id' => 'id',
                    'endpoint_ftgw_protocol_server_protocol' . '__' . 'name' => 'name',
                    'endpoint_ftgw_protocol_server_protocol' . '__' . 'protocol_set_id' => 'protocol_set_id'
                ], Select::JOIN_LEFT);
        }
    }
    
    public function addFtgwWindowsShare(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_ftgw_windows_share', 'endpoint_ftgw_windows_share.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_windows_share' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_ftgw_windows_share' . '__' . 'sharename' => 'sharename',
                'endpoint_ftgw_windows_share' . '__' . 'folder' => 'folder',
                'endpoint_ftgw_windows_share' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id',
                'endpoint_ftgw_windows_share' . '__' . 'access_config_set_id' => 'access_config_set_id'
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_ftgw_windows_share_include_parameter_set' => 'include_parameter_set'], 'endpoint_ftgw_windows_share_include_parameter_set.id = endpoint_ftgw_windows_share.include_parameter_set_id',
                [
                    'endpoint_ftgw_windows_share_include_parameter_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_ftgw_windows_share_include_parameter' => 'include_parameter'], 'endpoint_ftgw_windows_share_include_parameter.include_parameter_set_id = endpoint_ftgw_windows_share_include_parameter_set.id',
                [
                    'endpoint_ftgw_windows_share_include_parameter' . '__' . 'id' => 'id',
                    'endpoint_ftgw_windows_share_include_parameter' . '__' . 'expression' => 'expression',
                    'endpoint_ftgw_windows_share_include_parameter' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_ftgw_windows_share_access_config_set' => 'access_config_set'], 'endpoint_ftgw_windows_share_access_config_set.id = endpoint_ftgw_windows_share.access_config_set_id',
                [
                    'endpoint_ftgw_windows_share_access_config_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_ftgw_windows_share_access_config' => 'access_config'], 'endpoint_ftgw_windows_share_access_config.access_config_set_id = endpoint_ftgw_windows_share_access_config_set.id',
                [
                    'endpoint_ftgw_windows_share_access_config' . '__' . 'id' => 'id',
                    'endpoint_ftgw_windows_share_access_config' . '__' . 'username' => 'username',
                    'endpoint_ftgw_windows_share_access_config' . '__' . 'permission_read' => 'permission_read',
                    'endpoint_ftgw_windows_share_access_config' . '__' . 'permission_write' => 'permission_write',
                    'endpoint_ftgw_windows_share_access_config' . '__' . 'permission_delete' => 'permission_delete',
                    'endpoint_ftgw_windows_share_access_config' . '__' . 'access_config_set_id' => 'access_config_set_id'
                ], Select::JOIN_LEFT);
        }
    }
    
    public function addFtgwLinuxUnix(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_ftgw_linux_unix', 'endpoint_ftgw_linux_unix.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_linux_unix' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_ftgw_linux_unix' . '__' . 'username' => 'username',
                'endpoint_ftgw_linux_unix' . '__' . 'folder' => 'folder',
                'endpoint_ftgw_linux_unix' . '__' . 'transmission_type' => 'transmission_type',
                'endpoint_ftgw_linux_unix' . '__' . 'transmission_interval' => 'transmission_interval',
                'endpoint_ftgw_linux_unix' . '__' . 'service_address' => 'service_address'
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_REDUCED || $requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['ftgw_linux_unix_cluster_config' => 'endpoint_cluster_config'], 'ftgw_linux_unix_cluster_config.id = endpoint_ftgw_linux_unix.endpoint_cluster_config_id',
                [
                    'ftgw_linux_unix_cluster_config' . '__' . 'id' => 'id',
                    'ftgw_linux_unix_cluster_config' . '__' . 'dns_address' => 'dns_address',
                    'ftgw_linux_unix_cluster_config' . '__' . 'cluster_id' => 'cluster_id',
                ], Select::JOIN_LEFT);
            $select->join(['ftgw_linux_unix_cluster' => 'cluster'], 'ftgw_linux_unix_cluster.id = ftgw_linux_unix_cluster_config.cluster_id',
                [
                    'ftgw_linux_unix_cluster' . '__' . 'id' => 'id',
                    'ftgw_linux_unix_cluster' . '__' . 'virtual_node_name' => 'virtual_node_name',
                ], Select::JOIN_LEFT);
            $select->join(['ftgw_linux_unix_server' => 'server'],
                'ftgw_linux_unix_server.cluster_id = ftgw_linux_unix_cluster.id',
                [
                    'ftgw_linux_unix_server' . '__' . 'name' => 'name',
                    'ftgw_linux_unix_server' . '__' . 'node_name' => 'node_name',
                    'ftgw_linux_unix_server' . '__' . 'virtual_node_name' => 'virtual_node_name',
                    'ftgw_linux_unix_server' . '__' . 'cluster_id' => 'cluster_id',
                ], Select::JOIN_LEFT);
        }
        if ($requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_ftgw_linux_unix_include_parameter_set' => 'include_parameter_set'], 'endpoint_ftgw_linux_unix_include_parameter_set.id = endpoint_ftgw_linux_unix.include_parameter_set_id',
                [
                    'endpoint_ftgw_linux_unix_include_parameter_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_ftgw_linux_unix_include_parameter' => 'include_parameter'], 'endpoint_ftgw_linux_unix_include_parameter.include_parameter_set_id = endpoint_ftgw_linux_unix_include_parameter_set.id',
                [
                    'endpoint_ftgw_linux_unix_include_parameter' . '__' . 'id' => 'id',
                    'endpoint_ftgw_linux_unix_include_parameter' . '__' . 'expression' => 'expression',
                    'endpoint_ftgw_linux_unix_include_parameter' . '__' . 'include_parameter_set_id' => 'include_parameter_set_id'
                ], Select::JOIN_LEFT);
        }
    }
    
    public function addFtgwCdLinuxUnix(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_ftgw_cd_linux_unix', 'endpoint_ftgw_cd_linux_unix.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_cd_linux_unix' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_ftgw_cd_linux_unix' . '__' . 'username' => 'username',
                'endpoint_ftgw_cd_linux_unix' . '__' . 'folder' => 'folder',
                'endpoint_ftgw_cd_linux_unix' . '__' . 'transmission_type' => 'transmission_type'
            ], Select::JOIN_LEFT);
    }
    
    public function addFtgwCdWindows(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_ftgw_cd_windows', 'endpoint_ftgw_cd_windows.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_cd_windows' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_ftgw_cd_windows' . '__' . 'username' => 'username',
                'endpoint_ftgw_cd_windows' . '__' . 'folder' => 'folder',
                'endpoint_ftgw_cd_windows' . '__' . 'transmission_type' => 'transmission_type'
            ], Select::JOIN_LEFT);
    }
    
    public function addFtgwCdZos(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_ftgw_cd_zos', 'endpoint_ftgw_cd_zos.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_cd_zos' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_ftgw_cd_zos' . '__' . 'username' => 'username',
                'endpoint_ftgw_cd_zos' . '__' . 'file_parameter_set_id' => 'file_parameter_set_id',
            ], Select::JOIN_LEFT);
        if ($requstMode == self::REQUEST_MODE_FULL) {
            $select->join(['endpoint_ftgw_cd_zos_file_parameter_set' => 'file_parameter_set'], 'endpoint_ftgw_cd_zos_file_parameter_set.id = endpoint_ftgw_cd_zos.file_parameter_set_id',
                [
                    'endpoint_ftgw_cd_zos_file_parameter_set' . '__' . 'id' => 'id'
                ], Select::JOIN_LEFT);
            $select->join(['endpoint_ftgw_cd_zos_file_parameter' => 'file_parameter'], 'endpoint_ftgw_cd_zos_file_parameter.file_parameter_set_id = endpoint_ftgw_cd_zos_file_parameter_set.id',
                [
                    'endpoint_ftgw_cd_zos_file_parameter' . '__' . 'id' => 'id',
                    'endpoint_ftgw_cd_zos_file_parameter' . '__' . 'filename' => 'filename',
                    'endpoint_ftgw_cd_zos_file_parameter' . '__' . 'record_length' => 'record_length',
                    'endpoint_ftgw_cd_zos_file_parameter' . '__' . 'blocking' => 'blocking',
                    'endpoint_ftgw_cd_zos_file_parameter' . '__' . 'block_size' => 'block_size',
                    'endpoint_ftgw_cd_zos_file_parameter' . '__' . 'file_parameter_set_id' => 'file_parameter_set_id'
                ], Select::JOIN_LEFT);
        }
    }

    public function addFtgwCdTandem(Select &$select, $requstMode = self::REQUEST_MODE_BASIC)
    {
        $select->join('endpoint_ftgw_cd_tandem', 'endpoint_ftgw_cd_tandem.endpoint_id = endpoint.id',
            [
                'endpoint_ftgw_cd_tandem' . '__' . 'endpoint_id' => 'endpoint_id',
                'endpoint_ftgw_cd_tandem' . '__' . 'username' => 'username',
                'endpoint_ftgw_cd_tandem' . '__' . 'folder' => 'folder'
            ], Select::JOIN_LEFT);
    }

}
