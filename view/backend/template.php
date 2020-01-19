<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>ReportMe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/styles-admin.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alex+Brush&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <?= $content ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/AjaxRequest.js"></script>
    <script src="js/Graphe.js"></script>
    <script src="js/CallButton.js"></script>
    <script src="js/Plot.js"></script>
    <script src="js/PlotSpend.js"></script>
    <script src="js/PlotLead.js"></script>
    <script src="js/PlotCostPerLead.js"></script>
    <script src="js/LogForm.js"></script>
    <script src="js/App.js"></script>
    <script src="js/main.js"></script>
    <?php
    if (isset($scripts)):; ?>
        <?= $scripts ?>
    <?php endif; ?>

    </body>
</html>