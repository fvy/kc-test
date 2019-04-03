<?php


namespace fvy\Korus\Db;


class DbMapper
{
    public static $db;

    private $strDate;
    private $strDateArr;

    function __construct($db)
    {
        self::$db = $db;
    }

    public function setStrDate($date)
    {
        $this->strDate = $date;
    }

    public function getStrDate()
    {
        return $this->strDate;
    }

    /**
     * @param null $startDate
     * @param null $endDate
     * @return mixed
     */
    public function usersList($startDate = null, $endDate = null)
    {
        // pass without the dates
        if (empty($startDate) && empty($endDate)) {
            return self::usersListWoTime();
        }

        // filter the dates
        $startDate = $this->filterTheDate($startDate);
        $endDate = $this->filterTheDate($endDate);

        // go with period
        $dateStr = (!empty($startDate) ? 'AND `Date` >= :startDate' : '') . ' ' .
            (!empty($endDate) ? 'AND `Date` <= :endDate' : '');

        $this->setStrDate($dateStr);

        $sth = self::$db->prepare('
            SELECT 
                Id, `Name`, Email, userlvl(id) AS path, EmployerId, 
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
        $this->strDateArr = $array;
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
                Id, `Name`, Email, userlvl(id) AS path, EmployerId, 
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
     * @return mixed
     */
    public function filterTheDate($date)
    {
        if (empty($date)) return false;
        $date_arr = explode("-", $date);
        return (checkdate($date_arr[1], $date_arr[2], $date_arr[0])) ? $date : false;
    }

    public function checkUserMissedHours()
    {
        $dateStr = $this->getStrDate();
        $sql = '
        SELECT 
        EployeeId, TIME_FORMAT(sum(`Time`), "%H:%i:%s") utime, `Date`
        FROM timesheet 
        WHERE `Time`>"00:00:00" AND `Time`<"08:00:00"
                ' . $dateStr . '
        GROUP BY EployeeId,`Date`
        ORDER BY EployeeId,`Date`
        ';
        $sth = self::$db->prepare($sql);
        $sth->execute($this->strDateArr);

        $arr = [];
        foreach ($sth->fetchAll() as $val) {
            $tmp = "<div class=\"row table__row\">";
            $tmp .= "<div class=\"col-xs-6\">" . $val['Date'] . "</div>";
            $tmp .= "<div class=\"col-xs-6\">" . $val['utime'] . "</div>";
            $tmp .= "</div>";
            if (isset($arr[$val['EployeeId']])) {
                $arr[$val['EployeeId']] .= $tmp;
            } else {
                $arr[$val['EployeeId']] = $tmp;
            }
        }
        return $arr;
    }

    public static function insert()
    {

    }
}