<main class="main mainheight">
    <div class="container-fluid">
        <div class="row align-items-center page-title bg-gradient-theme-light">
            <div class="col-md-6 col-12">
                <h5>Dashboard To-do</h5>
                <!-- <nav aria-label="breadcrumb"> -->
                    <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>/dashboard_todo">Dashboard To-do</a></li>
                    </ol> -->
                <!-- </nav> -->
            </div>
            <div class="col-md-2 col-12">
                <div class="ui form justify-content-center align-items-center">
                    <div class="field">
                        <select name="filter_category" id="filter_category" class="ui search dropdown">
                            <option value="all" selected>All Categories</option>
                            <?php foreach($category as $item) :?>
                                <option value="<?= $item->name ?>"><?= $item->name ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="ui form justify-content-center align-items-center">
                    <div class="field">
                        <select name="filter_pic" id="filter_pic" class="ui search dropdown">
                            <option value="<?= $this->session->userdata('user_id'); ?>" selected>My Task</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('dashboard/to_do/baris1'); ?>
    <?php $this->load->view('dashboard/to_do/baris2'); ?>
    <?php $this->load->view('dashboard/to_do/baris3'); ?>
</main>