<?php

namespace Mini\Libs;

class Helper
{
    /**
     * debugPDO
     *
     * Shows the emulated SQL query in a PDO statement. What it does is just extremely simple, but powerful:
     * It combines the raw query and the placeholders. For sure not really perfect (as PDO is more complex than just
     * combining raw query and arguments), but it does the job.
     *
     * @author Panique
     * @param string $raw_sql
     * @param array $parameters
     * @return string
     */
    public static function debugPDO($raw_sql, $parameters = null)
    {
        $keys = array();
        $values = $parameters;

        foreach ($parameters as $key => $value) {

            // check if named parameters (':param') or anonymous parameters ('?') are used
            if (is_string($key)) {
                $keys[] = '/' . $key . '/';
            } else {
                $keys[] = '/[?]/';
            }

            // bring parameter into human-readable format
            if (is_string($value)) {
                $values[$key] = "'" . $value . "'";
            } elseif (is_array($value)) {
                $values[$key] = implode(',', $value);
            } elseif (is_null($value)) {
                $values[$key] = 'NULL';
            }
        }

        /*
        echo "<br> [DEBUG] Keys:<pre>";
        print_r($keys);

        echo "\n[DEBUG] Values: ";
        print_r($values);
        echo "</pre>";
        */

        $raw_sql = preg_replace($keys, $values, $raw_sql, 1, $count);

        return $raw_sql;
    }

    public static function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform  = "Unknown OS Platform";

        $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    public static function getBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        $browser        = "Unknown Browser";

        $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }
}
