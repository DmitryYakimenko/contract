<?php
require('db.class.php');

class Contract
{
    private $db_link;
    private $id_contract;

    public function __construct($db_link)
    {

        $this->db_link = $db_link;

    }

    public function query($id_contract = null, $work = null,
                         $connecting = null, $disconnected = null)
    {
        $where = '';
        if($id_contract !== null){
            $where .= "WHERE (obj_contracts.id_contract = ".$id_contract." ) ";
        }
        $condition = ($work === 'work') ||
            ($connecting === 'connecting') ||
            ($disconnected === 'disconnected');
        if($condition) {
            $where .= "AND ( 0 ";
            if ($work === 'work') {
                $where .= "OR (obj_services.status = 'work') ";
            }
            if ($connecting === 'connecting') {
                $where .= "OR (obj_services.status = 'connecting') ";
            }
            if ($disconnected === 'disconnected') {
                $where .= "OR (obj_services.status = 'disconnected') ";
            }
            $where .= ")";
        }
        return $this->execute($where);
    }

    private function execute($where = null)
    {
        if($where === null){
            $query = 'SELECT 
                      obj_customers.*, obj_contracts.*, GROUP_CONCAT(obj_services.title_service SEPARATOR ", ") as services_name
                  FROM
                      obj_contracts
                  JOIN obj_customers ON obj_customers.id_customer = obj_contracts.id_customer
                  JOIN obj_services ON obj_services.id_contract = obj_contracts.id_contract
                  GROUP BY obj_contracts.id_contract';
        }else {
            $query = 'SELECT 
                      obj_customers.*, obj_contracts.*, GROUP_CONCAT(obj_services.title_service SEPARATOR ", ") as services_name
                  FROM
                      obj_contracts
                  JOIN obj_customers ON obj_customers.id_customer = obj_contracts.id_customer
                  JOIN obj_services ON obj_services.id_contract = obj_contracts.id_contract '
                .$where
                .'GROUP BY obj_contracts.id_contract';
            //print($query);die;
        }
        foreach ( $this->db_link->query($query) as $row ) {
            $result[] = $row;
        }
        return $result;
    }
}

