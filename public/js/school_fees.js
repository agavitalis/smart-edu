$(document).ready(function() {
  
    const API_publicKey = "FLWPUBK_TEST-6ed373149166c784cf560090702de235-X";

    function payWithRave(session,level,term,username,email,phone,amount) {
        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: email,
            amount: amount,
            customer_phone: phone,
            currency: "NGN",
            txref: session + "-" + term + "-" + username,
            meta: [
                {
                    metaname: "Session",
                    metavalue: session
                },
                {
                    metaname: "Term",
                    metavalue: term
                },
                {
                    metaname: "Username",
                    metavalue: username
                }
            ],
            onclose: function() {},
            callback: function(response) {
                let txref = response.data.data.txRef; 
                let amount_paid = response.data.data.amount;
                if (
                    response.data.data.chargeResponseCode == "00" ||
                    response.data.data.chargeResponseCode == "0"
                ) {
                    //Log this student 
                   
                    $.ajax({
                        type: "post",
                        url: "/student/complete_school_fees_payment",
                        data: {
                            _token: $("input[name=_token]").val(),
                            session: session,
                            term: term,
                            level: level,
                            username: username,
                            email: email,
                            phone: phone,
                            amount_paid: amount_paid,
                            transaction_ref: txref
                        },
                        success: function(response) {
                            if (response.code == 200) {

                              window.location.reload();
                            
                            } else if (response.code == 500) {
                                console.log(response);
                            }
                        },
                        errors: function(error) {
                            console.log(error.message);
                        }
                    });
                } else {
                    //errrrorr
                    console.log("Error Box:",response.data.data)
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });
    }

    $(".pay").click(function() {

        let session = $("#session").val();
        let level = $("#level").val();
        let term = $("#term").val();
        let username = $("#username").val();
        let email = $("#email").val();
        let phone = $("#phone").val();
        let amount = $("#amount").val();

        if ( session == ""  ||  level == ""  ||   term == "" ||  username == "" ||   amount == "" || email == "" || phone == "" ){
            alert("Please complete your student profile to continue");
        }else{
            payWithRave(session,level, term, username, email, phone, amount);
        } 
        
    });
});
