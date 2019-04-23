<?php

trait Accessoriess
{
    private function getAccessories() {
        $sql = '
            SELECT 
                `id_rent`, 
                `name`, 
                `type`, 
                `value` 
            FROM 
                `accessories` 
            WHERE 
                `id_rental_org` = :id_rental_org 
        ';

        $d = array (
            'id_rental_org' => $this->app_id
        );

        $result = $this->pDB->get($sql, false, $d);
        
        $log = $result ? "getAccessories completed" : "getAccessories failed";

        $this->writeLog($log);

        return $result;
    }

    private function setAccessory($accessory) {
        $update = function ($accessory) {            
            $sql = '
                UPDATE 
                    `accessories` 
                SET 
                    `name`    = :name, 
                    `type`    = :type, 
                    `value`   = :value 
                WHERE 
                    `id_rent` = :id_rent
                AND 
                    `id_rental_org` = :id_rental_org
            ';

            $d = array(
                'id_rental_org' => $this->app_id,
                'id_rent'       => $accessory['id_rent'],
                'name'          => $accessory['name'],
                'type'          => $accessory['type'],
                'value'         => $accessory['value']
            );

            $result = $this->pDB->set($sql, $d);

            $log = $result ? "update accesory completed" : "update accesory failed";

            $this->writeLog($log);

            return $result;
        };

        $newAccessory = function ($accessory) {
            $sql = 'INSERT INTO `accessories` (
                `id`,
                `id_rent`,
                `id_rental_org`, 
                `name`, 
                `type`, 
                `value` 
            ) VALUES (
                NULL, 
                :id_rent,
                :id_rental_org, 
                :name,
                :type,
                :value
            )';

            $d = array(
                'id_rental_org' => $this->app_id,
                'id_rent'       => $this->getIdRentIn('accessories'),
                'name'          => $accessory['name'],
                'type'          => $accessory['type'],
                'value'         => $accessory['value']
            );

            $result = $this->pDB->set($sql, $d);

            $log = $result ? "set accesory completed" : "set accesory failed";

            $this->writeLog($log);

            return $result;
        };

        $id = $this->findIdRentIn('accessories', $accessory['id_rent']);

        if (!$id) {
            $this->writeLog('Accessory: id_rent is not found. Make new Accessory', 'id_rent = ', $accessory['id_rent']);
        } else {
            $this->writeLog('Accessory: id_rent is found. Make update this accessory');
        }

        return $id ? $update($accessory) : $newAccessory($accessory);
    }

    private function deleteAccessory($id_rent)
    {
        $sql = '
            DELETE 
            FROM `accessories` 
            WHERE `id_rent` = :id_rent
            AND `id_rental_org` = :id_rental_org
        ';

        $d = array(
            'id_rent' => $id_rent,
            'id_rental_org' => $this->app_id
        );

        $result = $this->pDB->set($sql, $d);

        if ($result) {
            $this->writeLog("function Delete successfully completed. Accessory id_rent($id_rental) was deleted");
        } else {
            $this->writeLog("function Delete failed. Accessory id_rent($id_rent) was not deleted");
        }
    } 
}
