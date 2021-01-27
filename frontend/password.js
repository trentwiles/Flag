
function submit()
{
  var password = document.getElementById("new").value;

if(password == "")
{
    Swal.fire(
        'Error!',
        'Something went wrong. Please provide a password.',
        'error'
      )
}else{
    $.post("/api/v1/password",
    {
      password: password,
      token: token
    },
    function(data,status){
        if(data.success == "true")
        {
            Swal.fire(
                'Password Changed',
                'Your password has been changed. Care to <a href="/login/">login?</a>',
                'success'
              )
        }else{
            Swal.fire(
                'Something went wrong',
                data.message,
                'error'
              )
        }
    }
    )}
}