<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Page v5</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('vendors/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('vendors/dist/css/adminlte.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('vendors/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{ asset('css/intlTelInput.css') }}">
<style>
  .iti {
  width: 100%;
  display: block;
}
</style>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a><b>@lang('form.title')</b></a>
  </div>
  <!-- main content -->
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- jquery validation -->
        
        <form id="signupform" action="{{ route('signup', ['lang'=>$lang, 'id'=>$id]) }}" method="POST">

          @csrf
          <div>
            <div class="form-group">
                <label for="firstName">@lang('form.firstName')</label>
                  <input type="text" name="firstName" class="form-control" id="firstName" placeholder="First Name">
            </div>

            <div class="form-group">
              <label for="lastName">@lang('form.lastName')</label>
                <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Last Name">
            </div>

            <div class="form-group">
              <label for="country">@lang('form.country')</label>
                <select id="country" name="country" class="form-control" placeholder="Country">
                 
                </select>
            </div>

            <div class="form-group">
              <label for="phone">@lang('form.phone')</label><br>
                <input type="tel" name="phone" class="form-control" id="phone">
            </div>

            <div class="form-group">
              <label for="email">@lang('form.email')</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email">
            </div>

            <div class="form-group">
              <label for="password">@lang('form.password')</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="crm">
            <label class="form-check-label" for="crm">Create a new contact in HubSpot</label>
          </div> 
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="db">
            <label class="form-check-label" for="db">Link to Database</label>
          </div>     
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="slack">
            <label class="form-check-label" for="slack">Notify in Slack Channel</label>
          </div> 
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="mail">
            <label class="form-check-label" for="mail">Send an Email</label>
          </div>  
           
               
          <div class="dropdown-divider"></div>
          <div > 
            <button type="submit" class="btn btn-primary">@lang('form.button')</button>
          </div>
        </form>
        
      </div> 
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->


<!-- jQuery -->
<script src="{{ asset('vendors/plugins/jquery/jquery.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('vendors/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendors/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendors/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendors/dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('js/intlTelInput.js') }}"></script>

<script>


// get the country data from the plugin
var countryData = window.intlTelInputGlobals.getCountryData(),
  input = document.querySelector('#phone'),
  select = document.querySelector('#country');

var iti = window.intlTelInput(input, {
  hiddenInput: "full_phone",
  initialCountry: "auto",
  preferredCountries: ["my", "sg"],
  geoIpLookup: function(callback) {
    $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
      var countryCode = (resp && resp.country) ? resp.country : "us";
      callback(countryCode);
    });
  },
  utilsScript: "{{ asset('js/utils.js') }}" // just for formatting/placeholders
});

// populate the country dropdown list
for (var i = 0; i < countryData.length; i++) {
  var country = countryData[i];
  var optionNode = document.createElement("option");
  optionNode.value = country.iso2;
  var textNode = document.createTextNode(country.name);
  optionNode.appendChild(textNode);
  select.appendChild(optionNode);
}
// set initial value
select.value = iti.getSelectedCountryData().iso2;
// set full phone number

// listen to telephone input for changes
input.addEventListener('countrychange', function(e) {
  select.value = iti.getSelectedCountryData().iso2;
});

</script>
<script>
$(function () {
  // $.validator.setDefaults({
  //   submitHandler: function () {
  //     alert( "Form successful submitted!" );
  //   }
  // });
  
  $('#signupform').validate({
    rules: {
      email: {
        required: true,
        email: true,
        maxlength: 254
      },
      password: {
        required: true,
        minlength: 8,
        pattern: "^(?=.*[A-Z])(?=.*[a-z])(?=.*\\d)(?=.*[~!@#\\$%\\^&\\*\\(\\)_\\+\\{\\}\":\\?\\>\\<\\[\\];'\\/\\.\\\\-]).{8,}$"
      },
      firstName: {
        required: true,
        maxlength: 128,
        pattern: "^[\\w\\s]+$"
      },
      lastName: {
        required: true,
        maxlength: 128,
        pattern: "^[\\w\\s]+$"
      },
      country: {
        required: true
      },
      phone: {
        required: true,
        maxlength: 254
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a valid email address",
        maxlength: "Email is too long"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 8 characters long",
        pattern: "Password must have minimum eight characters, at least one uppercase letter and lowercase letter, one number and one special character."
      },
      firstName: {
        required: "Please enter a first name",
        maxlength: "Name is too long",
        pattern: "Please enter a valid name",
      },
      lastName: {
        required: "Please enter a last name",
        maxlength: "Name is too long",
        pattern: "Please enter a valid name",
      },
      country: "Please select a country",
      phone: "Please enter a valid phone number"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
<script>
    var msg = '{{Session::get('alert')}}';
    var exist = '{{Session::has('alert')}}';
    if(exist){
      alert(msg);
    }
</script>
</body>
</html>
