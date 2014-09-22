<?php include('./includes/form-handler.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Coming soon</title>
    <link rel="apple-touch-icon" sizes="57x57" href="./images/icons/apple-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="./images/icons/apple-72x72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="./images/icons/apple-114x114.png" />
    <link rel="stylesheet" media="screen" href="./css/styles.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="./js/forms.js"></script>
  </head>
  <body>
  	<div id="wrapper">
<h1>Sara Beigle</h1>

<p class="lp-top">Thanks for stopping by!</p>

<p>My website is currently under construction but if you'd like to contact me please complete and submit the form below to send me an email.</p>
  
      <?php if (!empty($thanks)) { ?>
      	<p class="thank-you-copy"><?php echo $thanks; ?></p>
      <?php } else { ?>
        <div id="contact">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div id="field-name-row" class="row overlay">
<label class="overlay-label<?php echo $e_class['name']; ?>" for="field-name">Name<span class="req">*</span></label>
<input id="field-name" class="field text-field has-overlay show-overlay<?php echo $e_class['name']; ?>" type="text" name="name" value="<?php echo $values['name']; ?>" required>
            </div>
            <!-- /#field-name-row /.row -->
            
            <div id="field-email-row" class="row overlay">
<label class="overlay-label<?php echo $e_class['email']; ?>" for="field-email">Email Address<span class="req">*</span></label>
<input id="field-email" class="field text-field has-overlay show-overlay email-field<?php echo $e_class['email']; ?>" type="email" name="email" value="<?php echo $values['email']; ?>" required>
            </div>
            <!-- /#field-email-row /.row -->
            
            <div id="field-phone-row" class="row overlay">
<label class="overlay-label" for="field-phone">Phone Number</label>
<input id="field-phone" class="field text-field has-overlay show-overlay" type="text" name="phone" value="<?php echo $values['phone']; ?>">
            </div>
            <!-- /#field-phone-row /.row -->
            
            <div id="field-method-row" class="row select-row">
<label class="select-label" for="field-method">Preferred Contact Method</label>
<select id="field-method" name="method" class="field select-field">
  <option value="email">Email me.</option>
  <option value="phone">Call me.</option>
</select>
            </div>
            <!-- /#field-method-row /.row -->
            
            <div id="field-message-row" class="row overlay textarea-row">
<label class="textarea-label overlay-label<?php echo $e_class['message']; ?>" for="field-message">Message</label>
<textarea id="field-message" class="field textarea-field has-overlay show-overlay<?php echo $e_class['message']; ?>" name="message" required><?php echo $values['message']; ?></textarea>
            </div>
            <!-- /#field-phone-row /.row -->
            
            <div id="submit-wrapper">
              <noscript><input id="form-submit-no-js" class="form-submit" type="submit" value="SEND"></noscript>
            </div>
          </form>
        </div>
        <!-- /#contact -->
      <?php } ?>
    </div>
    <!-- /#wrapper -->
  </body>
</html>
