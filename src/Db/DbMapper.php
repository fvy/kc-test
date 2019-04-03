<?php


namespace fvy\Korus\Db;


class DbMapper
{
    public static $db;

    function __construct($db)
    {
        self::$db = $db;
    }

    public static function insert()
    {

    }

    /**
     * @param null $startDate
     * @param null $endDate
     * @return mixed
     */
    public static function usersList($startDate = null, $endDate = null)
    {
        // pass without the dates
        if (empty($startDate) && empty($endDate)) {
            return self::usersListWoTime();
        }

        // filter the dates
        $startDate = self::filterTheDate($startDate);
        $endDate = self::filterTheDate($endDate);

        // go with period
        $dateStr = (!empty($startDate) ? 'AND `Date` >= :startDate' : '') . ' ' .
            (!empty($endDate) ? 'AND `Date` <= :endDate' : '');

        $sth = self::$db->prepare('
            SELECT 
                Id, Name, Email, userlvl(id) AS path, EmployerId, 
                TIME_FORMAT(
                    (select sum(`Time`) from timesheet WHERE id=EployeeId ' . $dateStr . '
                    ), "%H:%i:%s"
                ) utime, 
                TIME_FORMAT(
                    (SELECT sum(`Time`) 
                    FROM users
                    LEFT JOIN timesheet ON (Id=EployeeId)
                    WHERE userlvl(id) LIKE CONCAT(CONVERT(path using utf8),"%") ' . $dateStr . '
                    ), 
                    "%H:%i:%s"
                ) AS totalsum,
                Info
            FROM 
                users u
            WHERE 
                u.Id in (select EployeeId from timesheet WHERE 1=1 ' . $dateStr . '
                )                     
            ORDER BY path
            ');


        $array = [];
        if (!empty($startDate)) $array += [':startDate' => $startDate];
        if (!empty($endDate)) $array += [':endDate' => $endDate];

        $sth->execute($array);
        //$sth->debugDumpParams();

        return $sth->fetchAll();
    }

    /**
     * @param null $startDate
     * @param null $endDate
     * @return mixed
     */
    public static function usersListWoTime($startDate = null, $endDate = null)
    {
        $sth = self::$db->prepare('
            SELECT 
                Id, Name, Email, userlvl(id) AS path, EmployerId, 
                TIME_FORMAT(
                    (select sum(`Time`) from timesheet WHERE id=EployeeId), "%H:%i:%s"
                ) AS utime,
                TIME_FORMAT(
                    (SELECT sum(`Time`) 
                    FROM users
                    LEFT JOIN timesheet ON (Id=EployeeId)
                    WHERE userlvl(id) LIKE CONCAT(CONVERT(path using utf8),"%")), 
                    "%H:%i:%s"
                ) AS totalsum,
                Info
            FROM 
                users u
            WHERE 
                1=1                    
            ORDER BY path
            ');

        $sth->execute();
        //$sth->debugDumpParams();
        return $sth->fetchAll();
    }

    /**
     * @param $date
     * @return bool
     */
    public static function filterTheDate($date)
    {
        if (empty($date)) return false;
        $date_arr = explode("-", $date);
        return (checkdate($date_arr[1], $date_arr[2], $date_arr[0]))? $date : false;
    }
}