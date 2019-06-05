<?php

trait repairTypes
{
    private function getRepairTypes()
    {
        $sql = '
            SELECT * 
            FROM `repair_types` 
            WHERE `id_rental_org` = :id_rental_org 
        ';

        $d = array (
            'id_rental_org' => $this->app_id,
        );

        $result = $this->pDB->get($sql, false, $d);
        
        $log = $result ? "getRepairTypes is completed" : "getRepairTypes is failed";

        return $result;
    }
    
    /*
    // * Функция - обертка
    // * Проверяет id ремонта и вызывает соответсвующую функцию
    // */
    // private function setRepairTypes($repair) 
    // {
    //     $id = $this->findIdRentIn('repair_types', $repairType['id_rent']);

    //     if (!$id) {
    //         $this->writeLog('RepairTypes: id_rent is not found. Make new repairType', 'id_rent = ', $repairType['id_rent']);
    //     } else {
    //         $this->writeLog('RepairTypes: id_rent is found. Make update this repairType', 'id_rent = ', $id);
    //     }

    //     return $id ? $this->updateRepairType($repairType) : $this->newRepairType($repairType);       
    // }

    private function setRepairType($type) {
        if (!isset($type[id_rent])) {
            $this->newRepairType($type);
        } else {
            $this->updateRepairType($type);
        }  
    }

    private function newRepairType($type)
    {
        $sql = '
            INSERT INTO `repair_types` (
            `id`,
            `id_rent`,
            `id_rental_org`,
            `is_plan`,  
            `name`,
            `period`,
            `note`,
            `status`,
            `updated`,
            `created`
        ) VALUES (
            NULL,
            :id_rent,
            :id_rental_org,
            :is_plan, 
            :name, 
            :period, 
            :note,
            :status,
            :updated,
            :created
        )';

        $d = array(
            'id_rent'       => $this->getIdRent('repair_types'),
            'id_rental_org' => $this->app_id, 
            'is_plan'       => $type[is_plan] ? $type[is_plan] : 0,
            'name'          => $type[name],
            'period'        => $type[period] ? $type[period] : 0,
            'note'          => $type[note],
            'status'        => 'active',
            'updated'       => date("Y-m-d H:i:s"),
            'created'       => date("Y-m-d H:i:s"),
        );
        
        $result = $this->pDB->set($sql, $d);

        $log = $result ? 
            'new RepairType: completed!':
            'new RepairType: failed!';            

        $this->writeLog($log);

        return $result;
    }

    private function updateRepairType($type) {
        
        $sql = '
            UPDATE `repair_types` 
            SET 
                `is_plan` = :is_plan,
                `name`    = :name, 
                `period`  = :period, 
                `note`    = :note, 
                `updated` = :updated
            WHERE 
                `id_rent` = :id_rent
            AND 
                `id_rental_org` = :id_rental_org
        ';

        $d = array( 
            'is_plan' => $type[is_plan] ? $type[is_plan] : 0, 
            'name'    => $type[name], 
            'period'  => $type[period] ? $type[period] : 0, 
            'note'    => $type[note],  
            'updated' => date("Y-m-d H:i:s"),

            'id_rent' => $type[id_rent],
            'id_rental_org' => $this->app_id,
        );

        $result = $this->pDB->set($sql, $d);

        $log = $result ? 
            'update RepairType: completed!':
            'update RepairType: failed!';            

        $this->writeLog($log);

        return $result;
    }

    private function deleteRepairType($typeId) {
        $id = $this->findIdRent('repair_types', $typeId);

        if (!$id) {
            $this->writeLog('delete RepairType failed! Don`t finded id_rent.');

            return false;
        }

        $sql = '
            UPDATE `repair_types` 
            SET 
                `status`  = :status,
                `updated` = :updated
            WHERE 
                `id_rent` = :id_rent
            AND 
                `id_rental_org` = :id_rental_org
        ';

        $d = array( 
            'status'  => 'deleted',  
            'updated' => date("Y-m-d H:i:s"),

            'id_rent' => $typeId,
            'id_rental_org' => $this->app_id,
        );

        $result = $this->pDB->set($sql, $d);

        $log = $result ? 
            'delete RepairType: completed!':
            'delete RepairType: failed!';            

        $this->writeLog($log);

        return $result;
    }
}
