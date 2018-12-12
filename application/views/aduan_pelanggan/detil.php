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
                            <h4><i class="fa fa-paperclip m-r-10 m-b-10"></i> Lampiran <span>(<?php echo count($lampiran); ?>)</span></h4>
                            <div class="row">
                                <?php foreach($lampiran as $gambar): ?>
                                <div class="col-md-2">
                                    <a href="<?php echo base_url('upload/aduan_evidences/'.$gambar);?>"> <img class="img-thumbnail img-responsive" alt="attachment" src="<?php echo base_url('upload/aduan_evidences/'.$gambar);?>"> </a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php $this->load->view('template_elite/footer.php');?>