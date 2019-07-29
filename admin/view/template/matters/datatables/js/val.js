jQuery(document).ready(function() {
             $("#login-submit").click(function() { 
                //get input field values
                var user_name      = $('input[name=lusername]').val();
                var user_password   = $('input[name=lpassword]').val(); 
                 
                 
                //simple validation at client's end
                //we simply change border color to red if empty field using .css()
                var proceed = true;
                if(user_name==""){ 
                    $('input[name=lusername]').css('border-color','red'); 
                    proceed = false;
                }
                
                if(user_password==""){ 
                    $('input[name=lpassword]').css('border-color','red'); 
                    proceed = false;
                }
                 
                 
                //everything looks good! proceed...
                if(proceed) 
                {
                    //data to be sent to server
                    post_data = {'userName':user_name, 'userPassword':user_password};
                     
                    //Ajax post data to server
                    $.post('php-includes/login-process.php', post_data, function(response){  
         
                        //load json data from server and output message     
                        if(response.type == 'error')
                        {
                            output = '<div class="alert alert-danger alert-dismissable">'+response.text+'</div>';
                        }else if (response.type == 'success'){

                             window.location.replace(response.url);       

                        }else{
                            output = response.text;
                             
                            //reset values in all input fields
                            $('#login-form input').val(''); 
                             
                        }
                         
                        $("#result").hide().html(output).slideDown();
                    }, 'json');
                     
                }
            });
             
            //reset previously set border colors and hide all message on .keyup()
            $("#login-form input").keyup(function() { 
                $("#login-form input").css('border-color',''); 
                $("#result").slideUp();
            });

            $("#register-submit").click(function() { 
                //get input field values
                var user_name      = $('input[name=username]').val();
                var user_email      = $('input[name=email]').val();
                var user_password   = $('input[name=password]').val(); 
                var user_confirmpwd = $('input[name=confirm-password]').val(); 
                 
                 
                //simple validation at client's end
                //we simply change border color to red if empty field using .css()
                var proceed = true;
                
                if(user_name==""){ 
                    $('input[name=username]').css('border-color','red'); 
                    proceed = false;
                }
                if(user_email==""){ 
                    $('input[name=email]').css('border-color','red'); 
                    proceed = false;
                }
                
                if(user_password==""){ 
                    $('input[name=password]').css('border-color','red'); 
                    proceed = false;
                }
                 if(user_confirmpwd==""){ 
                    $('input[name=confirm-password]').css('border-color','red'); 
                    proceed = false;
                }
                 
                 //check if email is valid
                function validateEmail(email) { 
                            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                            return re.test(email);
                } 
                if (!validateEmail(user_email)){
                   $('input[name=email]').css('border-color','red'); 
                    proceed = false; 

                }

                //everything looks good! proceed...
                if(proceed) 
                {
                    //data to be sent to server
                    post_data = {'userName':user_name, 'userEmail':user_email, 'userPassword':user_password, 'userConfirmpwd':user_confirmpwd};
                      output = '<div class="alert alert-danger alert-dismissable">'+response.text+'</div>';
                    //Ajax post data to server
                    $.post('php-includes/registration-process.php', post_data, function(response){  
         
                        //load json data from server and output message     
                        if(response.type == 'error')
                        {
                            output = '<div class="alert alert-danger alert-dismissable">'+response.text+'</div>';
                        }else{
                            output = response.text;
                             
                            //reset values in all input fields
                            $('#register-form input').val(''); 
                             
                        }
                         
                        $("#result").hide().html(output).slideDown();
                    }, 'json');
                     
                }
            });
             
            //reset previously set border colors and hide all message on .keyup()
            $("#register-form input").keyup(function() { 
                $("#register-form input").css('border-color',''); 
                $("#result").slideUp();
            });
             
             

           
        });