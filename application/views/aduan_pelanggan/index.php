<?php $this->load->view('template_elite/header.php');?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Aduan Pelanggan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Aduan Pelanggan</a></li>
                    <li class="breadcrumb-item active">List Aduan</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 bg-light">
            <div class="card-body">
                <div class="btn-group m-b-10 m-r-10" role="group" aria-label="Button group with nested dropdown">
                    <button type="button" class="btn btn-secondary font-18"><i class="mdi mdi-inbox-arrow-down"></i></button>
                    <button type="button" class="btn btn-secondary font-18"><i class="mdi mdi-alert-octagon"></i></button>
                    <button type="button" class="btn btn-secondary font-18"><i class="mdi mdi-delete"></i></button>
                </div>
            </div>

            <div class="card-body p-t-0">
                <div class="card b-all ">
                    <div class="inbox-center table-responsive">
                        <table class="table table-hover no-wrap">
                            <thead>
                                <tr>
                                    <th>Check</th>
                                    <th>No Laporan</th>
                                    <th>Lokasi</th>
                                    <th>Keluhan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-right">Tanggal Lapor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="unread">
                                    <td style="width:40px">
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input class="custom-control-input" id="checkbox0" value="check" type="checkbox">
                                            <label class="custom-control-label" for="checkbox0"></label>
                                        </div>
                                    </td>
                                    <td><a href="<?php echo site_url('aduan_pelanggan/edit');?>"> 11000290</a></td>
                                    <td class="hidden-xs-down">Bandung Kota</td>
                                    <td class="max-texts">  Ada pipa yang patah..</td>
                                    <td class="text-center"> <span class="label label-warning">Menunggu</span> </td>
                                    <td class="text-right"> 20 October 2018 21:17:14 </td>
                                </tr>
                                <tr class="unread">
                                    <td>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input class="custom-control-input" id="checkbox1" value="check" type="checkbox">
                                            <label class="custom-control-label" for="checkbox1"></label>
                                        </div>
                                    </td>
                                    <td><a href="javascript:void(0)"> 11000291</a></td>
                                    <td class="hidden-xs-down">Bandung Timur</td>
                                    <td class="max-texts">Pipa Bocor</td>
                                    <td class="text-center"> <span class="label label-success">Selesai</span> </td>
                                    <td class="text-right"> 22 October 2018 21:17:14 </td>
                                </tr>
                                <tr class="unread">
                                    <td>
                                        <div class="custom-control custom-checkbox mr-sm-2">
                                            <input class="custom-control-input" id="checkbox2" value="check" type="checkbox">
                                            <label class="custom-control-label" for="checkbox2"></label>
                                        </div>
                                    </td>
                                    <td><a href="javascript:void(0)"> 11000292</a></td>
                                    <td class="hidden-xs-down">Bandung Barat</td>
                                    <td class="max-texts"> Air tampak kotor di rumah saya </td>
                                    <td class="text-center"> <span class="label label-info">Sedang Proses</span> </td>
                                    <td class="text-right"> 29 October 2018 21:17:14 </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('template_elite/footer.php');?>