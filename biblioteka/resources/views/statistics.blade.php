@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center">
        <div>
            <div id="piechart" data-rents={{ $rents }} style="width: 800px; height: 300px;"></div>
            <div id="curve_chart" style="width: 800px; height: 300px;"></div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        let rents = $('#piechart').data('rents');
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        let counts = rents.reduce((c, {
            status: key
        }) => (c[key] = (c[key] || 0) + 1, c), {});


        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Status', 'Kolicina'],
                ...Object.entries(counts)
            ]);

            var options = {
                title: 'Iznajmmljene protiv vracenih knjiga'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }


        rents.forEach(r => {

            r.formattedDate = `${new Date(r.created_at).getMonth() + 1}.${new Date(r.created_at).getFullYear()}`
            r.quantity = 0;
        })


        let pieChart = {};
        for (const r of rents) {


            pieChart[r.formattedDate] = pieChart[r.formattedDate] ? pieChart[r.formattedDate] + 1 : 1;
        }

        console.log(pieChart);

        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawPieChart);

        function drawPieChart() {
            var data = google.visualization.arrayToDataTable([
                ['Dan', 'Broj iznajmljivanja'],
                ...Object.entries(pieChart).reverse()
            ]);
            var options = {
                title: 'Ukupno iznajmljivanje',
                curveType: 'function',
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    </script>
@endsection
