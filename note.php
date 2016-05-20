<? $input=$_GET['input'];
switch($input)
{
	case 1:
	case 2:
	case 3:
	case 4:
		echo "Inputan kurang dari 5
";
	case 5:
		echo "Inputan adalah 5 
";
		break;
	default:
		echo "Inputan Salah
";
} ?>