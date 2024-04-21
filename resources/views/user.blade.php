<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <style>
        .container {
            display: grid;
            grid-template-rows: 100%;
            grid-template-columns: 1fr 1fr 1fr;
            margin: auto;
            background: #f4f4f4;
            padding: 5%;
        }

        .column1 {
    background: #b40404;
    grid-auto-columns: 1/1;
    padding: 5%;
    color: #fff;
    margin-bottom: 20px; 
    border-radius:28px;
}
.container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Adjust column width as needed */
    grid-gap: 20px; /* Add gap between grid items */
}


        /* Style the form */
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="number"],
        .form-container textarea {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .submit-button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
}

.submit-button:hover {
    background-color: #45a049;
}

                /* Style the select box */
                .form-container select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            background-color: #fff;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M7 10l5 5 5-5H7z" fill="#000000"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 20px;
            cursor: pointer;
        }

        .form-container select::-ms-expand {
            display: none;
        }
        #search {
    width: 300px;
    padding: 10px;
    border: 2px solid #ccc;
    border-radius: 5px;
    outline: none;
    font-size: 16px;
}

#search::placeholder {
    color: #999;
}

    </style>
</head>
<body>
    <!-- Form -->
    <div class="form-container">
        
        <form id="userForm"  method="POST">
            @csrf
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Your name.." required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your email.." required>

            <label for="phone">Phone:</label>
            <input type="number" id="phone" name="phone_number" placeholder="Your phone.." required>

            <label for="department">Department:</label>
            <select id="department_id" name="department_id">
               <option value=""> Select </option>
               @foreach($departments as $department)
                <option value="{{$department->id}}"> {{$department->name}} </option>
                @endforeach
            </select>

            <label for="designation">Designation:</label>
            <select id="designation_id" name="designation_id">
                <option value=""> Select </option>
                @foreach($designations as $designation)
                <option value="{{$designation->id}}"> {{$designation->name}} </option>
                @endforeach
            </select>
            
            <button type="button" class="submit-button" onclick="submitForm()">Submit</button>
        </form>
        
    </div>
    <input type="text" id="search" placeholder="Search ...">
    <div class="container">
        @foreach($users as $user)
        <div class="column1">
            Name : {{$user->name}}  <br>
            Email : {{$user->email}}  <br>
            Phone : {{$user->phone_number}}  <br>
            Designation : {{$user->Designation->name}}  <br>
            Department : {{$user->Department->name}}  <br>
        </div>
        @endforeach
      
    </div>

    
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
                function submitForm() {
            var name = $("#name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var department_id = $("#department_id").val();
            var designation_id = $("#designation_id").val();

           $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
               });
            
            $.ajax({
            type: "POST",
            url: "{{ url('user/store')}}",
            data: {         
                name :name,         
                email:email,
                phone:phone,
                department_id:department_id,
                designation_id:designation_id
            },
            cache: false,
            success: function (response) {
                    $(".preloader").hide();
                    if (response.status == 1) {
                        Swal.fire("Success!", response.message, "success").then(() => {
                           
                            location.reload();
                            
                        });
                    } else {
                        Swal.fire("Failed!", response.message, "error");
                        if (response.hasOwnProperty('error_list')) {
                            for (x in response.error_list) {
                                $('#error_' + x).html(response.error_list[x])
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $(".preloader").hide();
                    console.log(xhr.responseText); 
                }
            });
            }
</script>
<script>
    $(document).ready(function() {
        $("#search").on("keyup", function() {
            var searchText = $(this).val().toLowerCase();

            $(".column1").each(function() {
                var userText = $(this).text().toLowerCase();

                if (userText.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
</html>
