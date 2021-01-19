function areYouSure(id)
{
    Swal.fire({
        title: 'Are you sure want to delete this video?',
        text: "There is no turning back!!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "I'm sure"
      }).then((result) => {
        if (result.isConfirmed) {
            $.post("/api/v1/delete",
            {
              id: id,
            },
            function(data,status){
                if(data.message !== "success")
                {
                    Swal.fire(
                        'Error!',
                        'Something went wrong. Make sure you have permission to delete this video.',
                        'error'
                      )
                }else{
                    Swal.fire(
                        'Video Removed',
                        'Your video has been deleted. ('+status+')',
                        'success'
                      )
                }
            });
          // delete
        }
      })
}