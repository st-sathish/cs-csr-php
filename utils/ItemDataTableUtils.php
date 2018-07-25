<?php

class ItemDataTableUtils {
	
	public static function formatResult($data) {
		if(!isset($data) || sizeof($data) == 0) {
			return $data;
		}
		$two_weeks_date = date('m/d/Y' , strtotime("+2 weeks"));
		$next_month_date = date('m/d/Y' , strtotime("+1 Months"));
		$third_month_date = date('m/d/Y' , strtotime("+3 Months"));
		$results = array();
		foreach ($data as $datum) {
			if($datum['expiry_date'] == $two_weeks_date) {
				$datum['DT_RowClass'] = 'soon';
			} else if($datum['expiry_date'] == $next_month_date){
				$datum['DT_RowClass'] = 'later';
			} else if($datum['expiry_date'] == $third_month_date) {
				$datum['DT_RowClass'] = 'too-later';
			}
			$results[] = $datum;
		}
		return $results;
	}
}