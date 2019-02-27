<?php

trait GeneralSettings
{
    private function getGeneralSettings()
    {
        $sql = '
            SELECT *  
            FROM `generall_settings` 
            WHERE `id_rental_org` = :id_rental_org
        ';

        $d = array(
            'id_rental_org' => $this->app_id
        );

        $result = $this->pDB->get($sql, 0, $d);
        if ($result) {
            $this->writeLog('getGeneralSettings is compleate');
        } else {
            $this->writeLog('getGeneralSettings is fail');
        }

        return $result;
    }

    private function setGeneralSettings($settings)
    {
        $checkID = function ($name) {
            if (!$name) {
                return null;
            }

            $sql = '
                SELECT `id` 
                FROM `options` 
                WHERE `name` = :name
                AND `id_rental_org` = :id_rental_org
            ';

            $d = array(
                'name' => $name,
                'id_rental_org' => $this->app_id
            );
            
            $result = $this->pDB->get($sql, false, $d);

            return $result[0][id];
        };

        $update = function ($id, $value) {
            $sql = '
                UPDATE `generall_settings` 
                SET 
                    `value`   = :value 
                WHERE `id` = :id
                AND `id_rental_org` = :id_rental_org
            ';

            $d = array(
                'id'            => $id,
                'id_rental_org' => $this->app_id,
                'value'         => $value
            );

            $result = $this->pDB->set($sql, $d);

            if ($result) {
                $this->writeLog("updated setting $id: $value");
            } else {
                $this->writeLog("don`t updated setting $id: $value");
            }

            return $result;
        };

        $setOption = function ($key, $value) {
            $sql = 'INSERT INTO `generall_settings` (
                `id`,
                `id_rent`,
                `id_rental_org`,
                `name`,
                `value` 
            ) VALUES (
                NULL, 
                :id_rent,
                :id_rental_org,
                :name,  
                :value 
            )';

            $d = array(
                'id_rent'       => $this->getIdRentIn('generall_settings'),
                'id_rental_org' => $this->app_id,
                'name'          => $key,
                'value'         => $value
            );

            $result = $this->pDB->set($sql, $d);

            if ($result) {
                $this->writeLog("set setting", $value);
            } else {
                $this->writeLog("don`t set setting", $value);
            }

            return $result;
        };

        foreach ($settings as $key => $value) {            
            $id = $checkID($key);

            if ($id) {
                $update($id, $value);
            } else {
                $setOption($key, $value);
            }
        }
    }
}
