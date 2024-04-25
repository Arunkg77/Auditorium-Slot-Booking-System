<?php require_once('db-connect.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
    <style>
    

html, body {
    height: 100%;
    width: 100%;
    font-family: 'Apple Chancery', cursive;
    margin: 0;
    padding: 0;
    overflow: hidden; /* To prevent scrollbars */
}

body {
    background-image: url('gmuu1.jpg');
}

@keyframes gradientAnimation {
    0% {
        background-position: 0% 50%;
    }
    100% {
        background-position: 100% 50%;
    }
}


table,
        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: #000 !important; /* Black border */
            border-style: solid;
            border-width: 1px !important;
            color: #000 !important; /* Black text */
            background-color: #ffd700; /* Gold background */
        }

    </style>
</head>

<body class="bg-light">
    <div class="container py-5" id="page-container">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <div class="cardt rounded-0 shadow">
                    <div class="card-header bg-gradient bg-primary text-light">
                        <h5 class="card-title"> Event Time Slot Booking Form
</h5>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form action="save.php" method="post" id="schedule-form">
                                <input type="hidden" name="id" value="">
                                <div class="form-group mb-2">
                                    <label for="title" class="control-label">Title:</label>
                                    <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="description" class="control-label">Description:</label>
                                    <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="start_datetime" class="control-label">Start:</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="end_datetime" class="control-label">End:</label>
                                    <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                            <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
              <style> 
             .cardt,
        .card-header,
        .btn-primary,
        .btn-default {
            background-color: #000 !important; /* Black background */
            color: #ffd700 !important; /* Gold text */
            border-color: #ffd700 !important; /* Gold border */
        }

        .btn-primary:hover,
        .btn-default:hover {
            background-color: #ffd700 !important; /* Gold background on hover */
            color: #000 !important; /* Black text on hover */
            border-color: #000 !important; /* Black border on hover */
        }

        .modal-header,
        .modal-content {
            background-color: #ffd700 !important; /* Gold background for modal */
            color: #000 !important; /* Black text for modal */
            border-color: #000 !important; /* Black border for modal */
        }

        .modal-header button {
            color: #000 !important; /* Black close button on modal */
        }

        dl {
            border: 2px solid #000;
            padding: 20px;
            border-radius: 10px;
        }

        dt,
        dd {
            margin: 10px 0;
            transition: transform 0.3s ease-in-out;
            color: black; /* Gold text */
        }

        dt {
            font-size: 1.2em;
            font-weight: bold;
        }

        dd {
            font-size: 1.1em;
        }

        dl:hover dt,
        dl:hover dd {
            transform: scale(1.1);
        }



    </style>
</head>
<body>
    <dl>
        <dt class="text-muted">Title:</dt>
        <dd id="title" class="fw-bold fs-4"> Title</dd>
        <dt class="text-muted">Description:</dt>
        <dd id="description" class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</dd>
        <dt class="text-muted">Start:</dt>
        <dd id="start" class="">2024-02-21</dd>
        <dt class="text-muted">End:</dt>
        <dd id="end" class="">2024-02-22</dd>
    </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->

<?php 
$schedules = $conn->query("SELECT * FROM `schedule_list`");
$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    $row['sdate'] = date("F d, Y h:i A",strtotime($row['start_datetime']));
    $row['edate'] = date("F d, Y h:i A",strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
}
?>
<?php 
if(isset($conn)) $conn->close();
?>
</body>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="./js/script.js"></script>

</html>

