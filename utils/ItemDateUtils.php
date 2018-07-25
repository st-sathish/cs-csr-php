<?php
class ItemDateUtils {
	
	public static function get_notification_dates() {
		$two_weeks_date = date('m/d/Y' , strtotime("+2 weeks"));
		$next_month_date = date('m/d/Y' , strtotime("+1 Months"));
		$third_month_date = date('m/d/Y' , strtotime("+3 Months"));
		$date_list = array($two_weeks_date, $next_month_date, $third_month_date);
		return $date_list;
	}
}