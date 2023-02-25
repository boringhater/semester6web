<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph-4.4.1/src/jpgraph.php');
require_once ('jpgraph-4.4.1/src/jpgraph_bar.php');

$pdo = new PDO('mysql:host=localhost;dbname=t91552yt_project', 't91552yt_project', 'Vertrigo123');
//$pdo = new PDO("mysql:host=localhost;dbname=semester_project", 'root', 'vertrigo');


$stmt = $pdo->prepare("SELECT `language_name` as `fromlang`, count(*) as `quantity` from `orders` join `languages` on(`orders`.`from_lang_id` = `languages`.`language_id`) group by `from_lang_id`;");
$stmt->execute();

$res = $stmt->fetchAll();

$pdo = null;

$datay=array_column($res, 'quantity');

// Create the graph. These two calls are always required
$graph = new Graph(1300,300,'auto');
$graph->SetScale("textlin");

//$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());

// set major and minor tick positions manually
$graph->yaxis->SetTickPositions($datay);
$graph->SetBox(false);

//$graph->ygrid->SetColor('gray');
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array_column($res, 'fromlang'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($datay);

// ...and add it to the graPH
$graph->Add($b1plot);


$b1plot->SetColor("white");
//$b1plot->SetFillGradient("#4B0082","white",GRAD_LEFT_REFLECTION);
$b1plot->SetWidth(45);

// Display the graph
$graph->Stroke();
?>