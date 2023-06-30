<?PHP
namespace App\Utils;

Class WeekHandler
{
	public $week_day;
	public $week_number;
    public static function toNumber($week_day){
        switch ($week_day) {
			case 'seg':
			case 'Seg':
			case 'SEG':
				return 1;
				break;
			case 'ter':
				return 2;
				break;
			case 'qua':
				return 3;
				break;
			case 'qui':
				return 4;
				break;
			case 'sex':
				return 5;
				break;
			case 'sab':
				return 6;
				break;
			
			default:
				return 0;
				break;
		}

    }

	public static function toWeek($week_number){
		switch($week_number){
			case 1:
				return 'seg';
				break;
			case 2:
				return 'ter';
				break;
			case 3:
				return 'qua';
				break;
			case 4:
				return 'qui';
				break;
			case 5:
				return 'sex';
				break;
			case 6:
				return 'sab';
				break;
			case 0:
				return 'dom';
				break;
			default:
				return 'nd';
				break;
	

		}

	}
}