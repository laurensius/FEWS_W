<div class="container">
        <center>
            <h2>Tabel List Pengguna</h2>
        </center>
        <br>
        <div class="container">
            <a href="<?php echo site_url('apps/pengguna_tambah/'); ?>" class="btn btn-success">
            <span class="glyphicon glyphicon-plus-sign"></span>
            Tambah Penguna
            </a>
        </div>
        <br>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Nama Toko</th>
                    <th>Alamat Toko</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tabel_body">
                <tr><td colspan="5">Loading . . .</td></tr>
            </tbody>
        </table>
    </div><!-- /.container -->
    <script>
    $(document).ready(function(){
        $.ajax({
            url : '<?php echo site_url(); ?>/api/admin_list_pengguna/' ,
            type : 'GET',
            dataType : 'json',
            success : function(response){
                console.log(response.length);
                if(response.length > 0){
                    var str = '';
                    var ctr = 1;
                    for(var x=0;x<response.length;x++){
                        str += '<tr>';
                        str += '<td>' + ctr + '</td>';
                        str += '<td>' + response[x].nama + '</td>';
                        str += '<td>' + response[x].nama_toko + '</td>';
                        str += '<td>' + response[x].alamat_toko + '</td>';
                        str += '<td>';
                        str += '<a href="<?php echo site_url('apps/pengguna_detail/'); ?>' + response[x].id  + '" class="btn btn-primary">Detail</a> ';
                        str += '<a href="<?php echo site_url('apps/pengguna_edit/'); ?>' + response[x].id  + '" class="btn btn-success">Edit</a> ';
                        str += '<button onclick="delete_user(\''+response[x].api_key+'\');" class="btn btn-danger">Hapus</button>';
                        // str += '<a href="<?php echo site_url('apps/pengguna_delete/'); ?>' + response[x].api_key  + '" class="btn btn-danger">Delete</a>';
                        str += '</td>';
                        str += '</tr>';
                        ctr++;
                    }
                    $('#tabel_body').html(str);
                }else{
                    $('#tabel_body').html('<tr><td colspan="5">Tidak ada data</td></tr>');
                }

            },
            error : function(response){
                
            },
        });

    });

    function delete_user(api_key){
            $.ajax({
                url : '<?php echo site_url(); ?>/api/pengguna_delete/' + api_key + '/' ,
                type : 'GET',
                dataType : 'json',
                success : function(response){
                    console.log(response.length);
                    if(response.severity == "success"){
                        alert(response.message);
                        window.location = '<?php echo site_url("/apps/pengguna/"); ?>';
                    }else{
                        alert(response.message);
                        window.location = '<?php echo site_url("/apps/pengguna/"); ?>';
                    }
                },
                error : function(response){
                    alert("Server Error");
                    console.log(response.length);
                },
            });
        }//end of delete
    </script>
    

    