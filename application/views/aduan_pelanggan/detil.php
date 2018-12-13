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

    <?php if(isChatExist($this->uri->segment(3))):?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Respon kepada Admin :</h5>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="hidden" id="nomor_laporan" value="<?php echo $this->uri->segment(3);?>">
                            <input class="form-control col-md-10" id="i_comment" placeholder="Kirim tanggapan Anda.." aria-label="" aria-describedby="basic-addon1" type="text">
                            <div class="input-group-append">
                                <button id="btn-send" onClick="sendComment();" class="btn btn-info" type="button"><i class="fas fa-envelope"></i> Kirim Pesan </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

                <!-- ============================================================== -->
                <!-- Comment widgets -->
                <!-- ============================================================== -->
                <div class="comment-widgets" id="comment-box" style="max-height:300px;overflow-y:scroll;">
                    <!-- Comment Row -->
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>


<?php if(isChatExist($this->uri->segment(3))):?>
<script>
    $(function() {
        reloadComments();
    });

    function reloadComments() {
        $.ajax({
            url: '<?php echo WS_JQGRID."aduan.chat_laporan_aduan_controller/reload_comments"; ?>',
            dataType: "json",
            type: "POST",
            data: {
                laporan_no : $('#nomor_laporan').val()
            },
            success: function (data) {
                $('#comment-box').html(data.comments);
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }

    function sendComment() {

        if($('#i_comment').val() == '') {
            Swal({
                title: 'Silahkan mengisi tanggapan Anda',
                animation: false,
                customClass: 'animated tada'
            });
            return;
        }

        $.ajax({
            url: '<?php echo WS_JQGRID."aduan.chat_laporan_aduan_controller/send_comment"; ?>',
            dataType: "json",
            type: "POST",
            data: {
                laporan_no : $('#nomor_laporan').val(),
                message: $('#i_comment').val()
            },
            success: function (data) {
                if(data.success) {
                    $('#comment-box').html(data.comments);
                    $('#i_comment').val('');
                }
            },
            error: function (xhr, status, error) {
                swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
            }
        });
    }
</script>
<?php endif; ?>

<?php $this->load->view('template_elite/footer.php');?>