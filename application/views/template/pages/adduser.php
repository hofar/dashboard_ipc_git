<div class="page">
    <div class="page-content">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="fa fa-home fa-lg"></i>
                <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <i class="fa fa-face fa-lg"></i>
                <a class="icon md-face" href="<?php echo base_url(); ?>usermanagement">User Management</a>
            </li>
            <li class="breadcrumb-item active">Form User Management</li>
        </ol>
        <div class="headTab">
            <i class="icon md-face"></i> Form User Management
        </div>
        <div class="panels">
            <form id="add_user" method="post" action="<?php echo base_url(); ?>usermanagement/added" class="form-horizontal">
                <?php if ($this->session->flashdata('message')): ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span>
                            <?php echo $this->session->flashdata('message'); ?>
                        </span>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('warning')): ?>
                    <div class="alert alert-warning">
                        <button class="close" data-close="alert"></button>
                        <span>
                            <?php echo $this->session->flashdata('warning'); ?>
                        </span>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('username')): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('username'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('email')): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('email'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('password')): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div class="fa fa-info-circle"></div>&nbsp;<?php echo $this->session->flashdata('password'); ?>
                    </div>
                <?php endif; ?>
                <div class="portlet-body">

                    <div class="col-lg-8">
                        <fieldset style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666; padding: 15px 20px 20px 20px;">
                            <legend style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">Add Data</legend>
                            <div class="form-group">
                                <label class="control-label">Username</label>
                                <div>
                                    <?php
                                    if ($this->session->flashdata('USERNAM')):
                                        $USERNAM = $this->session->flashdata('USERNAM');
                                    else :
                                        $USERNAM = "";
                                    endif
                                    ?>
                                    <input class="form-control" placeholder="Username" type="text" value="<?php echo $USERNAM; ?>" name="username" data-validation="required" data-validation-error-msg="Username harus diisi" id="username"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">NIPP</label>
                                <div>
                                    <?php
                                    if ($this->session->flashdata('NIP')):
                                        $NIP = $this->session->flashdata('NIP');
                                    else :
                                        $NIP = "";
                                    endif
                                    ?>
                                    <input class="form-control" placeholder="NIPP" type="number" value="<?php echo $NIP; ?>" name="nipp" data-validation="required" data-validation-error-msg="NIPP harus diisi" id="nipp"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Password</label>
                                <div>
                                    <?php
                                    if ($this->session->flashdata('PASSWOR')):
                                        $PASSWOR = $this->session->flashdata('PASSWOR');
                                    else :
                                        $PASSWOR = "";
                                    endif
                                    ?>
                                    <input class="form-control" placeholder="*******" type="password" value="<?php echo $PASSWOR; ?>" name="password" data-validation="required" data-validation-error-msg="Password harus diisi" id="password"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <div>
<?php
if ($this->session->flashdata('MAIL')):
    $MAIL = $this->session->flashdata('MAIL');
else :
    $MAIL = "";
endif
?>
                                    <input class="form-control" placeholder="Email" type="email" value="<?php echo $MAIL; ?>" name="email" data-validation="required" data-validation-error-msg="Email harus diisi" id="email"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Privilege</label>
                                <div>
                                    <select name="privilage" class="form-control"  data-validation="required" data-validation-error-msg="Privilege harus di pilih" id="privilage" onchange="privilage_select()">
                                        <option value="">-- Pilih Privilege --</option>
<?php foreach ($groups as $row) { ?>
                                            <option value="<?php echo $row->USER_PRIV_ID; ?>"><?php echo $row->USER_PRIV_NAME; ?> </option>
                                        <?php } ?>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Branch</label>
                                <div>
                                    <select name="branch" class="form-control"  data-validation="required" data-validation-error-msg="Branch harus di pilih" id="branch" onchange="branch_select()" disabled>
                                        <!--      <option value="">-- Pilih Branch --</option>
<?php foreach ($groupsPusat1 as $row) { ?>
                                                         <option value="<?php echo $row->BRANCH_ID; ?>"><?php echo $row->BRANCH_NAME; ?> </option>
                                        <?php } ?> -->
                                    </select> 
                                </div>
                            </div>
                            <div  class="form-group">
                                <label class="control-label">Posisi</label>
                                <div>
                                    <select name="posisi" class="form-control" data-validation="required" data-validation-error-msg="Posisi harus di pilih" id="posisi" disabled>
                                        <!--    <option value="">-- Pilih Posisi --</option>
<?php foreach ($groups2 as $row) { ?>
                                                       <option value="<?php echo $row->POSITION_ID; ?>"><?php echo $row->POSITION_NAME; ?> </option>
<?php } ?> -->
                                    </select> 
                                </div>
                            </div>


                            <div class="form-action pull-right adcanser">
                                <button type="submit" class="btn btn-success addusr btn-round" id="button-add"><div class="fa fa-plus"></div> Tambah</button>&nbsp;
                                <a href="<?php echo base_url(); ?>usermanagement" class="btn btn-default btn-round" ><div class="fa fa-ban"></div> Batal</a>&nbsp;

                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>

        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Notification</h4>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin ingin menambahkan data ini ?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success uppercase"> Ya</button>&nbsp;
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    function privilage_select() {
        var privilage_val = $("#privilage").val();
        var branch_val = $("#branch").val();
        var posisi_val = $("#posisi").val();
        var data_branch_pusat = <?php echo json_encode($groupsPusat1) ?>;
        var data_posisi_pusat = <?php echo json_encode($groupsPusat2) ?>;
        var data_branch = <?php echo json_encode($groups1) ?>;
        var data_posisi = <?php echo json_encode($groups2) ?>;
        var data_branch_anak = <?php echo json_encode($groupsAnak1) ?>;
        var data_posisi_anak = <?php echo json_encode($groupsAnak2) ?>;
        var branch_html = '<option value="">-- Pilih Branch --</option>';
        var posisi_html = '<option value="">-- Pilih Posisi --</option>';


        // alert(privilage_val);    
        if (privilage_val == 1) {
            data_branch_pusat.forEach(function (element) {
                console.log(element);
                branch_html += '<option value="' + element.BRANCH_ID + '">' + element.BRANCH_NAME + '</option>';

            });
        } else if (privilage_val == 2) {
            data_branch.forEach(function (element) {
                console.log(element);
                branch_html += '<option value="' + element.BRANCH_ID + '">' + element.BRANCH_NAME + '</option>';

            });
        } else if (privilage_val == 3) {
            data_branch_anak.forEach(function (element) {
                console.log(element);
                branch_html += '<option value="' + element.BRANCH_ID + '">' + element.BRANCH_NAME + '</option>';

            });
        } else {
            branch_html = '<option value="">-- Pilih Branch --</option>';
        }

        // console.log(branch_html);

        $('#branch').html(branch_html);

        if (privilage_val > 0) {
            $("#add_user  #branch").removeAttr('disabled');
            $("#add_user  #posisi").attr('disabled', 'disabled');
        } else {
            $("#add_user  #branch").attr('disabled', 'disabled');
            $("#add_user  #posisi").attr('disabled', 'disabled');
        }

    }

    function branch_select() {
        var privilage_val = $("#privilage").val();
        var branch_val = $("#branch").val();
        var posisi_val = $("#posisi").val();
        var data_branch_pusat = <?php echo json_encode($groupsPusat1) ?>;
        var data_posisi_pusat = <?php echo json_encode($groupsPusat2) ?>;
        var data_branch = <?php echo json_encode($groups1) ?>;
        var data_posisi = <?php echo json_encode($groups2) ?>;
        var data_branch_anak = <?php echo json_encode($groupsAnak1) ?>;
        var data_posisi_anak = <?php echo json_encode($groupsAnak2) ?>;

        var branch_html = '<option value="">-- Pilih Branch --</option>';
        var posisi_html = '<option value="">-- Pilih Posisi --</option>';

        if (privilage_val == 1) {
            data_posisi_pusat.forEach(function (element1) {
                console.log(element1);
                posisi_html += '<option value="' + element1.POSITION_ID + '">' + element1.POSITION_NAME + '</option>';

            });
        } else if (privilage_val == 2) {
            data_posisi.forEach(function (element1) {
                console.log(element1);
                posisi_html += '<option value="' + element1.POSITION_ID + '">' + element1.POSITION_NAME + '</option>';

            });
        } else if (privilage_val == 3) {
            data_posisi_anak.forEach(function (element1) {
                console.log(element1);
                posisi_html += '<option value="' + element1.POSITION_ID + '">' + element1.POSITION_NAME + '</option>';

            });
        } else {
            posisi_html = '<option value="">-- Pilih Posisi --</option>';
        }

        // console.log(branch_html);

        $('#posisi').html(posisi_html);

        // alert(branch_val);
        if (branch_val >= 0) {
            $("#add_user  #posisi").removeAttr('disabled');
        } else {
            $("#add_user  #posisi").attr('disabled', 'disabled');
        }
    }
</script>