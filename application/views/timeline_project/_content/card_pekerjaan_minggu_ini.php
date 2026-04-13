<div class="col-12 col-md-6 col-lg-6 col-xxl-3 mb-3" style="margin-right: -10px;">
    <div class="card bg-light" style="border-radius: 25px;">
        <div class="card-header" style="border-radius: 25px 25px 0 0;">
            <div class="" style="margin-top: 10px;">
                <h6 class="mb-0">
                    Pekerjaan Minggu Ini
                </h6>
            </div>
        </div>
        <div class="card-body" style="border-radius: 0 0 25px 25px;">
            <div class="progress h-20">
                <!-- Section 1 Tab -->
                <div class="progress-bar progress-tab selected" id="progress_section_1" style="width:34%; background-color: #B46BF2; cursor: pointer;" role="progressbar" data-target="#section_deadline">
                    <span style="font-size: 12px; font-weight: bold;" class="progress-text">Deadline</span>
                </div>
                <!-- Section 2 Tab -->
                <div class="progress-bar progress-tab" id="progress_section_2" style="width:33%; background-color: #F3F2F2; cursor: pointer;" role="progressbar" data-target="#section_undone">
                    <span style="font-size: 12px; font-weight: bold;" class="progress-text">Undone</span>
                </div>
                <!-- Section 3 Tab -->
                <div class="progress-bar progress-tab" id="progress_section_3" style="width:33%; background-color: #F3F2F2; cursor: pointer;" role="progressbar" data-target="#section_start">
                    <span style="font-size: 12px; font-weight: bold;" class="progress-text">Akan Dimulai</span>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content mt-3">
                <!-- Section 1 Content -->
                <div class="custom-pane active" id="section_deadline">
                    <div class="row">
                        <div class="col scrollable-column" style="max-height: 240px; overflow-y: auto;" id="row_deadline">
                        </div>
                    </div>
                </div>
                <!-- Section 2 Content -->
                <div class="custom-pane" id="section_undone">
                    <div class="row">
                        <div class="col scrollable-column" style="max-height: 240px; overflow-y: auto;" id="row_undone"></div>
                    </div>
                </div>
                <!-- Section 3 Content -->
                <div class="custom-pane" id="section_start">
                    <div class="row">
                        <div class="col scrollable-column" style="max-height: 240px; overflow-y: auto;" id="row_dimulai"></div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>