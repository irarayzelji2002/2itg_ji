<!DOCTYPE html> <!--html! tab-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taxxy: A Tax Calculator Wep App</title>

    <!--Bootstrap CSS CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!--Bootstrap JavaScript CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <!--Google Font-Roboto-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
        font-family: 'Montserrat', sans-serif;
        font-size: 20px;
        color: white;
    }

    body {
        width: 100%;
        min-height: 93.8vh;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-image: linear-gradient(rgba(0,0,0,0.45),rgba(0,0,0,0.45)),url(bg.jpg);
    }

    label {
        font-weight: 600;
    }

    .card {
        background: rgba(255, 255, 255, 0.17);
        border-radius: 16px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10.5px);
        -webkit-backdrop-filter: blur(10.5px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: 800;
    }

    h4, h5, h6 {
        font-weight: 700;
    }

    th, td {
        padding-bottom: 10px;
        padding-left: 18px;
        padding-right: 18px;
    }

    th {
        font-weight: 600;
    }

    td {
        font-weight: 400;
    }
    </style>

</head>
<body>
    <?php
    //Variables
    $salary = $type = $annualSalary = $annualTax = $monthlyTax = "";
    $salaryErr = $typeErr = "";
    $additional = $excess = $percent = "0";
    
    function roundTwoDecimals($number) {
        return number_format((float)$number, 2, '.', '');
    }

    //Form Submit
    if (isset($_POST['submit'])) {
        //Validate salary
        if (empty($_POST['salary'])) {
            $salaryErr = "Salary is required.";
        } else {
            if (is_numeric($_POST['salary']) && $_POST['salary']>0) {
                $salary = filter_input(INPUT_POST, 'salary',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            } else {
                $salaryErr = "Salary must be a positive number.";
            }
        }

        //Validate type
        if (empty($_POST['type'])) {
            $typeErr = "Type is required.";
        } else {
            $type = filter_input(INPUT_POST, 'type',FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
        }

        //Compute
        if (empty($salaryErr) && empty($typeErr)) {
            if ($type=="Monthly"){
                $annualSalary = $salary * 12;
            }
            else { //Bi-Monthy
                $annualSalary = $salary * 24;
            }
            //Rates
            if ($annualSalary<250000) {
                $additional = "0"; $excess = 0; $percent = "0";}
            else if ($annualSalary<400000) {
                $additional = "0"; $excess = 250000; $percent = "0.20";}
            else if ($annualSalary<800000) {
                $additional = "30000"; $excess = 400000; $percent = "0.25";}
            else if ($annualSalary<2000000) {
                $additional = "130000"; $excess = 800000; $percent = "0.30";}
            else if ($annualSalary<8000000) {
                $additional = "490000"; $excess = 2000000; $percent = "0.32";}
            else { //>8000000
                $additional = "2410000"; $excess = 8000000; $percent = "0.35";}
            //Formula
            $annualTax = (($annualSalary - $excess) * $percent) + $additional;
            $monthlyTax = $annualTax / 12;
            //Round to two decimal places
            $annualSalary = roundTwoDecimals($annualSalary);
            $annualTax = roundTwoDecimals($annualTax);
            $monthlyTax = roundTwoDecimals($monthlyTax);
        }
    }

    //Form Reset
    if (isset($_POST['reset'])) {
        $_POST = array();
        $annualSalary = $annualTax = $monthlyTax = "0.00";
    }
    ?>

    <h2 class="my-5 text-center" style="color:white; filter: drop-shadow(0 2mm 4mm rgb(0, 0, 0));">Taxxy: A Tax Calculator</h2>

    <div class="row justify-content-center align-items-center g-0 mb-5">
      <div class="card col-md-7 col-sm-10 p-5 mb-5">

        <h4>Step 1: Enter your details.</h4>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
            <!--Salary-->
            <div class="m-3">
                <label for="salary" class="form-label">Salary (PHP)</label>
                <input type="text" class="form-control <?php echo $salaryErr ? 'is-invalid' : null; ?>" id="salary" name="salary" placeholder="Enter your salary">
                <div class="text-danger">
                    <small style="color: rgb(220,126,128)"><?php echo $salaryErr; ?></small>
                </div>
            </div>
            <!--Type-->
            <div class="m-3">
                <label for="type" class="form-label">Type</label>

                <div style="display:block;">
                    <input type="radio" id="type" name="type" style="margin-right:8px;" value="Bi-Monthly">
                    <label for="type-a" style="margin-right:2rem; font-weight:400;">Bi-Monthly</label>
                    <input type="radio" id="type" name="type"  style="margin-right:8px;" value="Monthly">
                    <label for="type-b" style="font-weight:400;">Monthly</label>
                </div>

                <div class="text-danger">
                    <small style="color: rgb(220,126,128)"><?php echo $typeErr; ?></small>
                </div>
            </div>
            <!--Button-->
            <div class="gt-3 m-3 text-center">
                <input type="submit" name="submit" value="Compute" class="btn btn-info px-5 m-3">
                <input type="submit" name="reset" value="Reset" class="btn btn-outline-light px-5 m-3">
            </div>
        </form>

        <h4 class="mt-4">Step 2: See your estimated tax below.</h4>
        <table border="0">
            <tr>
                <th>Annual Salary</th>
                <td><?php echo "PHP " . $annualSalary; ?></td>
            </tr>
            <tr>
                <th>Annual Tax</th>
                <td><?php echo "PHP " . $annualTax; ?></td>
            </tr>
            <tr>
                <th>Estimated Monthly Salary</th>
                <td><?php echo "PHP " . $monthlyTax; ?></td>
            </tr>
        </table>

      </div>
    </div>
</body>
</html>