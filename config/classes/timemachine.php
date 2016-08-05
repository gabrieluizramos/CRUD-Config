<?php
class TimeMachine{

	public static function formatFullDate( $date ){
		return date( "m/d/Y" , strtotime( $date ) );
	}

	public static function formatFullTime( $time ){
		return date( "H:i:s" , strtotime( $time ) );
	}

	public static function consultWeekDay( $day ){
		$weekDays = array( 'Domingo' , 'Segunda-feira' , 'Terça-feira' , 'Quarta-feira' , 'Quinta-feira' , 'Sexta-feira' , 'Sábado' );
		return $weekDays[ $day ];
	}

	public static function getWeekDay( $date , $number = false ){
		if ( $number ) {
			return date( "w" , strtotime( TimeMachine::formatFullDate( $date ) ) );			
		}
		else{
			return TimeMachine::consultWeekDay( ( date( "w" , strtotime( TimeMachine::formatFullDate( $date ) ) ) ) );
		}	
	}

	public static function consultMonthName( $month ){
		$months = array( 'Janeiro' , 'Fevereiro' , 'Março' , 'Abril' , 'Maio' , 'Junho' , 'Julho' , 'Agosto' , 'Setembro' , 'Outubro' , 'Novembro' , 'Dezembro' );
		return $months[ $month - 1 ];
	}

	public static function getMonth( $date , $number = false ){

		$month = TimeMachine::formatFullDate( $date );
		$month = explode( '/' , $month );
		$month = $month[ 0 ];

		if ( $number ) {
			return $month;
		}
		else{
			return TimeMachine::consultMonthName( $month );
		}	
	}

	public static function getFullYear( $date ){
		$year = TimeMachine::formatFullDate( $date );
		$year = explode( '/' , $year );
		$year = $year[ 2 ];
		return $year;
	}

	public static function getMonthDay( $date ){
		$day = TimeMachine::formatFullDate( $date );
		$day = explode( '/' , $day );
		$day = $day[ 1 ];
		return $day;
	}
}
?>