<tbody>
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <?php if (count($find_type_max) == 0): ?>

                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <div class="fa fa-info-circle"></div> Tidak Ada Data<br>
                                        </div>
                                    <?php else: ?>
                                        <?php if ($this->session->flashdata('message')): ?>
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div class="fa  fa-check"></div> <?php echo $this->session->flashdata('message'); ?><br>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                        <input type="hidden" id="jml_group" value="<?php echo count($version_history) ?>">
                                        <input type="hidden" id="versi_max" value="<?php echo $find_history_max ?>">
                                        <input type="hidden" name="id_risiko" value="<?php echo ($row_subprogram == null) ? '' : $row_subprogram->RKAP_SUBPRO_ID ?>" class="form-control" id="id_risiko">
                                       
                                      <?php $no = 0;  for ($i=0; $i<count($find_type_max); $i++) {$no++; ?>
                                        <tr id="hide_tr<?php echo $no ?>">
                                           <!--  <?php if ($version_history[$i]->RISK_VERSION == null): ?>
                                                
                                            <?php endif ?> -->
                                            <input type="hidden" name="risiko_version[]" value="<?php echo ($row_subprogram_risiko_history == null) ? 0 : $version_history[$i]->RISK_VERSION ?>" class="form-control" id="risiko_version">
                                         
                                           <td><?php echo $no; ?></td>
                                            <td><input class="form-control" type="text" name="risiko_tipe_tampil[]" id="risiko_tipe_tampil<?php echo $no ?>" value="<?php echo $find_type_max[$i]->tipe; ?>" readonly>
                                            <input class="form-control" type="hidden" name="risiko_tipe[]" id="risiko_tipe<?php echo $no ?>" value="<?php echo $find_type_max[$i]->RISK_TYPE; ?>" readonly>
                                            </td>
                                            <td><input class="form-control" type="text" name="risiko_deskripsi[]" id="risiko_deskripsi<?php echo $no ?>"  value="<?php echo $find_type_max[$i]->RISK_DESC; ?>" readonly ></td>
                                            <td><input class="form-control" type="text" name="dampak_risiko_tampil[]" id="dampak_risiko_tampil<?php echo $no ?>" value="<?php echo $find_type_max[$i]->dampak; ?>" readonly>
                                                <input class="form-control" type="hidden" name="dampak_risiko[]" id="dampak_risiko<?php echo $no ?>" value="<?php echo $find_type_max[$i]->RISK_IMPACT; ?>" readonly>
                                            </td>
                                            <td><input class="form-control" type="text" name="risiko_ik[]" id="risiko_ik<?php echo $no ?>" value="<?php echo $find_type_max[$i]->RISK_IK; ?>" readonly></td>
                                           <td><input class="form-control" type="text" name="risiko_id[]" id="risiko_id<?php echo $no ?>" value="<?php echo $find_type_max[$i]->RISK_ID; ?>" readonly></td>
                                            <td>
                                                <?php if ($row_subprogram_risiko == null): ?>
                                                    <?php $warna = "label-transparent"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == null && $find_type_max[$i]->RISK_ID == null): ?>
                                                    <?php $warna = "label-transparent"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == null OR $find_type_max[$i]->RISK_ID == null): ?>
                                                    <?php $warna = "label-transparent"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == 1 && $find_type_max[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 1 && $find_type_max[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-success"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 1 && $find_type_max[$i]->RISK_ID == 3): ?>
                                                     <?php $warna = "label-success-second"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 1 && $find_type_max[$i]->RISK_ID == 4): ?>
                                                     <?php $warna = "label-warning"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 1 && $find_type_max[$i]->RISK_ID == 5): ?>
                                                     <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == 2 && $find_type_max[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 2 && $find_type_max[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 2 && $find_type_max[$i]->RISK_ID == 3): ?>
                                                     <?php $warna = "label-warning"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 2 && $find_type_max[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 2 && $find_type_max[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == 3 && $find_type_max[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 3 && $find_type_max[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 3 && $find_type_max[$i]->RISK_ID == 3): ?>
                                                     <?php $warna = "label-warning"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 3 && $find_type_max[$i]->RISK_ID == 4): ?>
                                                     <?php $warna = "label-warning-second"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 3 && $find_type_max[$i]->RISK_ID == 5): ?>
                                                     <?php $warna = "label-danger"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == 4 && $find_type_max[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 4 && $find_type_max[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 4 && $find_type_max[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 4 && $find_type_max[$i]->RISK_ID == 4): ?>
                                                     <?php $warna = "label-danger"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 4 && $find_type_max[$i]->RISK_ID == 5): ?>
                                                     <?php $warna = "label-danger"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == 5 && $find_type_max[$i]->RISK_ID == 1): ?>
                                                   <?php $warna = "label-warning"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 5 && $find_type_max[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 5 && $find_type_max[$i]->RISK_ID == 3): ?>
                                                     <?php $warna = "label-warning-second"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 5 && $find_type_max[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-danger"; ?>
                                                 <?php elseif($find_type_max[$i]->RISK_IK == 5 && $find_type_max[$i]->RISK_ID == 5): ?>
                                                     <?php $warna = "label-danger"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == 1 && $find_type_max[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 2 && $find_type_max[$i]->RISK_ID == 1): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 3 && $find_type_max[$i]->RISK_ID == 1): ?>
                                                     <?php $warna = "label-success-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 4 && $find_type_max[$i]->RISK_ID == 1): ?>
                                                     <?php $warna = "label-success-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 5 && $find_type_max[$i]->RISK_ID == 1): ?>
                                                     <?php $warna = "label-warning"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == 1 && $find_type_max[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-success"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 2 && $find_type_max[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 3 && $find_type_max[$i]->RISK_ID == 2): ?>
                                                     <?php $warna = "label-success-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 4 && $find_type_max[$i]->RISK_ID == 2): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 5 && $find_type_max[$i]->RISK_ID == 2): ?>
                                                     <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == 1 && $find_type_max[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-success-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 2 && $find_type_max[$i]->RISK_ID == 3): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 3 && $find_type_max[$i]->RISK_ID == 3): ?>
                                                     <?php $warna = "label-warning"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 4 && $find_type_max[$i]->RISK_ID == 3): ?>
                                                     <?php $warna = "label-warning-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 5 && $find_type_max[$i]->RISK_ID == 3): ?>
                                                     <?php $warna = "label-warning-second"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == 1 && $find_type_max[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-warning"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 2 && $find_type_max[$i]->RISK_ID == 4): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 3 && $find_type_max[$i]->RISK_ID == 4): ?>
                                                     <?php $warna = "label-warning-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 4 && $find_type_max[$i]->RISK_ID == 4): ?>
                                                     <?php $warna = "label-danger"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 5 && $find_type_max[$i]->RISK_ID == 4): ?>
                                                     <?php $warna = "label-danger"; ?>
                                                <?php elseif ($find_type_max[$i]->RISK_IK == 1 && $find_type_max[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 2 && $find_type_max[$i]->RISK_ID == 5): ?>
                                                    <?php $warna = "label-warning-second"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 3 && $find_type_max[$i]->RISK_ID == 5): ?>
                                                     <?php $warna = "label-danger"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 4 && $find_type_max[$i]->RISK_ID == 5): ?>
                                                     <?php $warna = "label-danger"; ?>
                                                <?php elseif($find_type_max[$i]->RISK_IK == 5 && $find_type_max[$i]->RISK_ID == 5): ?>
                                                     <?php $warna = "label-danger"; ?>
                                                <?php endif ?>
                                                
                                                <span class="label <?php echo $warna ?>" id="color<?php echo $no ?>">Label warna</span>
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="risiko_penanganan[]" id="risiko_penanganan<?php echo $no ?>" value="<?php echo $find_type_max[$i]->RISK_SOLVING; ?>" readonly>
                                            </td>
                                               <td align=" center">
                                                <a href="<?php echo base_url() ?>risiko/update/<?php echo $find_type_max[$i]->SUBPRO_RISK_ID ?>" class="btn btn-sm btn-info" title="Edit Data"><i class="fa fa-gears"></i></a>
                                                <a href="<?php echo base_url() ?>risiko/delete_modal/<?php echo $find_type_max[$i]->SUBPRO_RISK_ID ?>" class="btn btn-sm btn-danger" title="Hapus Data" data-toggle="modal" data-target="#hapus" ><i class="fa fa-trash-o" ></i></a>
                                            </td>                                    
                                        </tr>
                                    <?php } ?> 
                                <?php endif; ?> 
                            </tbody>