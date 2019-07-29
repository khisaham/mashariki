<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title><?php echo $title; ?></title>
    <base href="http://localhost/upload/admin/" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="http://localhost/upload/vendor/jquery/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="http://localhost/upload/vendor/bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://localhost/upload/vendor/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
  </head>
  <body>

    <div class="container"> 
       <?php foreach($jobs as $job): ?>
      <div class="row well">
        <div class="col-xs-6">
          <h3 class="status"><?php echo $job['jobstatus']; ?></h3>
          <?php echo 'Matter Id:'.$job['matterid']; ?> <?php echo $job['jobentrydate']; ?>
        </div>
      </div>
      <div class="row well">
        <div class="col-xs-6">
          <h3><?php echo ''; ?>&nbsp;</h3>
          <?php echo "This Matter Assigned To." ?> <?php echo 'On:'.$job['jobdate']; ?><br />
          <?php if ($job['jobassignment']) { ?>
          <?php echo $job['jobassignment']; ?> <br />
          <?php } else { ?>
          <?php echo $job['jobassignment'] ?> <br />
          <?php } ?>

          <?php echo '</br><b>Law Firm & Associate</b></b></br>'. $job['lawfirm'].'</br>'. $job['associate']; ?><br />
        
         
      <!--     <?php if ($payment_city) { ?>
          <?php echo $payment_city; ?><br />
          <?php } ?>
          <?php if ($payment_postcode) { ?>
          <?php echo $payment_postcode; ?><br />
          <?php } ?>
          <?php if ($payment_country) { ?>
          <?php echo $payment_country; ?><br />
          <?php } ?>
          <?php if ($payment_zone) { ?>
          <?php echo $payment_zone; ?><br />
          <?php } ?> -->
        </div>
        <div class="col-xs-6 text-right">
          <h3><?php echo $system_company; ?></h3>
          <?php echo $system_address; ?><br />
          <?php echo $system_email; ?><br />
          <?php if ($system_telephone) { ?>
          <?php echo $system_telephone; ?><br />
          <?php } ?>
          <?php if ($system_fax) { ?>
          <?php echo $system_fax; ?><br />
          <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <h3><?php echo $text_transactions; ?></h3>
          <table class="table table-striped table-bordered">
            <tr>
              <th class="text-left" style="width:10%;"><?php echo $column_number; ?></th>
              <th class="text-left" style="width:30%;"><?php echo $column_description; ?></th>
              <th class="text-left" style="width:10%;"><?php echo $column_quantity; ?></th>
              <th class="text-right" style="width:20%;"><?php echo $column_price; ?></th>
              <th class="text-right" style="width:10%;"><?php echo $column_discount; ?></th>
              <th class="text-right" style="width:20%;"><?php echo $column_total; ?></th>
            </tr>
            <?php foreach ($items as $item) { ?>
            <tr>
              <td class="text-left"><?php echo $item['number']; ?></td>
              <td class="text-left">
                <b><?php echo $item['title']; ?></b><br />
                <?php echo $item['description']; ?>
              </td>
              <td class="text-left"><?php echo $item['quantity']; ?></td>
              <td class="text-right"><?php echo $item['price']; ?></td>
              <td class="text-right"><?php echo $item['discount']; ?></td>
              <td class="text-right"><?php echo $item['total']; ?></td>
            </tr>
            <?php } ?>
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td class="text-right" colspan="5"><b><?php echo $total['title']; ?></b></td>
              <td class="text-right"><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <h3><?php echo $text_payment; ?></h3>
          <table class="table table-striped table-bordered">
            <tr>
              <th class="text-left"></th>
              <th class="text-left"><?php echo $column_description; ?></th>
            </tr>
            <tr>
              <td class="text-left"><?php echo $payment_name; ?></td>
              <td class="text-left"><?php echo $payment_description; ?></td>
            </tr>
          </table>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
  </body>
</html>