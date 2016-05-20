<?php // content="text/plain; charset=utf-8"
require_once ('../../jpgraph/src/jpgraph.php');
require_once ('../../jpgraph/src/jpgraph_line.php');

$datay1 = array(0,2.19,3.77,6.42,10.41,14.67,20.53,28,38.8,47.2,48.3,49.68,57.56,70.97,91.68,100);
$datay2 = array(0,1.5,3.77,6.45,10.3,12.5,28,36.8,47.78,48.30,50.88,57.56,85,100);

// Setup the graph
$graph = new Graph(740,600);
$graph->SetScale("textlin");
$theme_class= new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->title->Set('S-Curve');
$graph->SetBox(false);

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xaxis->SetTickLabels(array('30 Sep','7 Okt','14 Okt','21 Okt','28 Okt','4 Nov','11 Nov','18 Nov','25 Nov','2 Des','9 Des','16 Des','23 Des','30 Des','6 Jan','13 Jan','20 Jan'));
$graph->ygrid->SetFill(false);

$p1 = new LinePlot($datay1);
$graph->Add($p1);

$p2 = new LinePlot($datay2);
$graph->Add($p2);

$p1->SetColor("#55bbdd");
$p1->SetLegend('Plan');
$p1->mark->SetType(MARK_FILLEDCIRCLE,'',1.0);
$p1->mark->SetColor('#55bbdd');
$p1->mark->SetFillColor('#55bbdd');
$p1->SetCenter();

$p2->SetColor("#aaaaaa");
$p2->SetLegend('Actual');
$p2->mark->SetType(MARK_UTRIANGLE,'',1.0);
$p2->mark->SetColor('#aaaaaa');
$p2->mark->SetFillColor('#aaaaaa');
$p2->value->SetMargin(14);
$p2->SetCenter();

$graph->legend->SetFrameWeight(1);
$graph->legend->SetColor('#4E4E4E','#00A78A');
$graph->legend->SetMarkAbsSize(8);


// Output line
$graph->Stroke();

?>

