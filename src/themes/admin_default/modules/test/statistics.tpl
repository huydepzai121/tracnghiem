<!-- BEGIN: main -->
<div class="container-fluid p-0">
    <!-- Beautiful Header Section -->
    <div class="bg-gradient-primary text-white p-4 rounded-top">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h4 class="mb-1 fw-bold">
                    <i class="fas fa-chart-pie me-2"></i>Thống kê truy cập theo thí sinh
                </h4>
                <p class="mb-0 opacity-75">Phân tích dữ liệu truy cập và tham gia thi</p>
            </div>
            <div class="text-end">
                <div class="bg-white bg-opacity-20 rounded-pill px-3 py-2">
                    <i class="fas fa-users me-2"></i>
                    <span class="fw-bold">Tổng quan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white">
        <div class="row g-0">
            <div class="col-lg-8">
                <div class="p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="text-muted mb-0 fw-semibold">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>Biểu đồ thống kê
                        </h6>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-primary active" data-chart="pie">
                                <i class="fas fa-chart-pie me-1"></i>Tròn
                            </button>
                            <button type="button" class="btn btn-outline-primary" data-chart="bar">
                                <i class="fas fa-chart-bar me-1"></i>Cột
                            </button>
                        </div>
                    </div>
                    <div class="chart-container bg-light rounded p-3" style="position: relative; height: 350px;">
                        <canvas id="canvas_weekday"></canvas>
                    </div>
                </div>
            </div>

            <!-- Info Panel -->
            <div class="col-lg-4 border-start">
                <div class="p-4 h-100">
                    <h6 class="text-muted mb-3 fw-semibold">
                        <i class="fas fa-info-circle me-2 text-info"></i>Thông tin chi tiết
                    </h6>

                    <!-- Stats Cards -->
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div class="card border-0 bg-primary bg-opacity-10 text-center">
                                <div class="card-body p-3">
                                    <i class="fas fa-users text-primary fs-4 mb-2"></i>
                                    <div class="fw-bold text-primary">Loại biểu đồ:</div>
                                    <small class="text-muted">Biểu đồ tròn</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 bg-success bg-opacity-10 text-center">
                                <div class="card-body p-3">
                                    <i class="fas fa-database text-success fs-4 mb-2"></i>
                                    <div class="fw-bold text-success">Dữ liệu:</div>
                                    <small class="text-muted">Theo lượt thi</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Legend Section -->
                    <div class="border rounded p-3 mb-3">
                        <h6 class="fw-semibold mb-3">
                            <i class="fas fa-palette me-2 text-warning"></i>Chú thích
                        </h6>
                        <div id="chart-legend" class="chart-legend">
                            <div class="d-flex align-items-center mb-2">
                                <div class="legend-color bg-primary rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                                <small class="text-muted">Đang tải dữ liệu...</small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary btn-sm" onclick="exportChart()">
                            <i class="fas fa-download me-2"></i>Xuất biểu đồ
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="refreshChart()">
                            <i class="fas fa-sync-alt me-2"></i>Làm mới
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="chart-loading" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white bg-opacity-75" style="z-index: 1000;">
        <div class="text-center">
            <div class="spinner-border text-primary mb-3" role="status">
                <span class="visually-hidden">Đang tải...</span>
            </div>
            <div class="fw-semibold text-muted">Đang tải biểu đồ...</div>
        </div>
    </div>
</div>


<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/chart/Chart.bundle.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function() {
    // Hide loading overlay after initialization
    setTimeout(function() {
        $('#chart-loading').fadeOut(500);
    }, 1000);

    // Chart type switching functionality
    $('[data-chart]').on('click', function() {
        var chartType = $(this).data('chart');
        $(this).addClass('active').siblings().removeClass('active');

        // Update chart type info
        var typeText = chartType === 'pie' ? 'Biểu đồ tròn' : 'Biểu đồ cột';
        $('.fw-bold.text-primary').next('small').text(typeText);

        // Recreate chart with new type
        updateChartType(chartType);
    });

    // Enhanced number formatting function
    function number_format(number, decimals, dec_point, thousands_point) {
        if (number == null || !isFinite(number)) {
            throw new TypeError("number is not valid");
        }

        if (!decimals) {
            var len = number.toString().split('.').length;
            decimals = len > 1 ? len : 0;
        }

        if (!dec_point) {
            dec_point = '.';
        }

        if (!thousands_point) {
            thousands_point = ',';
        }

        number = parseFloat(number).toFixed(decimals);
        number = number.replace(".", dec_point);

        var splitNum = number.split(dec_point);
        splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
        number = splitNum.join(dec_point);

        return number;
    }

    // Enhanced Chart.js configuration with modern styling
    var config_day_k = {
        type: 'pie',
        data: {
            labels: [{DATA_LABEL}],
            datasets: [{
                label: "Số lượng thí sinh",
                backgroundColor: [{DATA_COLOR}],
                borderColor: '#ffffff',
                borderWidth: 2,
                data: [{DATA_VALUE}],
                hoverBorderWidth: 3,
                hoverBorderColor: '#333333'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        }
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#ffffff',
                    borderWidth: 1,
                    cornerRadius: 6,
                    displayColors: true,
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            var value = context.parsed;
                            var total = context.dataset.data.reduce((a, b) => a + b, 0);
                            var percentage = ((value / total) * 100).toFixed(1);
                            return value + ' thí sinh (' + percentage + '%)';
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000,
                easing: 'easeOutQuart'
            },
            elements: {
                arc: {
                    borderWidth: 2
                }
            }
        }
    };

    // Initialize chart with loading animation
    var ctx = document.getElementById("canvas_weekday").getContext("2d");

    // Show loading state
    ctx.fillStyle = '#f8f9fa';
    ctx.fillRect(0, 0, ctx.canvas.width, ctx.canvas.height);
    ctx.fillStyle = '#6c757d';
    ctx.font = '16px Arial';
    ctx.textAlign = 'center';
    ctx.fillText('Đang tải biểu đồ...', ctx.canvas.width / 2, ctx.canvas.height / 2);

    // Create chart after a short delay for better UX
    setTimeout(function() {
        var chart = new Chart(ctx, config_day_k);

        // Add click event for chart segments
        ctx.canvas.onclick = function(evt) {
            var activePoints = chart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
            if (activePoints.length) {
                var firstPoint = activePoints[0];
                var label = chart.data.labels[firstPoint.index];
                var value = chart.data.datasets[firstPoint.datasetIndex].data[firstPoint.index];

                // Show detailed info
                showAlert('Chi tiết: ' + label + ' - ' + value + ' thí sinh', 'info');
            }
        };
    }, 500);

    // Enhanced alert system
    function showAlert(message, type) {
        var alertClass = 'alert-' + type;
        var iconClass = type === 'success' ? 'fa-check-circle' :
                       type === 'info' ? 'fa-info-circle' : 'fa-exclamation-triangle';

        var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible fade show position-fixed" ' +
                       'style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">' +
                       '<i class="fas ' + iconClass + ' me-2"></i>' + message +
                       '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                       '</div>';

        $('body').append(alertHtml);

        // Auto-hide after 4 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 4000);
    }

    // Add responsive behavior
    $(window).on('resize', function() {
        // Chart.js handles responsive automatically, but we can add custom logic here
        console.log('Chart resized');
    });
});
//]]>
</script>
<!-- END: main -->