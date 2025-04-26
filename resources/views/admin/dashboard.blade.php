<x-admin.layout>
    <x-slot:title>Dashboard</x-slot:title>
    <x-admin.sidebar>

        <div class="container-fluid py-4">
            {{-- General Statistics Cards --}}
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm rounded-2 p-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-people fs-1 text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Users</h6>
                                <h3 class="fw-bold">{{ $totalUsers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm rounded-2 p-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-wrench fs-1 text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Services</h6>
                                <h3 class="fw-bold">{{ $totalServices }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm rounded-2 p-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-calendar-check fs-1 text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Total Inquires</h6>
                                <h3 class="fw-bold">{{ $totalInquiries }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card shadow-sm rounded-2 p-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-check fs-1 text-danger"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Completed Services</h6>
                                <h3 class="fw-bold">{{ $completedServices }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Row --}}
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm rounded-2 p-3">
                        <h6>Services Inquiries</h6>
                        <canvas id="inquiriesChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm rounded-2 p-3">
                        <h6>Featured Services</h6>
                        <canvas id="featuredChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm rounded-2 p-3">
                        <h6>New Users</h6>
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm rounded-2 p-3">
                        <h6>Cancellation Rate</h6>
                        <canvas id="cancellationChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Alerts and Recent Activity --}}
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm rounded-2 p-3">
                        <h6>Alerts</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Pending Approvals
                                <span class="badge bg-warning">{{ $pendingApprovals }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Reported Services
                                <span class="badge bg-danger">{{ $reportedServices }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Scripts --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctxServices = document.getElementById('inquiriesChart').getContext('2d');
            new Chart(ctxServices, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Services Inquiries',
                        data: @json($chartValues),
                        tension: 0.4
                    }]
                }
            });

            const ctxFeatured = document.getElementById('featuredChart').getContext('2d');
            new Chart(ctxFeatured, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Featured Services',
                        data: @json($featuredServices),
                        tension: 0.4
                    }]
                }
            });

            const ctxUsers = document.getElementById('usersChart').getContext('2d');
            new Chart(ctxUsers, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'New Users',
                        data: @json($userChartValues)
                    }]
                }
            });

            const ctxCancel = document.getElementById('cancellationChart').getContext('2d');
            new Chart(ctxCancel, {
                type: 'doughnut',
                data: {
                    labels: ['Cancelled', 'Completed'],
                    datasets: [{
                        data: [
                            @json($chartData['rejections'] ?? 0),
                            @json($chartData['completions'] ?? 0)
                        ],
                    }]
                }
            });
        </script>

    </x-admin.sidebar>
</x-admin.layout>

