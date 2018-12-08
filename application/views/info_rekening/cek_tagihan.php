<?php $this->load->view('template_elite/header.php');?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Info Tagihan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Info Tagihan</a></li>
                    <li class="breadcrumb-item active">Cek Info Tagihan</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <form action="">
                        <div class="form-body">
                            <h3 class="card-title">Cek Tagihan Anda :</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Periode :</strong> </label>
                                        <select name="periode" class="form-control">
                                            <option value="">November 2018</option>
                                            <option value="">Oktober 2018</option>
                                            <option value="">September 2018</option>
                                            <option value="">Agustus 2018</option>
                                            <option value="">Juli 2018</option>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                         <button class="btn btn-success" type="button" id="btn-cek">
                                            <i class="fa fa-mail"></i>
                                            Cek Tagihan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="info-tagihan" style="display:none;">
                                <div class="col-md-12">
                                    <hr>
                                    <h3 class="card-title">Informasi Tagihan Anda :</h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">ID Pelanggan :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"> 57312718282 </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Nama :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"> Wiliam Decosta </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Bulan / Tahun :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"> November 2018 </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Stand Meter :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"> 0000000090 - 000000187 </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Denda :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"> Rp.0</p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Total :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"> Rp. 350,000 </p>
                                        </div>
                                    </div>
									<button class="btn btn-success"><span class="btn-label"><i class="far fa-envelope"></i></span> Kirim Email</button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    $(function() {
        $('#btn-cek').on('click', function(e) {
            $('#info-tagihan').show();
        });
    });

</script>

<?php $this->load->view('template_elite/footer.php');?>