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
                <td>Password</td>
                <td>:</td>
                <td id="param_password">Loading . . .</td>
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
        <button class="btn btn-primary" onclick="update();">Update</button>
        <center>
    </div><!-- /.container -->
    <script>
        $.ajax({
            url : '<?php echo site_url("/api/pengguna_detail/1/" ); ?>' ,
            type : 'GET',
            dataType : 'json',
            success : function(response){
                if(response.length > 0){
                    $('#param_username').html('<input id="username" class="form-control" type="text" name="p_username" value="' + response[0].username + '" disabled required>');
                    $('#param_password').html('<input id="password" class="form-control" type="password" name="p_password" value="' + response[0].password + '" required>');
                    $('#param_nama').html('<input id="nama" class="form-control" type="text" name="p_nama" value="' + response[0].nama + '" required>');
                    $('#param_nama_toko').html('<input id="nama_toko" class="form-control" type="text" name="p_nama_toko" value="' + response[0].nama_toko + '" disabled required>');
                    $('#param_alamat_toko').html('<input id="alamat_toko" class="form-control" type="text" name="p_alamat_toko" value="' + response[0].alamat_toko + '" disabled required>');
                    $('#param_api_key').html('<input id="api_key" class="form-control" type="text" name="p_api_key" value="' + response[0].api_key + '" disabled required>');  
                }else{
                    $('#tabel_body').html('<tr><td colspan="3">Tidak ada data</td></tr>');
                }

            },
            error : function(response){
                
            },
        });

        function update(){
            var password = document.getElementById("password").value;
            var nama = document.getElementById("nama").value;
            var nama_toko = document.getElementById("nama_toko").value;
            var alamat_toko = document.getElementById("alamat_toko").value;
            var post = {
                "password" : password,
                "nama" : nama,
                "nama_toko" : nama_toko,
                "alamat_toko" : alamat_toko
            };  
            console.log(post);
            $.ajax({
                url : '<?php echo site_url("/api/pengguna_update/1/") ; ?>'  ,
                type : 'POST',
                dataType : 'json',
                data: post,
                success : function(response){
                    console.log(response);
                    if(response.severity == "success"){
                        alert(response.message);
                       // window.location = '<?php echo site_url("/apps/admin/"); ?>';
                    }else{
                        alert(response.message);
                        //window.location = '<?php echo site_url("/apps/admin/"); ?>';
                    }
                },
                error : function(response){
                    alert("Server Error");
                },
            });
        }
    </script>
    

    