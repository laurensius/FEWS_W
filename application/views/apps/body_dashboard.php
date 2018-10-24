    <div class="container">
        <center>
            <h2>Tabel Status Sensor</h2>
        <center>
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Nama Toko</th>
                    <th>Alamat Toko</th>
                    <th>Suhu</th>
                    <th>Asap</th>
                    <th>Api</th>
                    <th>Waktu Update</th>
                </tr>
            </thead>
            <tbody id="tabel_body">
                <tr><td colspan="8">Loading . . .</td></tr>
            </tbody>
        </table>
    </div><!-- /.container -->
    <script>
    $(document).ready(function(){
        function load_data(){ 
            $.ajax({
                url : '<?php echo site_url(); ?>/api/admin_monitoring/' + (Math.floor(Math.random() * 99999) + 1) + '/',
                type : 'GET',
                dataType : 'json',
                success : function(response){
                   //console.log(response.monitoring.length);
                   if(response.monitoring.length > 0){
                       var str = '';
                       var ctr = 1;
                       for(var x=0;x<response.monitoring.length;x++){
                            str += '<tr>';
                            str += '<td>' + ctr + '</td>';
                            str += '<td>' + response.monitoring[x].nama + '</td>';
                            str += '<td>' + response.monitoring[x].nama_toko + '</td>';
                            str += '<td>' + response.monitoring[x].alamat_toko + '</td>';
                            str += '<td>' + response.monitoring[x].cat_suhu + '</td>';
                            str += '<td>' + response.monitoring[x].cat_asap + '</td>';
                            str += '<td>' + response.monitoring[x].cat_api + '</td>';
                            str += '<td>' + response.monitoring[x].datetime + '</td>';
                            str += '</tr>';
                            ctr++;
                       }
                       $('#tabel_body').html(str);
                   }else{
                        $('#tabel_body').html('<tr><td colspan="8">Tidak ada data</td></tr>');
                   }

                },
                error : function(response){
                    
                },
            });
        }
        setInterval(function(){load_data();},3000);
    });
    </script>
    

    