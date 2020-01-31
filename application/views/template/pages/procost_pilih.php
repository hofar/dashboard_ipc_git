<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Generate Data</title>

    <!-- Bootstrap core CSS -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <style>
        html {
            font-size: 14px;
        }

        @media (min-width: 768px) {
            html {
                font-size: 16px;
            }
        }

        .container {
            max-width: 960px;
        }

        .pricing-header {
            max-width: 700px;
        }

        .card-deck .card {
            min-width: 220px;
        }

        #divLoading {
        margin: 0px;
        display: none;
        padding: 0px;
        position: absolute;
        right: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        background-color: rgb(255, 255, 255);
        z-index: 30001;
        opacity: 0.8;}

        #loading {
        position: fixed;
        color: White;
        top: 50%;
        left: 45%;}
        
        .dttb1{
            display :none;
        }
        .modal-lg2 {
            max-width: 1000px;
        }
        /* .dataTables_filter, .dataTables_info, .dataTables_length { display: none; } */
    </style>
</head>

<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal"><b>CE-MS</b></h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="btn btn-outline-primary glyphicon glyphicon-circle-arrow-left"
                href="<?php echo base_url(); ?>projectcostingcems">
                <= BACK</a> </nav> <a class="btn btn-outline-primary" href="#">Sign Out
            </a>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModalpilih" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg2" role="document" style="">
            <div class="modal-content" style="">
                <div class="modal-header">
                    
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered data" id="table" style="width: 960px;">
                        <thead>
                            <tr>
                                <th style="display:none;"></th>
                                <th width="230">Judul Investasi</th>
                                <th width="210">Judul Sub program</th>
                                <th width="200">No Kontrak</th>
                                <th width="150">Nilai Kontrak</th>
                            </tr>
                        </thead>
                        <tbody id="tbodydttable" style="font-size: small; font-family: serif;">
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row mb-2">
            <div class="col-md-12">
            <div id="divLoading">
            <div id='loading'>
            <img src="<?php echo base_url();?>assets/img/ajax-loader.gif" width="200" hight="200"/>
            </div>
            </div>
                <h6>Simpan Kontrak Atau Addendum</h6>
                <div class="">
                    <table id="example" class="table table-striped table-bordered" style="width:100%; font-size:11px; font-family: monospace;">
                        <thead>
                            <tr>
                                <th width="200">JUDUl INVESTASI</th>
                                <th width="170">PROJEK NUMBER</th>
                                <th width="200">JUDUL KONTRAK</th>
                                <th width="100">NOMOR KONTRAK</th>
                                <th width="100">NILAI KONTRAK</th>
                                <th width="100">TANGGAL KONTRAK</th>
                                <th width="30">ISI</th>
                                <th width="110">PILIHAN</th>
                                <th width="100">REFERENSI</th>
                                <th width="50">Add Ke</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sum = 0;
                            foreach ($data as $key => $value) {
                            ?>
                            <tr class="trid">
                                <?php
                                $sum = $sum + $value->PO_AMT;
                                echo "<td>".$value->RKAP_INVS_TITLE."</td>";
                                echo "<td>".$value->RKAP_INVS_PROJECT_NUMBER."</td>";
                                echo "<td>".$value->PO_DESC."</td>";
                                echo "<td>".$value->NO_KONTRAK."</td>";
                                echo "<td style='text-align:right; font-weight: bold;'>".number_format($value->PO_AMT,0)."</td>";
                                echo "<td>".$value->PO_DATE."</td>";
                                ?>
                                <td>
                                    <input type="hidden" class="idpr" value="<?php echo $value->PO_NUMBER;?>">
                                    <input type="checkbox" class="cek" value='N'>
                                </td>
                                <td>
                                    <input type="radio" class="btn btn-primary combo1" name="combo<?php echo $key;?>" value="kontrak" checked="checked" disabled> Kontrak
                                    <br>
                                    <input type="radio"  class="combo2" name="combo<?php echo $key;?>" value="addendum" disabled> Addendum
                                </td>
                                <td><input type="text" class="inputidp" id="idp<?php echo $key;?>" class="inputidp" data-dataid2="idp<?php echo $key;?>" data-dataid="<?php echo $value->RKAP_INVS_ID;?>" disabled></td>
                                <td><select class="addnno" name="addnno<?php echo $key;?>" id="addnno">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option></select></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr style="font-size: 14px;background-color: #2196F3;">
                                <th colspan="4" style="text-align:right"></th>
                                <th colspan="2" style="text-align:right"></th>
                                <th colspan="2" style="text-align:right"></th>
                                <th colspan="2" style="text-align:right"></th>
                            </tr>
                        </tfoot>
                    </table>
                    <button class="btn btn-primary" id="save">Save</button>
                    <button class="btn btn-primary" id="checkontrak">check all kontrak</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            var d;
            var d2;
            
            $('.inputidp').click(function() {
                d = $(this).data('dataid');
                d2 = $(this).data('dataid2');
                $('#table').DataTable({
                    "ajax": "<?php echo base_url() ?>projectcostingcems/ambildata/"+d,
                    "destroy": "true",
                    "columns": [
                        { "data": "RKAP_SUBPRO_ID",className : "dttb1" },
                        { "data": "RKAP_INVS_TITLE",className : "dttb2" },
                        { "data": "RKAP_SUBPRO_TITTLE" },
                        { "data": "RKAP_SUBPRO_CONTRACT_NO" },
                        { "data": "RKAP_SUBPRO_CONTRACT_VALUE", 
                            "render": function(data, type, row){
                                var value = parseFloat(row.RKAP_SUBPRO_CONTRACT_VALUE).toFixed(0);
                                var set_value = value.replace(".", ",");
                                return (row.RKAP_SUBPRO_CONTRACT_VALUE == null ? '0' : ""+set_value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."))
                            } 
                        }
                    ]
                });
                $('#myModalpilih').modal('show');  
            });
            $('#table tbody').off('click');
            $('#table tbody').on('click', 'tr', function () {
                var value = $(this).find('td:first').html();
                var dd = "#"+d2;
                $(dd).val(value);
                //alert(dd);
                $('#myModalpilih').modal('toggle');
            } );

            $('.table').on('change', ':checkbox', function () {
                if($(this).prop("checked") == true){
                    $(this).closest('tr').css('background-color', '#7895ff');
                    $(this).val('Y');
                    $(this).closest('tr').find('input:text').removeAttr('disabled');
                    $(this).closest('tr').find('input:radio').removeAttr('disabled');
                }else{
                    $(this).closest('tr').find('input:text').attr('disabled','disabled');
                    $(this).closest('tr').find('input:radio').attr('disabled','disabled');
                    $(this).closest('tr').css('background-color', '');
                    $(this).val('N');
                }
                
            
            }).find(':checkbox').change();

            
            $('#save').click(function() {
                $('.trid').each(function (index, value) {
                    var combo;
                    var idp;
                    var idpr;
                    var addnno;
                    var params = '';
                    var p = 0;
                    if ($(this).find('.cek').val() == 'Y') {
                        $('#divLoading').show();
                        if ($(this).find('.combo1').is(':checked')) {
                            idpr = $(this).find('.idpr').val();
                            combo = $(this).find('.combo1').val();
                            idp = '0';
                            addnno = '0';
                        }
                        if ($(this).find('.combo2').is(':checked')) {
                            idpr = $(this).find('.idpr').val();
                            combo = $(this).find('.combo2').val();
                            idp = $(this).find('.inputidp').val();
                            addnno = $(this).find('.addnno').val();
                        }
                        if (combo == 'addendum' && (idp == '' || addnno == '')) {
                            $('#divLoading').hide();
                            alert("Jika Pilihan addendum Mohon isi juga form Referensi dan no addendum");
                        }else{
                            params = "idasli="+idpr+"&jenis="+combo+"&ref="+idp+"&add="+addnno;
                            $.ajax({
                                url: "getdummy",
                                type: "POST",
                                data:params,
                                success: function(response){
                                    console.log(response);
                                    $('#divLoading').hide();    
                                }
                            });
                            console.log(params);
                            $(this).remove();
                        }
                    }
                }); 
            });


            $('#checkontrak').click(function() {
                $('.trid').each(function (index, value) {
                    if ($(this).find('.cek').prop('checked') == false) {
                        $(this).find('.cek').prop('checked',true);
                        $(this).closest('tr').css('background-color', '#7895ff');
                        $(this).find('.cek').val('Y');
                        $(this).closest('tr').find('input:text').removeAttr('disabled');
                        $(this).closest('tr').find('input:radio').removeAttr('disabled'); 
                    }else{
                        $(this).find('.cek').prop('checked',false);
                        $(this).closest('tr').find('input:text').attr('disabled','disabled');
                        $(this).closest('tr').find('input:radio').attr('disabled','disabled');
                        $(this).closest('tr').css('background-color', '');
                        $(this).find('.cek').val('N');
                    }
                    
                    //console.log(a);
                });
                // $('.trid').find('input[type="checkbox"]').each(function() {
                //     if ($(this).is(':checked')) {
                //     $(this).prop('checked', true);
                //     } else {
                //     $(this).prop('checked', false);
                //     }
                // });
            });


            $('#example').DataTable( {
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
        
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    //console.log(intVal());
                    // Total over all pages
                    total = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
        
                    // Total over this page
                    pageTotal = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                

                    // Total filtered rows on the selected column (code part added)
                    var sumCol4Filtered = display.map(el => data[el][4]).reduce((a, b) => intVal(a) + intVal(b), 0 );
                
                    // Update footer
                    $( api.column( 4 ).footer() ).html(
                        'Total Per Halaman <br> Rp.'+parseInt(pageTotal).toLocaleString()+''
                    );
                    $( api.column( 8 ).footer() ).html(
                        'Total Semua <br> Rp.'+ parseInt(total).toLocaleString() +''
                    );
                    $( api.column( 6 ).footer() ).html(
                        'Total Yg Di Filter <br> Rp.' + parseInt(sumCol4Filtered).toLocaleString() +')'
                    );
                }
            } );

        });

        
        
    </script>
</body>

</html>