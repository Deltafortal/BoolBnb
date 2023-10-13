@extends('layouts.app')

@section('title', 'Statistics')

@section('main')
    <section id="statistics" class="container">
        {{-- Header --}}
        <header>
            {{-- Title --}}
            <div class="d-flex align-items-center gap-3">
                <h2>Statistiche</h2>
            </div>
            {{-- Back Button --}}
            <div class="circle-button">
                <a href="{{ route('admin.apartments.index') }}">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </div>
        </header>

        <div class="row row-cols-1 row-cols-md-2">

            <!-- Views Per Months -->
            <div class="col mb-4">
                <h5 class="mb-2">Visualizzazioni per mese</h5>
                <div class="border rounded p-2">
                    <canvas id="month-views"></canvas>
                </div>
            </div>

            <!-- Views Per Year -->
            <div class="col mb-4">
                <h5 class="mb-2">Visualizzazioni per anno</h5>
                <div class="border rounded p-2">
                    <canvas id="year-views"></canvas>
                </div>
            </div>

            <!-- Messages Per Months -->
            <div class="col mb-4">
                <h5 class="mb-2">Messaggi per mese</h5>
                <div class="border rounded p-2">
                    <canvas id="month-messages"></canvas>
                </div>
            </div>

            <!-- Messages Per Year -->
            <div class="col mb-4">
                <h5 class="mb-2">Messaggi per anno</h5>
                <div class="border rounded p-2">
                    <canvas id="year-messages"></canvas>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

    <!--Import cdn ChartJS-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        //*** FUNCTIONS ***//

        /**
         * Inizialize a Chart JS Graph
         */
        const initGraph = (elem, title, labels, data, backgroundColor) => {
            const graph = new Chart(elem, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: title,
                        data,
                        borderWidth: 1,
                        backgroundColor
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            return graph;
        }


        //*** INIT ***//
        // Axis Data
        const monthsAxis = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre',
            'Ottobre', 'Novembre', 'Dicembre'
        ];
        const yearsAxis = ['2020', '2021', '2022', '2023'];

        // Get DOM Elems
        const viewsPerMonthsElem = document.getElementById('month-views');
        const viewsPerYearsElem = document.getElementById('year-views');
        const messagesPerMonthsElem = document.getElementById('month-messages');
        const messagesPerYearsElem = document.getElementById('year-messages');

        // Get Data From PHP
        const viewsPerMonthsData = <?php echo json_encode($month_views); ?>;
        const viewsPerYearsData = <?php echo json_encode($year_views); ?>;
        const messagesPerMonthsData = <?php echo json_encode($month_messages); ?>;
        const messagesPerYearsData = <?php echo json_encode($year_messages); ?>;


        //*** LOGIC ***//
        // Calculate values based on years axis
        const viewsPerYearsValues = yearsAxis.map(year => viewsPerYearsData[year] || 0);
        const messagesPerYearsValues = yearsAxis.map(year => messagesPerYearsData[year] || 0);

        // Init All Views Graphs
        initGraph(viewsPerMonthsElem, 'Visualizzazioni per mese', monthsAxis, Object.values(viewsPerMonthsData), '#dc3545');
        initGraph(viewsPerYearsElem, 'Visualizzazioni per anno', yearsAxis, viewsPerYearsValues, '#dc3545');

        // Init All Messages Graphs
        initGraph(messagesPerMonthsElem, 'Messaggi per mese', monthsAxis, Object.values(messagesPerMonthsData));
        initGraph(messagesPerYearsElem, 'Messaggi per anno', yearsAxis, messagesPerYearsValues);
    </script>

@endsection
