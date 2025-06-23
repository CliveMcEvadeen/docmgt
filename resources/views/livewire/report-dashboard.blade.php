<div>
    <h2 class="text-xl font-semibold mb-4">Daily Arrivals and Departures Report</h2>
    <canvas id="reportChart" width="600" height="300"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            const ctx = document.getElementById('reportChart').getContext('2d');
            const data = @json($reportData);

            const labels = data.map(item => item.report_date);
            const arrivals = data.map(item => item.total_arrivals);
            const departures = data.map(item => item.total_departures);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Arrivals',
                            data: arrivals,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                        },
                        {
                            label: 'Departures',
                            data: departures,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Count'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</div>
