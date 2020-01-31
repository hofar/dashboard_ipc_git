<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link href="<?php echo base_url(); ?>assets/template/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<form id="edit_ganttchart" method="post" action="<?php echo base_url() ?>ganttchart/update/<?php echo $list->RKAP_SUBPRO_ID ?>">
    <div class="modal-header modal-type-colorful">
        <button class="close" area-hidden="true" data-dismiss="modal" type="button">x</button>
        <h4 class="modal-title">Update Data Dari Ganttchart</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="<?php echo $list->RKAP_SUBPRO_ID ?>">
        <input type="hidden" name="id_rkap" id="id_rkap" value="<?php echo $list->RKAP_SUBPRO_INVS_ID ?>">
        <div class="form-group" style="margin-bottom: 20px;">
            <label class="control-label col-sm-5">Judul SUB Program</label>
            <div class="col-sm-7">
                <div class="form-group" >
                    <div class='input-group'>
                        <span class="input-group-addon">
                            <span class="fa fa-file"></span>
                        </span>
                        <input class="form-control" type="text" value=" <?php echo $list->RKAP_SUBPRO_TITTLE; ?>" disabled />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group" >
            <label class="control-label col-sm-5">Start Date</label>
            <div class="col-sm-7">
                <div class="form-group" style="margin-bottom: 20px;">
                    <div class='input-group'>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        <input type="text" class="form-control date-picker" value="<?php echo date("d-m-Y", strtotime($list->RKAP_SUBPRO_START)); ?>" data-date-format="dd-mm-yyyy" name="tgl_start" data-validation="required" data-validation-error-msg="Tanggal awal harus diisi" id="tgl_start"/>
                    </div>
                </div>
            </div>
        </div> 
        <div class="form-group" style="margin-bottom: 20px;">
            <label class="control-label col-sm-5">End Date</label>
            <div class="col-sm-7">
                <div class="form-group">
                    <div class='input-group'>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        <input type="text" class="form-control date-picker"  value="<?php echo date("d-m-Y", strtotime($list->RKAP_SUBPRO_END)); ?>"  onchange="check_date()" data-date-format="dd-mm-yyyy" name="tgl_end" data-validation="required" data-validation-error-msg="Tanggal berakhir harus diisi" id="tgl_end" />
                    </div>
                </div>
            </div>
        </div>  
        <p>Apakah anda yakin ingin mengubah data ganttchart ini ?</p>     
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default" id="hapus" data-dismiss="modal"><div class="fa fa-times"></div> Tidak</button>
        <button type="submit" class="btn btn-sm btn-info" id="btn-info"><div class="fa fa-gears"> Edit</div></button>
    </div>
</form>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/components-pickers.js"></script>



<!-- END PAGE LEVEL SCRIPTS -->
<script>
                            jQuery(document).ready(function () {

                                ComponentsPickers.init();

                            });
</script>

<script type="text/javascript">

    function autodate() {
        var id = document.getElementById('id').value;
        var jangka = document.getElementById('jangka_waktu' + id).value;
        var jarak = parseInt(jangka);
        var startdate = $('#tgl_start').val();
        var newstartdate = startdate.split("-").reverse().join("-");

        var myDate = new Date(newstartdate);

        var result1 = myDate.addMonths(jarak);
        var datebaru = new Date(result1);
        var dateIndex = datebaru.getDate();
        var monthIndex = datebaru.getMonth() + 1;
        var yearIndex = datebaru.getFullYear();

        var lengkapset = dateIndex + '-' + monthIndex + '-' + yearIndex;

        document.getElementById('tgl_end').value = lengkapset;

    }

    Date.isLeapYear = function (year) {
        return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
    };

    Date.getDaysInMonth = function (year, month) {
        return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
    };

    Date.prototype.isLeapYear = function () {
        return Date.isLeapYear(this.getFullYear());
    };

    Date.prototype.getDaysInMonth = function () {
        return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
    };

    Date.prototype.addMonths = function (value) {
        var n = this.getDate();
        this.setDate(1);
        this.setMonth(this.getMonth() + value);
        this.setDate(Math.min(n, this.getDaysInMonth()));
        return this;
    };
</script>

<script type="text/javascript">
    function check_date() {

        
        var oneMonth = 4 * 7 * 24 * 60 * 60 * 1000;
        var tanggal_mulai = $('#tgl_start').val();
        var tanggal_akhir = $('#tgl_end').val();

        var get_mulai_split = tanggal_mulai.split('-').reverse().join(',');
        var get_akhir_split = tanggal_akhir.split('-').reverse().join(',');
        var objek_tgl_mulai = new Date(get_mulai_split);
        var objek_tgl_akhir = new Date(get_akhir_split);
        var diffDays = Math.round(Math.abs((objek_tgl_mulai.getTime()) / (oneMonth)));
        var diffDaysEnd = Math.round(Math.abs((objek_tgl_akhir.getTime()) / (oneMonth)));
        var selisih_tanggal = diffDaysEnd - diffDays;
        if (selisih_tanggal <= 0) {
            alert('Tanggal awal tidak boleh lebih dari tanggal akhir');
            $("#btn-info").attr('disabled', 'disabled');
        }
         else {
             $("#btn-info").removeAttr('disabled');
            
        }

    }


</script>