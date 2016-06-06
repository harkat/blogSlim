
<section>
	<article>
	   	<div id="art1">
				<h3>Staistiques</h3>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
				['Catégorie', 'Pourcentage']
				        <?php
						
						$billets = app\model\Billet::all();
						if (count($billets) < 1) echo ",[ 'aucune publication' , '1' ] "; 
							else {
				        $cat = app\model\Categorie::all();												
							foreach ($cat as $v1) {
								$billet = app\model\Billet::where('id_categorie', 'like', $v1->id)->get();
								$a = $v1->label ;
								$b = count($billet);
							echo ",['$a' , $b ] "; }}?>
				        ]);
        var options = {
          title: 'Répartition des billets par catégorie',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
  	</div>
	</article>
</section>