<?php
/*
 *      class_utility.php
 *      
 *      Copyright 2012 budi_prasetyo <bprast1@yahoo.co.id>
 *      
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *      
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *      
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 *      
 *      
 */


class class_utility
{

	/**
	 * Constructor of class class_utility.
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}

	// show month not in numeric
	
	public function month($bulan){
		switch($bulan){
			case 1:
			echo "Januari";
			break;
			case 2:
			echo "Februari";
			break;
			case 3:
			echo "Maret";
			break;
			case 4:
			echo "April";
			break;
			case 5:
			echo "Mei";
			break;
			case 6:
			echo "Juni";
			break;
			case 7:
			echo "Juli";
			break;
			case 8:
			echo "Agustus";
			break;
			case 9:
			echo "September";
			break;
			case 10:
			echo "Oktober";
			break;
			case 11:
			echo "November";
			break;
			case 12:
			echo "Desember";
			break;
		}
	}
		
	
	// function for converting date format
	
	public function dateConvert($date){
		if(strstr($date,"/") || strstr($date,".")){
			$date = preg_split("/[\/]|[.]+/",$date);
			$date = $date[2] . "-" . $date[1] . "-" . $date[0];
			return $date;
		}
		elseif(strstr($date,"-")){
			$date = preg_split("/[-]+/",$date);
			$date = $date[2] . "-" . $date[1] . "-" . $date[0];
			return $date;
		}	
	}
	
	// function count words
	function countWords($str)
	{
		$words = 0;
		$str = eregi_replace(" +", " ", $str); // sanitize when space more than one
		$array = explode(" ", $str);
		for($i=0;$i < count($array);$i++)
		{
			if (eregi("[0-9A-Za-zÀ-ÖØ-öø-ÿ]", $array[$i]))
			$words++;
		}
		return $words;
	}
}
