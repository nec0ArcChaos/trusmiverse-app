<!-- <script src="<?= base_url(); ?>assets/js/dashboard.js"></script> -->

<!-- fancybox JS -->
<script src="<?php echo base_url() ?>assets/fancybox/jquery.fancybox.min.js"></script>
<script src="<?= base_url(); ?>assets/node_modules/slim-select/dist/slimselect.min.js"></script>
<link href="<?= base_url(); ?>assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url(); ?>assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/selectize/selectize.min.js"></script>
<script src="<?= base_url(); ?>assets/jquery-confirm/jquery-confirm.min.js"></script>
<script src="<?= base_url(); ?>assets/font_awesome/js/all.min.js"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/js/jszip.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/fontawesome/js/all.min.js"></script>

<!-- progress bar  -->
<script src="<?= base_url(); ?>assets/vendor/progressbar-js/progressbar.min.js" type="text/javascript"></script>
<!-- full calender  -->
<script src="<?= base_url(); ?>assets/vendor/fullCalendar/lib/main.min.js"></script>
<!-- full calendar css -->
<link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/fullCalendar/lib/main.min.css">

<script>
    $(document).ready(function(){
        ibr_pro_list_data();
    })

    function ibr_pro_list_data(){
        base_url = "http://trusmiverse.com/hr/uploads/profile";
        $.ajax({
            url: "<?= base_url('dashboard/ibr_pro_list_data') ?>",
            type: "GET",
            dataType: "json",
            success: function(response){
                console.info(response)
                lists = ``;
                response.profile.forEach((value, index) => {

                    lists += `<div class="col-12 col-md-6 col-lg-5 col-xl-3">
                                <a href="javascript:void(0)" onclick="show_profile(${value.user_id})">
                                    <div class="card border-0 mb-4">
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                                </div>
                                                <div class="col ps-0">
                                                    <h6 class="fw-medium mb-0">Profile</h6>
                                                    <p ${value.user_id=='801'||value.user_id=='803'?'':'hidden'} class="text-secondary small">"Merangkul Resiko & Mencapai Keberhasilan"</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="text-center">
                                                <figure class="avatar avatar-150 coverimg mb-3 rounded-circle">
                                                    <img src="${base_url}/${value.photo_profile}" alt="" />
                                                </figure>
                                                
                                                ${get_consistency_stamp(value.consistency)}

                                                <h5 class="text-truncate mb-0">${value.employee_name}</h5>
                                                <p class="text-secondary small mb-1">${value.jabatan}</p>
                                                <ul class="nav justify-content-center">
                                                    <li class="nav-item">
                                                        <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/logo_rumah_ningrat.png" alt="">
                                                    </li>
                                                    <li class="nav-item">
                                                        <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/logo_bt.png" alt="">
                                                    </li>
                                                    <li class="nav-item">
                                                        <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/logo_tkb.png" alt="">
                                                    </li>
                                                    <li class="nav-item">
                                                        <img class="cols avatar avatar-20 coverimg rounded-circle" src="<?= base_url(); ?>assets/img/fbtlogo.png" alt="">
                                                    </li>
                                                </ul>
                                            </div>
                                            <hr>
                                            <div class="row align-items-center mb-3">
                                                <div class="col-6">
                                                    <h6>Goal <span class="float-end badge badge-sm bg-blue">${value.goal}</span></h6>
                                                </div>
                                                <div class="col-6">
                                                    <h6>Strategy <span class="float-end badge badge-sm bg-purple">${value.strategy}</span></h6>
                                                </div>
                                            </div>
                                            <hr>

                                        </div>
                                    </div>
                                </a>
                                
                            </div>`;
                });

                $('#ibr_pro_list').html(lists);

            }
        })
    }

    function get_consistency_stamp(value){
        if(value == 0){
            return ``
        }else if(value < 80){
            return `<img src="https://trusmiverse.com/apps/assets/img/inconsistent_red.png" alt="" width="100px;">`
        }else{
            return `<img src="https://trusmiverse.com/apps/assets/img/consistent_green.png" alt="" width="100px;">`
        }
    }

    function show_profile(user_id){
        url = `<?= base_url() ?>dashboard/ibr_pro/${user_id}`;
        // location.href = url;
        $('#user_id').val(user_id);
        $('#modal_profile_to').modal('show');
    }

    function go_to(to){
        user_id = $('#user_id').val();
        if(to == 'dashboard'){
            url = `<?= base_url() ?>dashboard/ibr_pro/${user_id}`;
        }else{
            url = `<?= base_url() ?>kanban?u=${user_id}`;
        }
        location.href = url;
    }
</script>