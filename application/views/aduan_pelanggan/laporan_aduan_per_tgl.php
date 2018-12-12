<?php $this->load->view('template_elite/header.php');?>

<!-- Daterange picker plugins css -->
<link href="<?php echo base_url();?>assets/node_modules/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">


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
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h4 class="m-b-0 text-white">Laporan Aduan Per Tanggal</h4>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('aduan_pelanggan/kirim_aduan');?>">
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label"><strong>Tanggal : </strong></label>
                                        <div class="input-daterange input-group">
                                            <input class="form-control input-daterange-datepicker" id="tanggal_laporan" value="" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                        <label class="control-label"><strong>Lokasi :</strong> </label>
										<select required="" class="form-control" id="lokasi_id">
                                            <option value="all">Semua Lokasi</option>
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

                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-success" type="button" onClick="downloadLaporan();">
                                <i class="mdi mdi-file-excel"></i>
                                Download Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        function downloadLaporan() {

            var lokasi_id = $('#lokasi_id').val();
            var tanggal_laporan = $('#tanggal_laporan').val();

            var url = "<?php echo WS_JQGRID . "aduan.aduan_pelanggan_controller/download_laporan_aduan_admin/?"; ?>";
            url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
            url += "&lokasi_id="+lokasi_id;
            url += "&tanggal_laporan="+tanggal_laporan;

            Swal({
                title: 'Konfirmasi',
                text: "Anda yakin ingin melakukan download laporan?",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#538cf6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Yakin'
                }).then((result) => {
                if (result.value) {
                    window.location = url;
                }
            });
        }

    </script>

    <script>
        $(function() {
            $('.input-daterange-datepicker').daterangepicker({
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse',
                locale: {
                    format: 'YYYY/MM/DD'
                }
            });
        });
    </script>
    <!-- Plugin JavaScript -->
    <script src="../assets/node_modules/moment/moment.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="../assets/node_modules/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="../assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>

<?php $this->load->view('template_elite/footer.php');?>