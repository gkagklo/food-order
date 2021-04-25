<!-- Footer section starts-->
<div class="footer">
            <div class="wrapper">
                <p class="text-center">2021 All rights reserved. Developed By - <a href="#">Gkagklo</a></p>
            </div>  
        </div>
        <!-- Footer section ends-->

        <!-- SweetAlert 2 -->
        <script>
            $('.delete').on('click', function(e){
                e.preventDefault();
                const href = $(this).attr('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) =>{
                    if (result.value){
                        document.location.href = href;
                    }
                })
            })
        </script>

    </body>
</html>