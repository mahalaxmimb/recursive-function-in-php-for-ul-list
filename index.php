<?php
require('config.php');
?>

<!Doctype html>
<html>

<head>
    <title>My Task</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php
    membertree(0);
    ?>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formmodal">
        Add Member
    </button>

    <div class="modal fade" id="formmodal" tabindex="-1" role="dialog" aria-labelledby="formmodalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="memberform">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="parentid">Parent</label>
                            <select class="form-control" id="parentid" name="parentid">
                                <?php
                                $query = "SELECT * FROM members";
                                $statement = $conn->prepare($query);
                                $statement->execute();

                                $statement->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
                                $result = $statement->fetchAll();
                                if($result)
                                {
                                foreach ($result as $row) {
                                ?>
                                    <option value="<?= $row->Id; ?>" name="<?= $row->Id; ?>"><?= $row->Name; ?></option>

                                <?php
                                }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                            <div class="error text-danger"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="button" value="Save Changes" class="btn btn-primary" id="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#submit').prop('disabled', true);
            $('#name').on('keyup', function() {
                let regex = /^[a-zA-Z0-9 ]*$/;
                let name = $("#name").val();
                if (name === '') {
                    $('.error').html('Name should not be empty');
                    $('#submit').prop('disabled', true);
                } else if (!regex.test(name)) {
                    $('.error').html('Name must contain only letters');
                    $('#submit').prop('disabled', true);
                } else {
                    $('.error').html('');
                    $('#submit').prop('disabled', false);
                }
            })
            $('#submit').on('click', function() {
                let name = $("#name").val();
                let parentid = $("#parentid").val();
                $.ajax({
                    url: "insert.php",
                    type: "POST",
                    data: $('#memberform').serialize(),
                    success: function(res) {
                        let li = document.createElement("li");
                        let text = document.createTextNode(name);
                        li.appendChild(text)
                        $('#'+parentid+'').append(li)
                        $('#formmodal').modal('toggle');
                        $('#name').val('');
                        $('#parentid').prop('selectedIndex',0);
                    },
                    error: function() {
                        alert('error')
                    }
                });
            });
        })
    </script>

</body>

</html>

<?php

$conn = null;

?>