<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  GLOBAL REPORT
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">
    
      
      <div class="box">
        <!-- /.box-header -->
        <div class="box-header">
          <form id="formData">
            <div class="form-group row">
              <div class="form-group col-sm-5 col-sm-2">
                <label for="ID_COMPANY">MONTH</label>
                <SELECT style="width:auto;" class="form-control select2" name="MONTH" id='bulan'>
                  <?php for($i=1;$i<=12;$i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo strtoupper(date("F", mktime(0, 0, 0, $i, 10))); ?></option>
                  <?php endfor; ?>
                </SELECT>
              </div>
              <div class="form-group col-sm-5 col-sm-3">
                <label for="ID_COMPANY">YEAR</label>
                <SELECT style="width:auto;" class="form-control select2" name="YEAR" id='tahun'>
                <?php for($i=2016;$i<=date("Y");$i++): ?>
                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
                </SELECT>
              </div>
            </div>
            <hr/>
            <div class="form-group row">
              <div class="form-group col-sm-6 col-sm-4">
                <button class="btn-primary" name="load" id="btLoad">Load</button>
              </div>
            </div>
            
          </form>
          <hr/>
          <div id="divTable" style="width:90%;display:none;text-align:'center';" class="text-center">
            <div id="boxPlot_div" class="boxPlot_div"></div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

<a  id="a-notice-error"
  class="notice-error"
  style="display:none";
  href="#"
  data-title="Alert"
  data-text=""
></a>
<div class="modal_load"><!-- Loading modal --></div>


<!-- css -->
<style type="text/css">
  label { margin-bottom: 0px; }
  .form-group { margin-bottom: 5px; }
  .boxPlot_div { margin:auto;margin-bottom:10px; }
  hr { margin-top: 10px; }

  /* CSS Plotly */
  .annotation {
    border: 20px solid black;
  }

  /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
  .modal_load {
      display:    none;
      position:   fixed;
      z-index:    1000;
      top:        0;
      left:       0;
      height:     100%;
      width:      100%;
      background: rgba( 255, 255, 255, .8 ) 
                  url('<?php echo base_url("images/ajax-loader-modal.gif");?>') 
                  50% 50% 
                  no-repeat;
  }

  /* When the body has the loading class, we turn
     the scrollbar off with overflow:hidden */
  body.loading {
      overflow: hidden;   
  }

  /* Anytime the body has the loading class, our
     modal element will be visible */
  body.loading .modal_load {
      display: block;
  }
</style>

<!-- Additional CSS -->
<link href="<?php echo base_url("plugins/handsontable/pikaday/pikaday.css");?>" rel="stylesheet">

<!-- Additional JS-->
<script src="<?php echo base_url("plugins/handsontable/moment/moment.js");?>"/></script>
<script src="<?php echo base_url("plugins/handsontable/pikaday/pikaday.js");?>"/></script>
<script src="<?php echo base_url("plugins/plotly/plotly-latest.min.js");?>"/></script>
<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>

<script>
  $(document).ready(function(){
    
    $("#btLoad").click(function(event){
      event.preventDefault();

      /* Animation */
      $body = $("body");
      $body.addClass("loading");
      $body.css("cursor", "progress");

      /* Initialize Vars */

      $.ajax({
          type: "POST",
          dataType: "json",
          data: {
            opt_company: $("#opt_company").val(),
            bulan: $("#bulan").val(),
            tahun: $("#tahun").val(),
          },
          url: '<?php echo base_url("js/json/global.json");?>',
          success: function(res){
            $body.removeClass("loading");
            $body.css("cursor", "default");          

            //console.log(res);
            $("#divTable").css('display','');
            
            BoxPlot = document.getElementById('boxPlot_div');
            Plotly.purge(BoxPlot);
            Plotly.plot(BoxPlot, {
              data: res.data,
              layout: res.layout
            });
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $body.removeClass("loading");
            $body.css("cursor", "default");
            $("#a-notice-error").data("text", 'Oops! Something went wrong.<br>Please check message in console');
            $("#a-notice-error").click();

            console.log("XHR: " + JSON.stringify(jqXHR));
            console.log("Status: " + textStatus);
            console.log("Error: " + errorThrown);
          }
        });
    });

    /** Notification **/
    $(".notice-error").confirm({ 
      confirm: function(button) { /* Nothing */ },
      confirmButton: "OK",
      cancelButton: "Cancel",
      confirmButtonClass: "btn-danger"
    });
  });
</script>