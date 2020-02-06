<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link href="<?php echo base_url(); ?>assets/template/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>

<form id="add_ganttchart" method="post" action="<?php echo base_url() ?>ganttchart/add/<?php echo $list->RKAP_SUBPRO_ID ?>">
    <div class="modal-header modal-type-colorful">
        <button class="close" area-hidden="true" data-dismiss="modal" type="button">x</button>
        <h4 class="modal-title">Tambah Data Ke Ganttchart</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="id" id="id" value="<?php echo $list->RKAP_SUBPRO_ID ?>">
        <input type="hidden" name="id_rkap" id="id_rkap" value="<?php echo $list->RKAP_SUBPRO_INVS_ID ?>">
        <div class="form-group" style="margin-bottom: 20px;">
            <label class="control-label col-sm-5">Jenis SUB Program</label>
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
        <div class="form-group" style="margin-bottom: 20px;">
            <label class="control-label col-sm-5">Start Date</label>
            <div class="col-sm-7">
                <div class="form-group" >
                    <div class='input-group'>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        <input type="text" class="form-control date-picker" value="<?php echo $list->RKAP_SUBPRO_START; ?>"  name="tgl_start"  data-date-format="dd-mm-yyyy" data-validation="required" data-validation-error-msg="Tanggal awal harus diisi" id="tgl_start"/>
                    </div>
                </div>
            </div>
        </div> 
        <div class="form-group" style="margin-bottom: 20px;">
            <label class="control-label col-sm-5">End Date</label>
            <div class="col-sm-7">
                <div class="form-group" >
                    <div class='input-group'>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        <input type="text" class="form-control date-picker" value="<?php echo $list->RKAP_SUBPRO_END; ?>"  data-date-format="dd-mm-yyyy" name="tgl_end" data-validation="required"  data-validation-error-msg="Tanggal berakhir harus diisi" id="tgl_end" onchange="date_validation()"/>
                    </div>
                </div>
            </div>
        </div> 
        <p>Apakah anda yakin ingin memasukkan data ini ke dalam ganttchart ?</p>      
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-default" id="hapus" data-dismiss="modal"><div class="fa fa-times"></div> Tidak</button>
        <button type="submit" class="btn btn-sm btn-success"><div class="fa fa-plus"> tambah</div></button>
    </div>
</form>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/template/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="<?php echo base_url(); ?>assets/template/admin/pages/scripts/components-pickers.js"></script>

<script>
                            $.validate({
                                modules: 'security'
                            });
</script>

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
        
        var lengkapset = dateIndex + '-' + monthIndex  + '-' + yearIndex;
        
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

        var id = document.getElementById('id').value;
        var id_rkap = document.getElementById('id_rkap').value;
        var periode = document.getElementById('jangka_waktu' + id).value;
        var jarak = parseInt(periode);
        var oneMonth = 4 * 7 * 24 * 60 * 60 * 1000;
        var tanggal_mulai = $('#tgl_start').val();
        var tanggal_akhir = $('#tgl_end').val();

        // alert(tanggal_akhir);
        // return
        var get_mulai_split = tanggal_mulai.split('-').reverse().join(',');
        var get_akhir_split = tanggal_akhir.split('-').reverse().join(',');
        var objek_tgl_mulai = new Date(get_mulai_split);
        var objek_tgl_akhir = new Date(get_akhir_split);

        var diffDays = Math.round(Math.abs((objek_tgl_mulai.getTime() - objek_tgl_akhir.getTime()) / (oneMonth)));
        // alert(diffDays);
        if (diffDays != periode) {
            alert('jumlah jarak bulan antara tanggal mulai dan tanggal akhir harus sama dengan jangka waktu');
            return false;
        } else {
            var link_base = "<?php echo base_url(); ?>";
            var form_edit = $("#add_ganttchart");
            var isi_data = form_edit.serialize();
            $.ajax({
                url: link_base + "ganttchart/add/" + id,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: isi_data,
                success: function (data) {
                    console.log(data);
                    if (data == 'success') {

                        window.location.href = link_base + "ganttchart/view/" + id_rkap;
                        // $('#alert_success').show();
                    } else {
                        alert('simpan gagal');
                    }
                }
            });
            // console.log(form_edit);
        }

    }

    function date_validation() {

        var tanggal_mulai = $('#tgl_start').val();
        var tanggal_akhir = $('#tgl_end').val();
        
        var newdate_mulai = tanggal_mulai.split("-").reverse().join("-");
        var newdate_akhir = tanggal_akhir.split("-").reverse().join("-");
        
        //tanggal start

        var c = new Date(newdate_mulai);
        var month_mulai = c.getMonth() + 1;
        var year_mulai  = c.getFullYear();
        var tgl_mulai   = month_mulai + '-' + year_mulai;


        //tanggal end

        var d = new Date(newdate_akhir);
        var month_akhir = d.getMonth() + 1;
        var year_akhir  = d.getFullYear();
        var tgl_akhir   = month_akhir + '-' + year_akhir;


        if (tgl_akhir < tgl_mulai) {
            alert('Tanggal Akhir tidak boleh kurang dari Tanggal Mulai')
            $("#tgl_end").val('');
        } 
    }


</script>