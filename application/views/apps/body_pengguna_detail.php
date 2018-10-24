<div class="container">
        <center>
            <h2>Tabel Detail Pengguna</h2>
        <center>
        <table class="table table-hover table-striped " id="tabel_body">
            <tr>
                <td>Username</td>
                <td>:</td>
                <td id="param_username">Loading . . .</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td id="param_nama">Loading . . .</td>
            </tr>
            <tr>
                <td>Nama Toko</td>
                <td>:</td>
                <td id="param_nama_toko">Loading . . .</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td id="param_alamat_toko">Loading . . .</td>
            </tr>
            <tr>
                <td>API KEY</td>
                <td>:</td>
                <td id="param_api_key">Loading . . .</td>
            </tr>
        </table>
        <center>
        <a href="<?php echo site_url('apps/pengguna/'); ?>" class="btn btn-primary">Kembali</a>
        <center>
    </div><!-- /.container -->
    <script>
        $.ajax({
            url : '<?php echo site_url("/api/pengguna_detail/" .$this->uri->segment(3) . "/" ); ?>' ,
            type : 'GET',
            dataType : 'json',
            success : function(response){
                console.log(response.length);
                if(response.length > 0){
                    $('#param_username').html(response[0].username);
                    $('#param_nama').html(response[0].nama);
                    $('#param_nama_toko').html(response[0].nama_toko);
                    $('#param_alamat_toko').html(response[0].alamat_toko);
                    $('#param_api_key').html(response[0].api_key);  
                }else{
                    $('#tabel_body').html('<tr><td colspan="3">Tidak ada data</td></tr>');
                }

            },
            error : function(response){
                
            },
        });
    </script>
    

    