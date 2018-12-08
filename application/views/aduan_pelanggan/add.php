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
                    <form action="<?php echo site_url('aduan_pelanggan');?>">
                        <div class="form-body">
                            <h3 class="card-title">Tuliskan Aduan Anda di Sini :</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Lokasi :</strong> </label>
										<select class="form-control">
											<option> Bandung Kota </option>
											<option> Bandung Barat </option>
											<option> Bandung Timur </option>
											<option> Bandung Selatan </option>
											<option> Bandung Utara </option>
										</select>
                                        
                                    </div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label"><strong>Alamat Lengkap</strong> </label>
												<input id="lokasi" class="form-control" required="" placeholder="" type="text">
											</div>
										</div>
									</div>
                                    <div class="form-group">
                                        <label class="control-label"><strong>Keluhan : </strong></label>
                                        <input id="lokasi" class="form-control" required="" placeholder="Tuliskan subyek aduan.." type="text">
                                    </div>
                                </div>
                            </div>
							 
							
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Deksripsi : </strong></label>
                                        <textarea id="lokasi" class="form-control" required="" placeholder="Deskripsikan aduan Anda di sini.."></textarea>
                                    </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Upload Foto : </strong></label>
                                        <input class="form-control" type="file">
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

<?php $this->load->view('template_elite/footer.php');?>