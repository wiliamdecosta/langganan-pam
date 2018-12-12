<?php $this->load->view('template_elite/header.php');?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Aduan Pelanggan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Aduan Pelanggan</a></li>
                    <li class="breadcrumb-item active">Tulis Aduan</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">Form Aduan</h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('aduan_pelanggan/kirim_aduan');?>">
                        <div class="form-body">
                            <h3 class="card-title">Tuliskan Aduan Anda di Sini :</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                        <label class="control-label"><strong>Lokasi :</strong> </label>
										<select required="" class="form-control" name="lokasi_id">
                                            <?php
                                                $sql = "SELECT * FROM lokasi";
                                                $query = $this->db->query($sql);
                                                $rows = $query->result_array();

                                                foreach($rows as $row):
                                            ?>
                                            <option value="<?php echo $row['lokasi_id'];?>"><?php echo $row['lokasi_nama'];?></option>
                                            <?php endforeach; ?>
										</select>

                                    </div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label"><strong>Alamat Lengkap</strong> </label>
												<input id="lokasi" class="form-control" name="alamat_aduan" required="" placeholder="Alamat aduan" type="text">
											</div>
										</div>
									</div>
                                    <div class="form-group">
                                        <label class="control-label"><strong>Keluhan : </strong></label>
                                        <input id="lokasi" class="form-control" name="subyek_aduan" required="" placeholder="Tuliskan subyek aduan" type="text">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Deksripsi : </strong></label>
                                        <textarea id="lokasi" class="form-control" name="isi_aduan" required="" placeholder="Deskripsikan aduan Anda di sini.."></textarea>
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Upload Foto 1 (Max.1MB) : </strong></label>
                                        <input class="form-control" type="file" name="uploadgambars[]">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><strong>Upload Foto 2 (Max.1MB) : </strong></label>
                                        <input class="form-control" type="file" name="uploadgambars[]">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><strong>Upload Foto 3 (Max.1MB) : </strong></label>
                                        <input class="form-control" type="file" name="uploadgambars[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-success" type="submit">
                                <i class="fa fa-mail"></i>
                                Kirim Aduan
                            </button>
                        </div>
                    </form>
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