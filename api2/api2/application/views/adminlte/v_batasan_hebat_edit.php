<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Master Data Batasan
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      
      <?php if($notice->error): ?>
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        <?php echo $notice->error; ?>
      </div>
      <?php endif; ?>
      
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add Data Batasan</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="<?php echo site_url("batasan_hebat/update") ?>" >
          <div class="box-body" style="background-color:#FFFAAE;">
            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>ASPEK</label><br>
                <select class="form-control" id="ID_ASPEK" name="ID_ASPEK">
                  <?php 
                    foreach ($this->ASPEK as $aspek) {
                      $sl = ($aspek->ID_ASPEK == $this->ID_ASPEK) ? "selected":"";
                      echo "<option $sl value='".$aspek->ID_ASPEK."'>".$aspek->ASPEK."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>KRITERIA </label><br>
                <select class="form-control" id="ID_KRITERIA" name="ID_KRITERIA"></select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>BOBOT </label>
                <div id="BOBOT"></div>
                <br>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-4 clearfix">
                <label>BATASAN </label><br>
                <input type="hidden" name="ID_BATASAN" value="<?php echo $this->LIST->ID_BATASAN;?>">
                <textarea class="form-control" rows="5" id="BATASAN" name="BATASAN" required><?php echo $this->LIST->BATASAN;?></textarea>
              </div>
            </div>
            
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="<?php echo site_url("batasan_hebat");?>"> <button type="button" class="btn btn-danger">Cancel</button></a>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->

<script>
$(document).ready(function(){
  $("#ID_ASPEK").change();
});


$("#ID_ASPEK").change(function(){
  var id_aspek = $(this).val(), kriteria = $("#ID_KRITERIA");

  $.getJSON('<?php echo site_url("batasan_hebat/ajax_get_kriteria/");?>' + id_aspek, function (result) {
    var values = result;
    
    if (values != undefined && values.length > 0) {
      kriteria.find('option').remove();
      $(values).each(function(index, element) {
        kriteria.append($("<option></option>").attr("value", element.ID_KRITERIA).text(element.KRITERIA));
      });

    }else{
      kriteria.find('option').remove();
      kriteria.append($("<option></option>").attr("value", '00').text("NO KRITERIA"));
    }
    $("#ID_KRITERIA").change();
  });
});

$("#ID_KRITERIA").change(function(){
  var id_kriteria = $(this).val(), bobot = $('#BOBOT');

  $.getJSON('<?php echo site_url("batasan_hebat/ajax_get_kriteria_by_id/");?>' + id_kriteria, function (result) {
    bobot.text(result.BOBOT);
  });
});

</script>