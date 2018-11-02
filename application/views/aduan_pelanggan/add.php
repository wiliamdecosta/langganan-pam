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
                    <form action="">
                        <div class="form-body">
                            <h3 class="card-title">Tuliskan Aduan Anda di Sini :</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Lokasi :</strong> </label>
                                        <input id="lokasi" class="form-control" required="" placeholder="Tuliskan lokasi aduan.." type="text">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><strong>Mengenai : </strong></label>
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