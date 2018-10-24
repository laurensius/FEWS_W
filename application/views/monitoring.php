<!Doctype HTML>
<html>
<head>
    <meta http-equiv="refresh" content="3"/>
    <title>Debug Data Monitoring</title>
    <style>
    table.paleBlueRows {
        font-family: "Times New Roman", Times, serif;
        border: 1px solid #FFFFFF;
        width: 100%;
        text-align: center;
        border-collapse: collapse;
    }

    table.paleBlueRows td, table.paleBlueRows th {
        border: 1px solid #FFFFFF;
        padding: 3px 2px;
    }

    table.paleBlueRows tbody td {
        font-size: 14px;
    }

    table.paleBlueRows tr:nth-child(even) {
        background: #D0E4F5;
    }
    
    table.paleBlueRows thead {
        background: #0B6FA4;
        border-bottom: 5px solid #FFFFFF;
    }

    table.paleBlueRows thead th {
        font-size: 17px;
        font-weight: bold;
        color: #FFFFFF;
        text-align: center;
        border-left: 2px solid #FFFFFF;
    }
    
    table.paleBlueRows thead th:first-child {
        border-left: none;
    }

    table.paleBlueRows tfoot {
        font-size: 14px;
        font-weight: bold;
        color: #333333;
        background: #D0E4F5;
        border-top: 3px solid #444444;
    }

    table.paleBlueRows tfoot td {
        font-size: 14px;
        padding:10px;

    }
    </style>
</head>
<body>
    <table class="paleBlueRows">
        <thead>
            <tr>
                <th>Value Sensor Suhu</th>
                <th>Value Sensor LDR</th>
                <th>Value Sensor Ultrasonic</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="3"><?php $a = $recent[0]->cat_suhu != "Normal" || $recent[0]->cat_kekeruhan != "Normal" || $recent[0]->cat_kedalaman != "Normal"  ? $notif[0]->pesan_notifikasi : " - "; echo "Informasi : " . $a?> </td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td><?php echo $recent[0]->val_suhu; ?> <sup> o</sup>C</td>
                <td><?php echo $recent[0]->val_kekeruhan; ?> </td>
                <td><?php echo $recent[0]->val_kedalaman; ?> Cm</td>
            </tr>
        </tbody>
    </table>
</body>
</html>