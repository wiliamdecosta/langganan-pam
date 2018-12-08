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

                            <div class="row">
                                
                                <div class="col-xlg-10 col-lg-9 col-md-8 bg-light border-left">
								
                                    <div class="card-body p-t-0">
                                        <div class="card b-all shadow-none">
                                            <div class="card-body">
                                                <h3 class="card-title m-b-0">Ada pipa yang patah</h3>
                                            </div>
                                            <div>
                                                <hr class="m-t-0">
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex m-b-40">
                                                    <div>
                                                        <a href="javascript:void(0)"><img src="../assets/images/users/1.jpg" alt="user" width="40" class="img-circle"></a>
                                                    </div>
                                                    <div class="p-l-10">
                                                        <h4 class="m-b-0">Asep Sunandar</h4>
                                                        <small class="text-muted">dari: sunandar@gmail.com</small>
                                                    </div>
                                                </div>
                                                <p><b>Yth. PDAM Tirta Wening Kota Bandung</b></p>
												<p>Air pdam di sampangan jl dewi sartika perum unnes sudah mati 4 hari pak. Mohon bantuannya. </p>
                                                 </div>
                                            <div>
                                                <hr class="m-t-0">
                                            </div>
                                            <div class="card-body">
                                                <h4><i class="fa fa-paperclip m-r-10 m-b-10"></i> Lampiran <span>(3)</span></h4>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <a href="javascript:void(0)"> <img class="img-thumbnail img-responsive" alt="attachment" src="../assets/images/big/img1.jpg"> </a>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="javascript:void(0)"> <img class="img-thumbnail img-responsive" alt="attachment" src="../assets/images/big/img2.jpg"> </a>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="javascript:void(0)"> <img class="img-thumbnail img-responsive" alt="attachment" src="../assets/images/big/img3.jpg"> </a>
                                                    </div>
                                                </div>
												<hr>
                                               
                                            </div>
											
                                        </div>
                                    </div>
                                </div>
								 <div class="col-xlg-2 col-lg-3 col-md-4">
								
									<h5><b> Nomor Laporan </b></h4>
									<p class="text-danger">#11000290 </p>
									<br>
									
									<h5><b> Tanggal Laporan </b></h4>
									<p class="text-danger"> 20 October 2018 21:17:14 </p>
									<br>
									
									<h5><b> Lokasi </b></h4>
									<p class="text-danger"> Bandung Timur </p>
									 <br>
									 
									 <h5><b> Status </b></h4>
									<select class="form-control">
										<option> Menunggu</option>
										<option> Sedang Proses</option>
										<option> Selesai</option>
									</select>
									 <br>
									 <br>
									 
									 <h5><b> Upload Pekerjaan </b></h4>
									 <input type="file" class="form-control">
										
									 
									<hr>
									<a href="<?php echo site_url("aduan_pelanggan");?>" class="btn btn-success">Simpan</a>
									<a href="<?php echo site_url("aduan_pelanggan");?>" class="btn btn-white">Kembali</a>
								</div>
								
                            </div>
                        </div>
                    </div>
                </div>
     

<?php $this->load->view('template_elite/footer.php');?>