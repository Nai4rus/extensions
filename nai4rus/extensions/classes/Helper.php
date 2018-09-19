<?php
namespace Nai4rus\Extensions\Classes;


class Helper
{

    /**
     * варианты написания для количества 1, 2 и 5
     *
     * @param $number
     * @param $prupal
     * @return mixed
     */
    public static function prupals($number, $prupal) {
        $cases = array( 2, 0, 1, 1, 1, 2 );
        return (string)$prupal[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }

    public static function humanTime($date) {
        $time = strtotime($date);
        $now = time();
        $minute = 60;
        $hour = 60 * 60;
        $day = $hour * 24;
        $week = $day * 7;
        $month = $day * 30;
        $text = ' назад';
        $options = [
            1 => [
                'prupal'  => [ 'минуту', 'минуты', 'минут' ],
                'time'    => $hour,
                'divider' => $minute,
            ],
            2 => [
                'prupal'  => [ 'час', 'часа', 'часов' ],
                'time'    => $day,
                'divider' => $hour,
            ],
            3 => [
                'prupal'  => [ 'день', 'дня', 'дней' ],
                'time'    => $week,
                'divider' => $day,
            ],
            4 => [
                'prupal'  => [ 'неделю', 'недели', 'недель' ],
                'time'    => $month,
                'divider' => $week,
            ],
        ];

        foreach ($options as $key => $option) {
            if ($now - $time < $minute) {
                return 'только что';
            } elseif ($time - ($now - $option['time']) > $option['divider']) {
                $return = round(($now - $time) / $option['divider'], 0);
                return $return . ' ' . self::prupals($return, $option['prupal']) . $text;
            }
        }
    }
}