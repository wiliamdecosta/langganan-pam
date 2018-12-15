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
                                        <label class="control-label"><strong>ID Pelanggan :</strong> </label>
                                        <input type="text" class="form-control" id="no_pelanggan" value="<?php echo $this->session->userdata('no_pelanggan'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><strong>Periode :</strong> </label>
                                        <select id="periode" name="periode" class="form-control">
                                            <?php for ($i = 1; $i < 4; $i++): ?>
                                                <option value="<?php echo date('m-Y', strtotime("-$i month")); ?>"><?php echo date('F Y', strtotime("-$i month")); ?></option>
                                            <?php endfor; ?>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                         <button class="btn btn-success" type="button" id="btn-cek">
                                            Cek Tagihan
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="info-empty" style="display:none;">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <h4 id="info-empty-html"></h4>
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
                                            <p class="form-control-static" id="info-nopel"> 57312718282 </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Nama :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static" id="info-nama"> Wiliam Decosta </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Alamat :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static" id="info-alamat"> Jl.abc </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Bulan / Tahun :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static" id="info-periode"> November 2018 </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Stand Meter :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static" id="info-standmeter"> 0000000090 - 000000187 </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3">Pemakaian :</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static" id="info-pemakaian"> 1 </p>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-3"><b>Total Tagihan :</b></label>
                                        <div class="col-md-9">
                                            <p class="form-control-static" id="info-total-tagihan"> Rp. 350,000 </p>
                                        </div>
                                    </div>
									<button class="btn btn-success" type="button" onclick="sendEmailTagihan();"><span class="btn-label"><i class="far fa-envelope"></i></span> Kirim Email</button>
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

            $.ajax({
                url: '<?php echo WS_JQGRID."tagihan.tagihan_controller/cek_info_tagihan"; ?>',
                dataType: "json",
                type: "POST",
                data: {
                    periode : $('#periode').val(),
                    no_pelanggan : $('#no_pelanggan').val()
                },
                success: function (data) {

                    if(data.rows == null) {
                        //$('#info-tagihan').html('<h4>Maaf, data info tagihan Anda belum tersedia untuk periode '+ $('#periode option:selected').text() +'</h4>');
                        $('#info-empty-html').html('<i>Maaf, data info tagihan Anda belum tersedia untuk periode '+ $('#periode option:selected').text() + '</i>');
                        $('#info-empty').show();
                        $('#info-tagihan').hide();

                    }else {
                        var info_tagihan = data.rows;

                        $('#info-nopel').html(info_tagihan.nolang);
                        $('#info-nama').html(info_tagihan.nama);
                        $('#info-alamat').html(info_tagihan.alamat);
                        $('#info-periode').html(info_tagihan.periode_tagihan);
                        $('#info-standmeter').html(info_tagihan.stand_awal + ' - ' + info_tagihan.stan_akhir);
                        $('#info-pemakaian').html(info_tagihan.pemakaian);
                        $('#info-total-tagihan').html('<strong>Rp. '+ $.number(info_tagihan.tagihan, 0)+'</strong>');

                        $('#info-tagihan').show();
                        $('#info-empty').hide();
                    }
                },
                error: function (xhr, status, error) {
                    swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                }
            });
        });
    });


    function sendEmailTagihan() {

        Swal({
            title: 'Konfirmasi',
            text: "Anda yakin ingin mengirim tagihan ke email ?",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#538cf6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Yakin'
            }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?php echo WS_JQGRID."tagihan.tagihan_controller/send_email_tagihan"; ?>',
                    dataType: "json",
                    type: "POST",
                    data: {
                        periode : $('#periode').val(),
                        no_pelanggan : $('#no_pelanggan').val()
                    },
                    success: function (data) {
                        if(data.success) {
                            swal('Berhasil', data.message,'success');
                        }else {
                            swal('Error', data.message,'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
                    }
                });
            }
        });


    }

</script>

<?php $this->load->view('template_elite/footer.php');?>