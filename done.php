<?php

	include 'header.php';
	include 'functions.php';

if (isset($_POST['lobna']))
{
    // Form has been submitted

	saveVacationAgree();
}
else
{
    // Form has not been submitted
    echo"nothing";
}

echo "done";