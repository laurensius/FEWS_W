<div class="container">
        <center>
            <h2>Tabel Tambah Pengguna</h2>
        <center>
        <form action="javascript:;" class="login-form" method="post" id="form_daftar">
            <table class="table table-hover table-striped " id="tabel_body">
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td><input type="text" placeholder="Username" name="username" id="username" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>:</td>
                    <td><input type="password" placeholder="Password" name="password" id="password" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><input type="text" placeholder="Nama" name="nama" id="nama" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Nama Toko</td>
                    <td>:</td>
                    <td><input type="text" placeholder="Nama Toko" name="nama_toko" id="nama_toko"  class="form-control"required></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><input type="text" placeholder="Alamat" name="alamat_toko" id="alamat_toko" class="form-control" required></td>
                </tr>
            </table>
            <center>
            <a href="<?php echo site_url('apps/pengguna/'); ?>" class="btn btn-warning">Kembali</a>
            <input class="btn btn-primary" type="submit" value="Simpan Data" id="save">
            <center>
        </form>
        
    </div><!-- /.container -->
    <script>

    $(document).ready(function(){ 
        function save(){
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var nama = document.getElementById("nama").value;
            var nama_toko = document.getElementById("nama_toko").value;
            var alamat_toko = document.getElementById("alamat_toko").value;
            var post = {
                "username" : username,
                "password" : password,
                "nama" : nama,
                "nama_toko" : nama_toko,
                "alamat_toko" : alamat_toko,
                "api_key" : username + password
            };  
            $.ajax({
                url : '<?php echo site_url("/api/pengguna_simpan/"); ?>' ,
                type : 'POST',
                dataType : 'json',
                data: post,
                success : function(response){
                    if(response.severity == "success"){
                        alert(response.message);
                        window.location = '<?php echo site_url("/apps/pengguna/"); ?>';
                    }else{
                        alert(response.message);
                        window.location = '<?php echo site_url("/apps/pengguna_tambah/"); ?>';
                    }
                },
                error : function(response){
                    alert("Server Error");
                },
            });
        }

        $("#save").click(save);

    });
    </script>
    

    