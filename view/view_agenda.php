
<?php
    require('load.php');

    if(isset($_POST["id"])){
        $query = "
        UPDATE agenda 
        SET title=:title, start_event=:start_event, end_event=:end_event 
        WHERE id=:id
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
        array(
        ':title'  => $_POST['title'],
        ':start_event' => htmlentities($_POST['start']),
        ':end_event' => htmlentities($_POST['end']),
        ':id'   => $_POST['id']
        )
        );
    }

    if(isset($_POST["id"])){
        $query = "
        DELETE from events WHERE id=:id
        ";
        $statement = $connect->prepare($query);
        $statement->execute(
        array(
        ':id' => $_POST['id']
        )
        );
    }
    
?>


<div id="calendar">
</div>



<script>
$(document).ready(function () {
  
    var calendar = $('#calendar').fullCalendar({
        
        editable: true,
        events: "http://localhost/surat_native/index.php?op=view_event/fetch-event.php",
        displayEventTime: false,
        events: [
        <?php foreach($events as $event): 
        
            $start = explode(" ", $event['start_event']);
            $end = explode(" ", $event['end_event']);
            if($start[1] == '00:00:00'){
                $start = $start[0];
            }else{
                $start = $event['start_event'];
            }
            if($end[1] == '00:00:00'){
                $end = $end[0];
            }else{
                $end = $event['end_event'];
            }
        ?>
            {
                id: '<?php echo $event['id']; ?>',
                title: '<?php echo $event['title']; ?>',
                start: '<?php echo $start; ?>',
                end: '<?php echo $end; ?>',
            },
        <?php endforeach; ?>
        ],
        editable: true,
        eventDrop: function (event) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: 'http://localhost/surat_native/index.php?op=view_event',
                        data: {title:title, start:start, end:end, id:id},
                        type: "POST",
                        success: function (response) {
                            alert("Updated Sukses");
                        }
                    });
                },

                
        eventClick: function (event) {
            var deleteMsg = confirm("Do you really want to delete?");
            if (deleteMsg) {
                $.ajax({
                    type: "POST",
                    url: "http://localhost/surat_native/index.php?op=view_event",
                    data: "&id=" + event.id,
                    success: function(json) {
			 $('#calendar').fullCalendar('removeEvents', event.id);
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
