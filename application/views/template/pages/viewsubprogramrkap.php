<style type="text/css">
    .table>thead>tr>th {
        vertical-align: bottom;
        border: 1px solid #ddd;
        text-align: center;
        color: #666;
        background-color: #EBEBEB;
        font-size: 14px
    }

    .table>tbody>tr>td {
        border: 1px solid #ddd;
    }

    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -1.0715rem;
        margin-left: -1.0715rem;
    }

    a {
        color: #434343;
    }

    .breadcrumb-right-arrow .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        vertical-align: top;
        font-size: 40px;
        line-height: 15px;
        line
    }

    .breadcrumb>li :hover {}
    .styleforp1 {
        font-weight: bold;
    }
</style>


<div class="page">
    <div class="page-content">
        <div class="col-md-12">
            <ol class="breadcrumb breadcrumb-right-arrow">
                <li class="breadcrumb-item">
                    <i class="fa fa-home fa-lg"></i>
                    <a class="icon wb-home" href="<?php echo base_url(); ?>home">Dashboard</a>
                </li>
                <li class="breadcrumb-item"> <a href="<?php echo base_url(); ?>rkapinvestasi">RKAP Investasi</a></li>
                <li class="breadcrumb-item active">Detail Realisasi</li>
            </ol>
        </div>
        <div class="headTab">
            <i class="icon md-laptop"></i> RKAP Sub Program Investasi
        </div>
        <div class="panels">

            <div>
                <?php if ($this->session->flashdata('login')): ?>
                <div class="note note-info note-bordered">
                    <p>
                        <div class="fa fa-check"></div>&nbsp;<?php echo $this->session->flashdata('login'); ?>
                    </p>
                </div>

                <?php endif; ?>
                <!-- BEGIN PORTLET-->

                <form role="form"
                    action="<?php echo base_url(); ?>subprogramrkapinvestasi/view/<?php echo $row_rkap->RKAP_INVS_ID ?>"
                    method="post">

                    <?php if ($this->session->flashdata('message')): ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span>
                            <?php echo $this->session->flashdata('message'); ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button>
                        <span>
                            <?php echo $this->session->flashdata('success'); ?>
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
                    <div class="col-sm-12" style="padding: 0;">
                        <div class="col-sm-12">
                            <div class="row">
                                <fieldset class="col-sm-12" style="border: 1px solid #e5e5e5; border-radius: 3px; color: #666666;">
                                    <legend
                                        style="font-size: 12px; border-radius: 3px; border: 1px solid #e5e5e5; padding: 3px 8px; margin: 10px 0 0 7px; width: auto; color: #666666;">
                                        Searching</legend>
                                    <div class="col-sm-12">
                                    <div class="form-group" style="margin-top: 10px;">
                                            <div class="rows">
                                                <label class="control-label col-lg-3">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    Judul Investasi
                                                </label>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 styleforp1">
                                                    <?php echo ucfirst($list_rkap->RKAP_INVS_TITLE);?>  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-top: 10px;">
                                            <div class="rows">
                                                <label class="control-label col-lg-3">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    No Investasi
                                                </label>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 styleforp1">
                                                <?php echo $list_rkap->RKAP_INVS_PROJECT_NUMBER;?>   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-top: 10px;">
                                            <div class="rows">
                                                <label class="control-label col-lg-3">
                                                    <i class="icon md-calendar"></i> &nbsp;
                                                    Type Investasi
                                                </label>
                                                <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 styleforp1">
                                                <?php echo $list_rkap->INVS_TYPE_NAME;?>    
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <?php if ($this->session->userdata('SESS_USER_PRIV') == 1): ?>
                                                        <div class="form-group" style="width: 20%;">
                                                            <?php
                                                            if ($this->session->flashdata('cabang')):
                                                                $cabang = $this->session->flashdata('cabang');
                                                            else :
                                                                $cabang = "";
                                                            endif
                                                            ?>
                                                            <label class="control-label">Cabang</label>
                                                            <select name="cabang" value="<?php echo $cabang; ?>" class="form-control">
                                                                <option value="">-- Pilih Cabang --</option>
                                                                <?php
                                                                foreach ($groups as $row) {
                                                                    if ($row->BRANCH_NAME == $cabang) {
                                                                        echo '<option selected value="' . $row->BRANCH_NAME . '">' . $row->BRANCH_NAME . '</option>';
                                                                    } else {
                                                                        echo '<option value="' . $row->BRANCH_NAME . '">' . $row->BRANCH_NAME . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    <?php else: ?>

                                                    <?php endif ?> -->
                                </fieldset>
                            </div>
                        </div>

                        <div class="col-sm-6"></div>
                    </div>

            </div>


            <div>
                <div>
                    <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                    <a href="<?php echo base_url(); ?>rkapinvestasi/detail/<?php echo $row_rkap->RKAP_INVS_ID ?>"
                        class="btn btn-danger  btnnn">
                        <div class="fa fa-arrow-left"></div> Kembali ke rkap
                    </a>

                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                    <a href="<?php echo base_url(); ?>rkapinvestasi/detail/<?php echo $row_rkap->RKAP_INVS_ID ?>"
                        class="btn btn-danger  btnnn">
                        <div class="fa fa-arrow-left"></div> Kembali ke rkap
                    </a>

                    <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                    <a href="<?php echo base_url(); ?>rkapinvestasi/detail/<?php echo $row_rkap->RKAP_INVS_ID ?>"
                        class="btn btn-danger  btnnn">
                        <div class="fa fa-arrow-left"></div> Kembali ke rkap
                    </a>
                    <?php else: ?>
                    <!-- <a href="<?php echo base_url(); ?>subprogramrkapinvestasi/add/<?php echo $row_rkap->RKAP_INVS_ID ?>"
                        class="btn btn-success  btnnn">
                        <div class="fa fa-plus"></div> Tambah
                    </a> -->
                    <a href="<?php echo base_url(); ?>rkapinvestasi/detail/<?php echo $row_rkap->RKAP_INVS_ID ?>"
                        class="btn btn-danger ">
                        <div class="fa fa-arrow-left"></div> Kembali ke rkap
                    </a>

                    <?php endif ?>

                    </form>
                </div>
            </div>

            <br />

            <div>
                <table class="table table-hover dataTable w-full" data-plugin="dataTable" style="font-size:13px"
                    width="100%">
                    <thead>
                        <tr>
                            <th width="100">Kode Investasi</th>
                            <th width="150">Sub Program</th>
                            <th width="500">Judul</th>
                            <th width="150">Tools</th>
                        </tr>
                    </thead>

                    <tbody>
                        <div class="col-md-12">
                            <?php if (count($list) == 0): ?>

                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <div class="fa fa-info-circle"></div> Tidak Ada Data<br>
                            </div>
                            <?php else: ?>
                            <?php if ($this->session->flashdata('message')): ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <div class="fa  fa-check"></div> <?php echo $this->session->flashdata('message'); ?><br>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php foreach ($list as $row): ?>
                        <tr>
                            <td align="center"><?php echo $row->RKAP_SUBPRO_ID; ?></td>
                            <td><?php echo $row->SUBPRO_TYPE_NAME; ?></td>
                            <td><?php echo $row->RKAP_SUBPRO_TITTLE; ?></td>

                            <td align=" center">
                                <?php if ($this->session->userdata('SESS_USER_PRIV') == 1 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>

                                <a href="<?php echo base_url() ?>subprogramrkapinvestasi/detail/<?php echo $row->RKAP_SUBPRO_ID ?>"
                                    class="btn btn-sm btn-default btn-round" data-toggle="tooltip"
                                    title="Detail Data"><i class="fa fa-eye"></i></a>

                                <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 2 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                <a href="<?php echo base_url() ?>subprogramrkapinvestasi/detail/<?php echo $row->RKAP_SUBPRO_ID ?>"
                                    class="btn btn-sm btn-default  btn-round" data-toggle="tooltip"
                                    title="Detail Data"><i class="fa fa-eye"></i></a>
                                <?php elseif ($this->session->userdata('SESS_USER_PRIV') == 3 && $this->session->userdata('SESS_USER_POSITION') == 4): ?>
                                <a href="<?php echo base_url() ?>subprogramrkapinvestasi/detail/<?php echo $row->RKAP_SUBPRO_ID ?>"
                                    class="btn btn-sm btn-default  btn-round" data-toggle="tooltip"
                                    title="Detail Data"><i class="fa fa-eye"></i></a>

                                <?php else: ?>
                                <a href="<?php echo base_url() ?>subprogramrkapinvestasi/update/<?php echo $row->RKAP_SUBPRO_ID ?>"
                                    class="btn btn-sm btn-default  btn-round" data-toggle="tooltip" title="Edit Data"><i
                                        class="fa fa-gears"></i></a>

                                <a href="<?php echo base_url() ?>subprogramrkapinvestasi/detail/<?php echo $row->RKAP_SUBPRO_ID ?>"
                                    class="btn btn-sm btn-default  btn-round" data-toggle="tooltip"
                                    title="Detail Data"><i class="fa fa-eye"></i></a>

                                <!-- <span data-toggle="tooltip" title="Hapus Data">
                                                    <a href="<?php echo base_url() ?>subprogramrkapinvestasi/delete_modal/<?php echo $row->RKAP_SUBPRO_ID ?>" class="btn btn-sm btn-default  btn-round" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a>
                                                </span> -->
                                <span data-toggle="tooltip" title="Hapus Data">
                                    <a onclick="btn_delete_set(<?php echo $row->RKAP_SUBPRO_ID ?>)"
                                        class="btn btn-sm btn-default  btn-round" data-toggle="modal"
                                        data-target="#hapus"><i class="fa fa-trash-o"></i></a>
                                </span>
                                <?php endif ?>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>










<div class="modal fade modal-3d-slit modal-danger" id="hapus" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="modaldeletesubpro"
                action="<?php echo base_url() ?>subprogramrkapinvestasi/delete/<?php echo $list->RKAP_SUBPRO_ID ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus <?php echo $list->RKAP_SUBPRO_TITTLE; ?> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-pure btn-default" id="hapus" data-dismiss="modal">
                        <div class="fa fa-times"></div> Tidak
                    </button>
                    <button type="submit" class="btn btn-md btn-danger">
                        <div class="fa fa-check"> Ya</div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END CONTENT -->



<script type="text/javascript">
    var link_base = "<?php echo base_url(); ?>";

    function btn_delete_set(id) {
        // alert(id);
        document.getElementById("modaldeletesubpro").action = link_base + '/subprogramrkapinvestasi/delete/' + id;
        // $.ajax({
        //     type: 'GET',
        //    url: link_base+'/subprogramrkapinvestasi/delete_modal/'+ id,
        //     // data: {id : id},
        //     success: function (data) {
        //         // console.log(data);
        //         var obj = JSON.parse(data);
        //         // $('#editstatus').modal();
        //          $("#id_user_modal").val(obj.CRITIC_ID);
        //         // alert(obj.USER_ID);
        //         // $('#editstatus').find('.modal-body').html(data);
        //     }
        // })
    }
</script>