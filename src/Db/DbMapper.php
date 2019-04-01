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

    public static function usersList($startDate = null, $endDate = null)
    {
        if (empty($startDate) && empty($endDate)) {
            return self::usersListWoTime();
        }

        $sth = self::$db->prepare('
            SELECT 
                Id, Name, Email, userlvl(id) AS path, EmployerId, 
                TIME_FORMAT(
                    (select sum(`Time`) from timesheet WHERE id=EployeeId ' .
            (!empty($startDate) ? 'AND `Date` >= :startDate' : '') . ' ' .
            (!empty($endDate) ? 'AND `Date` <= :endDate' : '') . '
                    ), "%H:%i:%s"
                ) utime, 
                Info
            FROM 
                users u
            WHERE 
                u.Id in (select EployeeId from timesheet WHERE 1=1 ' .
            (!empty($startDate) ? 'AND `Date` >= :startDate' : '') . ' ' .
            (!empty($endDate) ? 'AND `Date` <= :endDate' : '') . '
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

    public static function usersListWoTime($startDate = null, $endDate = null)
    {
        $sth = self::$db->prepare('
            SELECT 
                Id, Name, Email, userlvl(id) AS path, EmployerId, 
                TIME_FORMAT(
                    (select sum(`Time`) from timesheet WHERE id=EployeeId), "%H:%i:%s"
                ) utime, 
                Info
            FROM 
                users u
            WHERE 
                1=1                    
            ORDER BY path
            ');

        $sth->execute();

        return $sth->fetchAll();
    }
}