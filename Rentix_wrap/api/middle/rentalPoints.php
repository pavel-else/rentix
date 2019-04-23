<?php

trait RentalPoints
{
    private function getRentalPoints() 
    {
        $sql = '
            SELECT * 
            FROM `rental_points` 
            WHERE `id_rental_org` = :id_rental_org
        ';

        $d = array (
            'id_rental_org' => $this->org_id
        );

        $result = $this->pDB->get($sql, false, $d);
        
        $log = $result ? "getRentalPoints completed" : "getRentaPoints failed";

        $this->writeLog($log);

        return $result;
    }

    // private function setRentalPointInfo($point)
    // {
    //     if (empty($pointInfo)) {
    //         $this->writeLog('setRentalInfo is fail! Empty value');
    //     }

    //     $sql = '
    //         UPDATE `rental_points` 
    //         SET 
    //             `name` = :name,
    //             `city` = :city,
    //             `address` = :address,
    //             `time_open` = :time_open,
    //             `time_close` = :time_close,
    //             `phone` = :phone,
    //             `description` = :description,
    //             `coordinates` = :coordinates
    //         WHERE `id_rent` = :id_rent
    //     ';

    //     $d = array(
    //         'name' => $point['name'],
    //         'city' => $point['city'],
    //         'address' => $point['address'],
    //         'time_open' => $point['time_open'],
    //         'time_close' => $point['time_close'],
    //         'phone' => $point['phone'],
    //         'description' => $point['description'],
    //         'coordinates' => $point['coordinates'],
    //         'id_rent' => $this->app_id,
    //     );

    //     $result = $this->pDB->set($sql, $d);

    //     $log = $result ? 'setRentalPointInfo is successfuly compleated' : 'setRentalPointInfo is fail';
    //     $this->writeLog($log);

    //     return $result;
    // }
}
