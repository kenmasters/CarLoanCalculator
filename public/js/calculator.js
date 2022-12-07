jQuery(document).ready(function($){

  // CREATE
  $("#btn-save").click(function (e) {

    // Reset error messages
    $('.error').hide();
    $('.form-control').removeClass('has-error');

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
          }
      });
      e.preventDefault();
      var formData = {
          amount: $('#amount').val(),
      };
      var type = "POST";
      var ajaxurl = 'api/calculate';
      $.ajax({
          type: type,
          url: ajaxurl,
          data: formData,
          dataType: 'json',
          success: function (data) {
            console.log(data);

            // show Amortization schedule


            var html = `<table class="table-box">
            <tr><th colspan="2">Loan Details Summary</th></tr>
            <tr><td><strong>Principal</strong></td><td>${data.principal}</td></tr>
            <tr><td><strong>Term</strong></td><td>${data.termInMonth} months <br> <span class="more">${data.termInYear} years</span></td></tr>
            <tr><td><strong>Rate (Annual)</strong></td><td>${data.rate}%</td></tr>
            <tr><td><strong>Interest</strong></td><td>${data.interest}</td></tr>
            <tr><td><strong>Monthly Repayment</strong></td><td>${data.monthlyRepayment}</td></tr>
        </table>`;

              // var result = '<tr id="todo' + data.id + '"><td>' + data.principal + '</td><td>' + data.interest + '</td><td>' + data.interest + '</td>';
              jQuery('#result').html(html);
              jQuery('#calculator').trigger("reset");
          },
          error: function (data) {
            var response = $.parseJSON(data.responseText);
            $(".error").html(response.message).show();
            $('.form-control').addClass('has-error');
          }
      });
  });
});
