<?php $this->load->view('template_elite/header.php');?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Aduan Pelanggan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">

                    <li class="breadcrumb-item active">Detail Aduan</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
                <div class="row">
                    <div class="col-xlg-10 col-lg-9 col-md-8 bg-light border-left">
                        <div class="card">
                            <div class="card-body p-t-0">
                                <div class="card b-all shadow-none">
                                    <div class="card-body">
                                        <span style="display:block; padding:10px; float:right; clear:right;" class="<?php echo getClassStatus($status_laporan); ?>"><?php echo $status_laporan; ?></span>
                                        <h3 class="card-title m-b-0"><?php echo $subyek_aduan; ?></h3>
                                    </div>
                                    <div>
                                        <hr class="m-t-0">
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex m-b-40">
                                            <div>
                                                <a href="javascript:void(0)"><img src="<?php echo base_url();?>assets/images/users/green.png" alt="user" width="40" class="img-circle"></a>
                                            </div>
                                            <div class="p-l-10">
                                                <h4 class="m-b-0"><?php echo $nama; ?></h4>
                                                <small class="text-muted">dari: <?php echo $email; ?></small>
                                            </div>
                                        </div>
                                        <p><?php echo $isi_aduan; ?></p>
                                        </div>
                                    <div>
                                        <hr class="m-t-0">
                                    </div>
                                    <div class="card-body">
                                        <h4><i class="fas fa-location-arrow"></i> Alamat Aduan : <span> <?php echo $alamat_aduan; ?></span></h4>
                                    </div>
                                    <div>
                                        <hr class="m-t-0">
                                    </div>
                                    <div class="card-body">
                                        <h4><i class="fa fa-paperclip"></i> Lampiran <span>(<?php echo count($lampiran); ?>)</span></h4>
                                        <div class="row">
                                            <?php foreach($lampiran as $gambar): ?>
                                            <div class="col-md-2">
                                                <a href="<?php echo base_url('upload/aduan_evidences/'.$gambar);?>"> <img class="img-thumbnail img-responsive" alt="attachment" src="<?php echo base_url('upload/aduan_evidences/'.$gambar);?>"> </a>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xlg-2 col-lg-3 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data" action="<?php echo site_url("aduan_pelanggan/update_aduan_admin");?>">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <h5><b> Nomor Laporan </b></h4>
                                    <p class="text-danger"><?php echo $laporan_no; ?> </p>
                                    <br>

                                    <h5><b> Tanggal Laporan </b></h4>
                                    <p class="text-danger"> <?php echo $tgl_laporan; ?> </p>
                                    <br>

                                    <h5><b> Lokasi </b></h4>
                                    <p class="text-danger"> <?php echo $lokasi_nama; ?> </p>
                                    <br>

                                    <h5><b> Status </b></h4>
                                    <select name="status_laporan" class="form-control">
                                        <?php foreach(getStatusList() as $key => $status): ?>
                                            <option <?php if($status_laporan == $key) echo 'selected'; ?> value="<?php echo $key;?>"><?php echo $status;?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <br>
                                    <br>
                                    <input type="hidden" name="current_status" value="<?php echo $status_laporan; ?>">
                                    <input type="hidden" name="laporan_no" value="<?php echo $laporan_no; ?>">
                                    <h5><b> Upload Pekerjaan <br> (Max: 3MB) </b></h4>

                                    <input type="file" name="file_pekerjaan" class="form-control">
                                    <br>
                                    <a href="<?php echo base_url('upload/file_pekerjaan/'.$upload_file_pekerjaan);?>"><?php echo $upload_file_pekerjaan; ?></a>
                                    <hr>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <a href="<?php echo site_url("aduan_pelanggan/index_admin");?>" class="btn btn-primary">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

<?php if($this->session->flashdata('error_message') != ""): ?>
    <script>
        Swal(
            'Error',
            <?php echo "'".$this->session->flashdata('error_message')."'"; ?>,
            'warning'
        )
    </script>
<?php endif; ?>

<?php $this->load->view('template_elite/footer.php');?>