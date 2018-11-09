<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Configuration of Component Range
  <small></small>
  </h1>
</section>
<!-- Main content -->
<section class="content">
  
  <div class="row">
    <div class="col-xs-12">      
      <div class="box">
        <div class="box-header">
          <form class="form-inline">
<?php if($this->USER->ID_COMPANY): ?>
              <input type=hidden id="ID_COMPANY" name="ID_COMPANY" value="<?php echo $this->USER->ID_COMPANY ?>">
			  <?php else: ?>
            <div class="form-group">
			  
              <select id="ID_COMPANY" name="ID_COMPANY" class="form-control select2">
                <?php  foreach($this->list_company as $company): ?>
                  <option value="<?php echo $company->ID_COMPANY;?>" <?php echo ($this->ID_COMPANY == $company->ID_COMPANY)?"SELECTED":"";?> ><?php echo $company->NM_COMPANY;?></option>
                <?php endforeach; ?>
              </select>
              
            </div>
<?php endif; ?>
<?php if($this->USER->ID_PLANT): ?>
              <input type=hidden id="ID_PLANT" name="ID_PLANT" value="<?php echo $this->USER->ID_PLANT ?>">
			  <?php else: ?>
            <div class="form-group">
              <select id="ID_PLANT" name="ID_PLANT" class="form-control select2">
                <option value="">Please wait...</option>
              </select>
            </div>
            
<?php endif; ?>
			<div class="form-group">
              <select id="DISPLAY" name="DISPLAY" class="form-control select2">
                <option value="D">DAILY</option>
                <option value="H">HOURLY</option>
              </select>
            </div>
          </form>
          <hr/>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table  id="dt_tables"
            class="table table-striped table-bordered table-hover dt-responsive nowrap"
            cellspacing="0"
            width="100%">
            <thead>
              <tr>
                <th width="5%">ID_GROUPAREA</th>
                <th width="5%">No.</th>
                <th width="20%">COMPANY</th>
                <th width="20%">PLANT</th>
                <th width="30%">GROUP AREA</th>
                <th width="20%"></th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->

<!-- msg confirm -->
<?php if($notice->error): ?>
  <a  id="a-notice-error"
    class="notice-error"
    style="display:none";
    href="#"
    data-title="Something Error"
    data-text="<?php echo $notice->error; ?>"
  ></a>

<?php endif; ?>

<?php if($notice->success): ?>
    <a  id="a-notice-success"
    class="notice-success"
    style="display:none";
    href="#"
    data-title="Done!"
    data-text="<?php echo $notice->success; ?>"
  >asdasd</a>            
<?php endif; ?>
<!-- eof msg confirm -->

<!-- DataTables css -->
<link href="<?php echo base_url("plugins/datatables/datatables.net-bs/css/dataTables.bootstrap.min.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/datatables/datatables.net-buttons-bs/css/buttons.bootstrap.min.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/datatables/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/datatables/datatables.net-responsive-bs/css/responsive.bootstrap.min.css");?>" rel="stylesheet">
<link href="<?php echo base_url("plugins/datatables/datatables.net-scroller-bs/css/scroller.bootstrap.min.css");?>" rel="stylesheet">
<!-- DataTables js -->
<script src="<?php echo base_url("plugins/datatables/datatables.net/js/jquery.dataTables.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-bs/js/dataTables.bootstrap.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-buttons/js/dataTables.buttons.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-buttons-bs/js/buttons.bootstrap.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-buttons/js/buttons.h5.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-buttons/js/buttons.print.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-keytable/js/dataTables.keyTable.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-responsive/js/dataTables.responsive.min.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-responsive-bs/js/responsive.bootstrap.js");?>"/></script>
<script src="<?php echo base_url("plugins/datatables/datatables.net-scroller/js/dataTables.scroller.min.js");?>"/></script>

<script src="<?php echo base_url("js/jquery.confirm.js"); ?>" ></script>
<script>
  $(document).ready(function(){
    /** DataTables Init **/
    var table = $("#dt_tables").DataTable({
      language: {
        searchPlaceholder: ""
      },
      "paging": true,
      "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
      "dom":  "<'row'<'col-sm-8 text-left'B><'col-sm-4 text-right'f>>" +
              "<'row'<'col-sm-12'rt>>" +
              "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      "buttons": [
        {
          extend: "pageLength",
          className: "btn-sm bt-separ"
        },
        {
          text: "<i class='fa fa-refresh'></i> Reload",
          className: "btn-sm",
          action: function(){ 
            $("#ID_COMPANY")[0].selectedIndex = 0;
            $("#ID_COMPANY").change();
          }
        }
      ],
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": {
        "url" : '<?php echo site_url("config_component_range/get_join_grouparea");?>',
        "type": 'post',
        "data": function(data){
          data.company = $("#ID_COMPANY").val();
          data.plant = $("#ID_PLANT").val();
          data.display = $("#DISPLAY").val();
        }
      },
      "columnDefs": [{
        "targets": 0,
        "visible": false,
        "searchable": false
      },{
        "targets": -1,
        "data": null,
        "defaultContent": 
          '<button title="Assignment" class="btAssign btn btn-success btn-xs" type="button"><i class="fa fa-edit"></i> Configuration</button>'
      }]
    })

    /** DataTable Ajax Reload **/
    function dtReload(table,time) {
      var time = (isNaN(time)) ? 100:time;
      setTimeout(function(){ table.ajax.reload(); }, time);
    }

    //DataTable search on enter
    $('#dt_tables_filter input').unbind();
    $('#dt_tables_filter input').bind('keyup', function(e) {
      var val = this.value;
      var len = val.length;
      if(len==0) table.search('').draw();
      if(e.keyCode == 13) {
        table.search(this.value).draw();  
      }
    });

    /** Company change **/
    $("#ID_COMPANY").change(function(){
      var company = $(this).val(), plant = $('#ID_PLANT');
      $.getJSON('<?php echo site_url("product_assignment/ajax_get_plant/");?>' + company, function (result) {
        var values = result;
        
        plant.find('option').remove();
        if (values != undefined && values.length > 0) {
          plant.css("display","");
          $(values).each(function(index, element) {
            plant.append($("<option></option>").attr("value", element.ID_PLANT).text(element.NM_PLANT));
          });
        }else{
          plant.css("display","none");
        }
        $("#ID_PLANT").change();
      });
    });

    /** Plant change **/
    $("#ID_PLANT").change(function(){
      $('#dt_tables').DataTable().ajax.reload();
    });

    /** Exec Company change **/
    $("#ID_COMPANY").change();
    
    $("#DISPLAY").change(function(){$("#ID_PLANT").change();});

    /** btAssign Click **/
    $(document).on('click',".btAssign",function () {
      var url = '<?php echo site_url("config_component_range/edit");?>';
      var data = table.row($(this).parents('tr')).data();
      var id_plant = $("#ID_PLANT").val();
      var id_grouparea = data[0];
      goPost(url, {"plant":id_plant, "grouparea": id_grouparea, "display": $("#DISPLAY").val()});
    });

  $(".notice-error").confirm({ 
    confirm: function(button) { /* Nothing */ },
    confirmButton: "OK",
    cancelButton: "Cancel",
    confirmButtonClass: "btn-danger"
  });
  
  $(".notice-success").confirm({ 
    confirm: function(button) { /* Nothing */ },
    confirmButton: "OK",
    cancelButton: "Cancel",
    confirmButtonClass: "btn-success"
  });

  <?php if($notice->error): ?>
  $("#a-notice-error").click();
  <?php endif; ?>
  
  <?php if($notice->success): ?>
  $("#a-notice-success").click();
  <?php endif; ?>

  });
</script>
