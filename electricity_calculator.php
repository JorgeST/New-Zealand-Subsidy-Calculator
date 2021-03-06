<?php
require_once 'Calculator.php';

/*List of electricity companies*/
$mercury = array("name"=>"Mercury", "rates"=> [3.4,5.0,6.2]);
$genesis = array("name"=>"Genesis", "rates"=> [3.2,5.22,6.11]);
$kea = array("name"=>"Kea Energy", "rates"=> [3.12,5.3,6.23]);
$lightforce = array("name"=>"Lightforce Power", "rates"=> [3.32,5.33,6.8]);
$nova = array("name"=>"Nova Energy", "rates"=> [3.43,5.12,6.74]);
$orcon = array("name"=>"Orcon Power", "rates"=> [3.42,5.22,6.45]);

$companies = array($mercury,$genesis,$kea,$lightforce,$nova,$orcon);


/*List of regions*/
$manawatu = array("name"=>"Manawatu","subsidy"=>0.051);
$wanganui = array("name"=>"Wanganui","subsidy"=>0.080);
$northland = array("name"=>"Northland","subsidy"=>0.043);
$auckland = array("name"=>"Auckland","subsidy"=>0.03);
$waikato = array("name"=>"Waikato","subsidy"=>0.034);
$bay_of_plenty = array("name"=>"Bay of Plenty","subsidy"=>0.02);
$gisborne = array("name"=>"Gisborne","subsidy"=>0.04);
$hawkes_bay = array("name"=>"Hawke's Bay","subsidy"=>0.032);
$taranaki = array("name"=>"Taranaki","subsidy"=>0.031);
$wellington = array("name"=>"Wellington","subsidy"=>0.04);
$tasman = array("name"=>"Tasman","subsidy"=>0.04);
$nelson = array("name"=>"Nelson","subsidy"=>0.045);
$marlborough = array("name"=>"Wellington","subsidy"=>0.04);
$west_coast = array("name"=>"Marlborough","subsidy"=>0.076);
$canterbury = array("name"=>"Canterbury","subsidy"=>0.033);
$otago = array("name"=>"Otago","subsidy"=>0.047);
$southland = array("name"=>"Southland","subsidy"=>0.048);
$regions = array($manawatu,$wanganui,$northland,$auckland,$waikato,$bay_of_plenty,$gisborne,$hawkes_bay,$taranaki,$wellington,$tasman,$nelson,$marlborough,$west_coast,$canterbury,$otago,$southland);

$action = (isset($_GET['action'])) ? $_GET['action'] : 'home';
$message = "";

/**
* This gets us the rates from a specific company
*
* @param $name is the name of a company
* @return array of integers representing the cost rates of a company
*/

function getCompanyRates(string $name):array
{
    global $companies;

    foreach ($companies as $company)
    {
        if ($company["name"]== $name)
        {
            return $company["rates"];
        }
        else
            {
                return [];
            }
    }
}


if ($action == "calculate")
{
   $company = $_POST['company'];
   $region = $_POST['region'];
   $usage = $_POST['usage'];

   $calculator = new Calculator(intval($usage),getCompanyRates($company),$region);

    $totalToPay = $calculator->getTotalCost();
    $totalSaved = $calculator->getSavings();

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calculate your electricity consumption during COVID 19</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>

<div class="container">
    <img src="https://covid19.govt.nz/assets/Uploads/COVID19_logo_english.jpg" style="display: block; width: 30%; margin-left: 35%;">
    <div style="border:10px dashed #FFCC00;">
        <div style="border:10px dashed black;">
            <div style="border:10px dashed #FFCC00; padding: 70px;">
                <h1>Find out how much your local council is helping you during this COVID lockdown</h1>
                <form >
                    <div class="form-group">
                        <label for="electricityUsage">kWh per day</label>
                        <input type="email" class="form-control electricity-usage" aria-describedby="50kWh" placeholder="Enter kWh per day">
                    </div>
                    <div class="form-group">
                        <label for="companyName">Company</label>
                        <select class="form-control form-control-lg company-name">
                            <?php foreach ($companies as $company):?>
                                <option value="<?php echo($company["name"]);?>"><?php echo($company["name"]);?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="regionName">Region</label>
                        <select class="form-control form-control-lg region-name">
                            <?php foreach ($regions as $region):?>
                                <option value="<?php echo($region["subsidy"]);?>"><?php echo($region["name"]);?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <button class="btn btn-lg btn-primary calculate" style="text-align: center; display: block; width: 200px; margin: 0px auto;">Calculate</button>
                </form>
                <?php if ($action == "calculate"):?>
                    <h1 style="text-align: center; font-weight: bold;">You will be paying $<?php echo($totalToPay);?> per day</h1>
                    <h2 style="text-align: center;">You are saving $<?php echo($totalSaved);?> per day</h2>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        $('.calculate').on('click', function(e){
            e.preventDefault();
            console.log("HERE");
            var $btn = $(this);
            var company = $btn.parent().parent().find('.company-name').val();
            var region = $btn.parent().parent().find('.region-name').val() || '';
            var usage = $btn.parent().parent().find('.electricity-usage').val() || '';
            var $form = $('<form action="?action=calculate" method="post" />').html('<input type="hidden" name="company" value="' + company + '"><input type="hidden" name="region" value="' + region + '"><input type="hidden" name="usage" value="' + usage + '">');
            $('body').append($form);
            $form.submit();
        });
    });
</script>
</body>
</html>