<?php

trait Repairs
{
    private function getRepairs()
    {
        $sql = '
            SELECT *
            FROM `repairs`
            WHERE `id_rental_org` = :id_rental_org
        ';

        $d = array (
            'id_rental_org' => $this->app_id,
        );

        $result = $this->pDB->get($sql, false, $d);

        $log = $result ? "getRepairs is completed" : "getRepairs is failed";

        return $result;
    }

    /*
    * Функция - обертка
    * Проверяет id ремонта и вызывает соответсвующую функцию
    */
    private function setRepair($repair)
    {
        $id = $this->findIdRentIn('repairs', $repair['id_rent']);

        if (!$id) {
            $this->writeLog('Repairs: id_rent is not found. Make new repair', 'id_rent = ', $repair['id_rent']);
        } else {
            $this->writeLog('Repairs: id_rent is found. Make update this repair', 'id_rent = ', $id);
        }

        return $id ? $this->updateRepair($repair) : $this->newRepair($repair);
    }

    private function newRepair($repair)
    {
        $sql = '
            INSERT INTO `repairs` (
            `id`,
            `id_rent`,
            `id_rental_org`,
            `product_id`,
            `mileage`,
            `repair_type`,
            `cost_comp`,
            `cost_work`,
            `note`,
            `status`,
            `start_time`,
            `end_time`,
            `updated`,
            `created`
        ) VALUES (
            NULL,
            :id_rent,
            :id_rental_org,
            :product_id,
            :mileage,
            :repair_type,
            :cost_comp,
            :cost_work,
            :note,
            :status,
            :start_time,
            :end_time,
            :updated,
            :created
        )';

        $d = array(
            'id_rent'       => $this->getIdRentIn('repairs'),
            'id_rental_org' => $this->app_id,
            'product_id'    => $repair['product_id'],
            'mileage'       => 0,
            'repair_type'   => $repair['repair_type'],
            'cost_comp'     => $repair['cost_comp'],
            'cost_work'     => $repair['cost_work'],
            'note'          => $repair['note'],
            'status'        => $repair['status'],
            'start_time'    => $repair['start_time'],
            'end_time'      => $repair['end_time'],
            'updated'       => date("Y-m-d H:i:s"),
            'created'       => date("Y-m-d H:i:s"),
        );

        $result = $this->pDB->set($sql, $d);

        $log = $result ?
            'new Repair: successfully completed!':
            'new Repair: failed!';

        $this->writeLog($log);

        if ($result) {
            // Убрать велосипед из списка Активных
            $this->updateProductStatus($repair['product_id'], 'off');
        }

        return $result;
    }

    private function updateRepair($repair)
    {
        $sql = '
            UPDATE `repairs`
            SET
                `product_id`  = :product_id,
                `mileage`     = :mileage,
                `repair_type` = :repair_type,
                `cost_comp`   = :cost_comp,
                `cost_work`   = :cost_work,
                `note`        = :note,
                `status`      = :status,
                `start_time`  = :start_time,
                `end_time`    = :end_time,
                `updated`     = :updated
            WHERE
                `id_rent` = :id_rent
            AND
                `id_rental_org` = :id_rental_org
        ';

        $d = array(
            'id_rent'       => $repair['id_rent'],
            'id_rental_org' => $this->app_id,
            'product_id'    => $repair['product_id'],
            'mileage'       => $repair['mileage'],
            'repair_type'   => $repair['repair_type'],
            'cost_comp'     => $repair['cost_comp'],
            'cost_work'     => $repair['cost_work'],
            'note'          => $repair['note'],
            'status'        => $repair['status'],
            'start_time'    => $repair['start_time'],
            'end_time'      => $repair['end_time'],
            'updated'       => date("Y-m-d H:i:s")
        );

        $result = $this->pDB->set($sql, $d);

        if ($result) {
            $this->writeLog("updateRepair is completed.");
        } else {
            $this->writeLog("updateRepair is failed.");
        }

        return $result;
    }

    private function stopRepair($repair) {
        $isUpdatedRepair = $this->updateRepair($repair);

        if ($isUpdatedRepair) {
            $isUpdatedProduct = $this->updateProductStatus($repair['product_id'], 'active');
        }

        if ($isUpdatedProduct && $isUpdatedRepair) {
            $this->writeLog("stopRepair is completed.");
        } else {
            $this->writeLog("stopRepair is failed.");
        }

        return $result;
    }

    private function updateProductStatus($id_rent, $status)
    {

        $this->writeLog('updateProductStatus', 'id_rent=', $id_rent, 'status=', $status);
        $sql = '
            UPDATE `products`
            SET
                `status` = :status
            WHERE
                `id_rent` = :id_rent
            AND
                `id_rental_org` = :id_rental_org
        ';

        $d = array(
            'id_rent' => $id_rent,
            'id_rental_org' => $this->app_id,
            'status' => $status
        );

        $result = $this->pDB->set($sql, $d);

        if ($result) {
            $this->writeLog("updateProductStatus completed.");
        } else {
            $this->writeLog("updateProductStatus failed.");
        }

        return $result;
    }
}
