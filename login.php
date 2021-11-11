
<!DOCTYPE html>
<html>
	<head>
		<?php include('header.php') ?>
        <?php 
        session_start();
        if(isset($_SESSION['login_id'])){
            header('Location:home.php');
        }
        ?>
		<title>Online MCQ Quiz</title>
	</head>

	<body id='login-body' class="bg-light">

        <div class="card col-md-6 offset-md-3 text-center bg-primary mb-4">
            <h3 class="he3-responsive text-white">Online MCQ Quiz</h3>
        </div>
		<div class="card col-md-4 offset-md-4 mt-4">
            <div class="card-header-edge text-white">
                <strong>Login</strong>
            </div>
            <div class="card-body">
                     <form id="login-frm">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="username" name="username" placeholder="Username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Password" class="form-control">
                        </div> 
                        <div class="form-group text-right">
                            <button class="btn btn-primary btn-block" name="submit">Login</button>
                        </div>
                    </form>

                    <button class="btn btn-success bt-sm" id="new_faculty"><i class="fa fa-plus"></i>  Register Faculty</button>
                    <button class="btn btn-success float-right bt-sm" id="new_student"><i class="fa fa-plus"></i>   Register Student</button>
              </div>
        </div>

        <div class="modal fade" id="manage_faculty" tabindex="-1" role="dialog" >
                <div class="modal-dialog modal-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            
                            <h4 class="modal-title" id="myModallabel">Add New Faculty</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form id='faculty-frm'>
                            <div class ="modal-body">
                                <div id="msg"></div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="hidden" name="id" />
                                    <input type="hidden" name="uid" />
                                    <input type="hidden" name="user_type" value = '2' />
                                    <input type="text" name="name" required="required" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" name ="subject" required="" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name ="username" required="" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <div class="modal fade" id="manage_student" tabindex="-1" role="dialog" >
                <div class="modal-dialog modal-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            
                            <h4 class="modal-title" id="myModallabel">Add New student</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form id='student-frm'>
                            <div class ="modal-body">
                                <div id="msg"></div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="hidden" name="id" />
                                    <input type="hidden" name="uid" />
                                    <input type="hidden" name="user_type" value = '3' />
                                    <input type="text" name="name" required="required" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Level-Section</label>
                                    <input type="text" name ="level_section" required="" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name ="username" required="" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" required="required" class="form-control" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button  class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

		</body>

<script>
        $(document).ready(function(){
            $('#login-frm').submit(function(e){
                e.preventDefault()
                $('#login-frm button').attr('disable',true)
                $('#login-frm button').html('Please wait...')

                $.ajax({
                    url:'./login_auth.php',
                    method:'POST',
                    data:$(this).serialize(),
                    success:function(resp){
                        if(resp == 1){
                            location.replace('home.php')
                        }else{
                            alert("Incorrect username or password.")
                            $('#login-frm button').removeAttr('disable')
                            $('#login-frm button').html('Login')
                        }
                    },
                    error:err=>{
                        console.log(err)
                        alert('An error occured');
                        $('#login-frm button').removeAttr('disable')
                        $('#login-frm button').html('Login')
                    }

                })

            })
        })
</script>
<script>
        $(document).ready(function(){
            $('#table').DataTable();
            $('#new_faculty').click(function(){
                $('#msg').html('')
                $('#manage_faculty .modal-title').html('Add New Faculty')
                $('#manage_faculty #faculty-frm').get(0).reset()
                $('#manage_faculty').modal('show')
            })
            $('.edit_faculty').click(function(){
                var id = $(this).attr('data-id')
                $.ajax({
                    url:'./get_faculty.php?id='+id,
                    error:err=>console.log(err),
                    success:function(resp){
                        if(typeof resp != undefined){
                            resp = JSON.parse(resp)
                            $('[name="id"]').val(resp.id)
                            $('[name="uid"]').val(resp.uid)
                            $('[name="name"]').val(resp.name)
                            $('[name="subject"]').val(resp.subject)
                            $('[name="username"]').val(resp.username)
                            $('[name="password"]').val(resp.password)
                            $('#manage_faculty .modal-title').html('Edit Faculty')
                            $('#manage_faculty').modal('show')

                        }
                    }
                })

            })
            $('.remove_faculty').click(function(){
                var id = $(this).attr('data-id')
                var conf = confirm('Are you sure to delete this data.');
                if(conf == true){
                    $.ajax({
                    url:'./delete_faculty.php?id='+id,
                    error:err=>console.log(err),
                    success:function(resp){
                        if(resp == true)
                            location.reload()
                    }
                })
                }
            })
            $('#faculty-frm').submit(function(e){
                e.preventDefault();
                $('#faculty-frm [name="submit"]').attr('disabled',true)
                $('#faculty-frm [name="submit"]').html('Saving...')
                $('#msg').html('')

                $.ajax({
                    url:'./save_faculty.php',
                    method:'POST',
                    data:$(this).serialize(),
                    error:err=>{
                        console.log(err)
                        alert('An error occured')
                        $('#faculty-frm [name="submit"]').removeAttr('disabled')
                        $('#faculty-frm [name="submit"]').html('Save')
                    },
                    success:function(resp){
                        if(typeof resp != undefined){
                            resp = JSON.parse(resp)
                            if(resp.status == 1){
                                alert('Data successfully saved');
                                location.reload()
                            }else{
                            $('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')

                            }
                        }
                    }
                })
            })
        })
</script>
<script>
    $(document).ready(function(){
        $('#table').DataTable();
        $('#new_student').click(function(){
            $('#msg').html('')
            $('#manage_student .modal-title').html('Add New student')
            $('#manage_student #student-frm').get(0).reset()
            $('#manage_student').modal('show')
        })
        $('.edit_student').click(function(){
            var id = $(this).attr('data-id')
            $.ajax({
                url:'./get_student.php?id='+id,
                error:err=>console.log(err),
                success:function(resp){
                    if(typeof resp != undefined){
                        resp = JSON.parse(resp)
                        $('[name="id"]').val(resp.id)
                        $('[name="uid"]').val(resp.uid)
                        $('[name="name"]').val(resp.name)
                        $('[name="level_section"]').val(resp.level_section)
                        $('[name="username"]').val(resp.username)
                        $('[name="password"]').val(resp.password)
                        $('#manage_student .modal-title').html('Edit Student')
                        $('#manage_student').modal('show')

                    }
                }
            })

        })
        $('.remove_student').click(function(){
            var id = $(this).attr('data-id')
            var conf = confirm('Are you sure to delete this data.');
            if(conf == true){
                $.ajax({
                url:'./delete_student.php?id='+id,
                error:err=>console.log(err),
                success:function(resp){
                    if(resp == true)
                        location.reload()
                }
            })
            }
        })
        $('#student-frm').submit(function(e){
            e.preventDefault();
            $('#student-frm [name="submit"]').attr('disabled',true)
            $('#student-frm [name="submit"]').html('Saving...')
            $('#msg').html('')

            $.ajax({
                url:'./save_student.php',
                method:'POST',
                data:$(this).serialize(),
                error:err=>{
                    console.log(err)
                    alert('An error occured')
                    $('#student-frm [name="submit"]').removeAttr('disabled')
                    $('#student-frm [name="submit"]').html('Save')
                },
                success:function(resp){
                    if(typeof resp != undefined){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            alert('Data successfully saved');
                            location.reload()
                        }else{
                        $('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')

                        }
                    }
                }
            })
        })
    })
</script>
</html>