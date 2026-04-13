<div class="container-fluid p-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8 col-lg-10">
                            <h5 class="card-title">Monthly Overall Task</h5>
                        </div>
                        <div class="col-4 col-lg-2">
                            <div class="input-group input-group-sm border-custom">
                                <input type="text" class="form-control form-control-lg range px-2 border-custom" style="cursor: pointer;" id="select_month" placeholder="<?= date('Y-m') ?>" value="<?= date('Y-m') ?>">
                                <span class="input-group-text bg-transparent border-0">
                                    <i class="bi bi-calendar-event"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-2 d-flex justify-content-center align-items-center">
                            <div id="chart_pie_task" style="width: 110px"></div>
                        </div>
                        <div class="col-12 col-md-10">
                            <div id="chart_line_task"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>