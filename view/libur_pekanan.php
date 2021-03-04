<?php

//load.php

$connect = new PDO('mysql:host=localhost;dbname=surat', 'root', '');

$data = array();

$query = "SELECT * FROM libur_pekan ORDER BY id";
    $req = $connect->prepare($query);
    $req->execute();
    $events = $req->fetchAll();
?>

<div class="row justify-content-end">
<a  href="./index.php?op=add_pekanan" class="col-sm-4  btn btn-primary btn-block btn-lg">Generate Libur Akhir Pekan</a><br>
</div><br>

<div id="pekanan">
</div>


<script>
$(document).ready(function () {
  
    var calendar = $('#pekanan').fullCalendar({
        
        editable: true,
        events: "http://localhost/surat_native/index.php?op=view_event/fetch-event.php",
        displayEventTime: false,
       
        events: [
        <?php foreach($events as $event): 
        
        
        ?>
            {
                id: '<?php echo $event['id']; ?>',
                start: '00:00', // a start time (10am in this example)
                end: '24:00', 
                title: 'Hari Libur',
                dow: '<?php echo $event['dow']; ?>',
                textColor:'white',
                color:'#a83269',
            },
        <?php endforeach; ?>
        ],
        // editable: true,
        // eventDrop: function (event) {
        //             var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        //             var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        //             var title = event.title;
        //             var id = event.id;
        //             $.ajax({
        //                 url: 'http://localhost/surat_native/index.php?op=view_event',
        //                 data: {title:title, start:start, end:end, id:id},
        //                 type: "POST",
        //                 success: function (response) {
        //                     alert("Updated Sukses");
        //                 }
        //             });
        //         },

                
        eventClick: function (event) {
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: "http://localhost/surat_native/index.php?op=view_event",
                    data: "&id=" + event.id,
                    success: function(json) {
			 $('#pekanan').fullCalendar('removeEvents', event.id);
			  alert("Delete Sukses");}
                });
            }
        }

    });
});

function displayMessage(message) {
	    $(".response").html("<div class='success'>"+message+"</div>");
    setInterval(function() { $(".success").fadeOut(); }, 1000);
}
</script>