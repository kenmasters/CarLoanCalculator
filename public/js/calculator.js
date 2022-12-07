jQuery(document).ready(function($){

  // CREATE
  $("#btn-save").click(function (e) {
    e.preventDefault();

    // Reset error messages
    $('.error').hide();
    $('.form-control').removeClass('has-error');

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
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
            var html = `<table class="table-box">
                          <tr><th colspan="2">Loan Details Summary</th></tr>
                          <tr><td><strong>Loan Amount</strong></td><td>${data.principal}</td></tr>
                          <tr><td><strong>Term</strong></td><td>${data.termInMonth} months <br> <span class="more">${data.termInYear} years</span></td></tr>
                          <tr><td><strong>Annual Interest Rate</strong></td><td>${data.rate}%</td></tr>
                          <tr><td><strong>Interest Cost</strong></td><td>${data.interest}</td></tr>
                          <tr><td><strong>Monthly Repayment</strong></td><td>${data.monthlyRepayment}</td></tr>
                        </table>`;

            $('#result').html(html);
            $('#calculator').trigger("reset");
          },
          error: function (data) {
            var response = $.parseJSON(data.responseText);
            $(".error").html(response.message).show();
            $('.form-control').addClass('has-error');
          }
      });
  });
});
