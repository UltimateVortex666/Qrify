<? php
session_start();
	$con = mysqli_connect('localhost','username','','database name');
	use phpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\xlsx;

	if(isset($_POST['save_excel_data']))
	{
		$fileName = $_FILES['import_file']['name'];
		$file_ext = pathinfo($fileName,PATHINFO_EXTENSION);

		$allowed_ext = ['xls','csv','xlsx'];

		if(in_array($file_ext,$allowed_ext))
		{
			$inputFileNamePath = $_Files['import_file']['tmp_name'];
			$spreedsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
			$spreadsheet->getActivesheet()->toArray();

			$count = "0";

			foreach($data as $row)
			{
				if($count>0)
				{

				$Registration = $row['0'];
				$Name = $row['1'];
				$email = $row['2'];

				$studentQuery = "INSERT INTO students(Registration,Name,email) VALUES ('$Registration','$Name','$email')";

				$result = mysqli_query($con,$studentQuery);

				$msg = true;
				}
				else
				{
					$count = "1";
				}

			}

			if(isset($msg))
			{
				$_SESSION['message']="Successfully imported";
				header('Location:index.php');
				exit(0);
			}
			else
			{
				$_SESSION['message']="Not Imported";
				header('Location:index.php');
				exit(0);
			}
		}
		else
		{
			$_SESSION['message'] = "Invalid file";
			header('Location: index.php');
			exit(0);
		}
	}
?>