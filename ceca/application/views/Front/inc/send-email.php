<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width"/>
    </head>

<body style="background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;">
  <table style="max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px #096fb1;">
    <thead>
      <tr>
        <th style="text-align:left;"><img style="max-width: 200px;" src="https://www.bidinline.com/images/logo.png" alt="Bidinline"></th>
        <th style="text-align:right;font-weight:400;"><?php echo date('F j, Y'); ?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="height:35px;"></td>
      </tr>
      <tr>
        <td colspan="2" style="border: solid 1px #ddd; padding:10px 20px;">
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:150px">Payment Status</span><b style="color:green;font-weight:normal;margin:0">Success</b></p>
          <p style="font-size:14px;margin:0 0 6px 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Operation: </span> <?= $order_id; ?> </p>
          <p style="font-size:14px;margin:0 0 0 0;"><span style="font-weight:bold;display:inline-block;min-width:146px">Paid amount</span> € <?= number_format($amount,2); ?></p>
        </td>
      </tr>
      <tr>
        <td style="height:35px;"></td>
      </tr>
  
      <tr>
        <td colspan="2" style="font-size:20px;padding:30px 15px 0 15px;">Order Details</td>
      </tr>
      <tr>
        <td colspan="2" style="padding:15px;">
           
            <tr>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;">
                    Order Id/Operation
                </td>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;border-left:none;">
                    <span style="display:block;font-size:13px;font-weight:normal;"><?= $order_id; ?></span>
                </td>
            </tr>

            <tr>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;border-top: none;">
                    Empresa
                </td>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;border-left:none;border-top: none;">
                    <span style="display:block;font-size:13px;font-weight:normal;"> <?php echo $company; ?></span>
                </td>
            </tr>

             <tr>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;border-top: none;">
                    Customer Name
                </td>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;border-left:none;border-top: none;">
                    <span style="display:block;font-size:13px;font-weight:normal;"> <?= $first_name; ?> <?= $last_name; ?></span>
                </td>
            </tr>

            <tr>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;border-top: none;">
                    Customer Email
                </td>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;border-left:none;border-top: none;">
                    <span style="display:block;font-size:13px;font-weight:normal;"> <?= $email; ?> </span>
                </td>
            </tr>

             <tr>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;border-top: none;">
                    Paid Amount
                </td>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;border-left:none;border-top: none;">
                    <span style="display:block;font-size:13px;font-weight:normal;">€ <?= number_format($amount,2); ?> </span>  
                </td>
            </tr>


            <tr>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;border-top: none;">
                    Trasaction Date & Time
                </td>
                <td style="font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;border-left:none;border-top: none;">
                    <span style="display:block;font-size:13px;font-weight:normal;"> <?php echo date("d-m-Y H:i:s") ?> </span>  
                </td>
            </tr>
        </td>
    </tr>

    </tbody>
    <tfooter>
      <tr>
        <td colspan="2" style="font-size:14px;padding:50px 15px 0 15px;">
          <center>This is an automated email by system, please do not reply to this email.</center>
        </td>
      </tr>
    </tfooter>
  </table>
</body>

</html>