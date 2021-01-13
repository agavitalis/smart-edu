$(document).ready(function() {
    alert("I am alive")
    const API_publicKey = "FLWPUBK_TEST-6ed373149166c784cf560090702de235-X";

    function payWithRave(email, amount, phone,username,session, level,term,invoice_id) {
        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: email,
            amount: amount,
            customer_phone: phone,
            currency: "NGN",
            txref: "Student-" + usrrname,
            meta: [
                {
                    metaname: "Username",
                    metavalue: username
                },
                {
                    metaname: "Session",
                    metavalue: session
                },
                {
                    metaname: "Level",
                    metavalue: level
                },
                {
                    metaname: "Term",
                    metavalue: term
                }
            ],
            onclose: function() {},
            callback: function(response) {
                var txref = response.data.data.txRef; // collect txRef returned and pass to a server page to complete status check.
                if (
                    response.data.data.chargeResponseCode == "00" ||
                    response.data.data.chargeResponseCode == "0"
                ) {
                    //Log this guy as applied
                    $.ajax({
                        type: "post",
                        url: "/student/finalize_school_fees_payment",
                        data: {
                            _token: $("input[name=_token]").val(),
                            invoice_id: invoice_id,
                            transaction_ref: txref
                        },
                        success: function(response) {
                            if (response.code == 200) {
                        
                                $(".success-message").text(response.message);

                                setTimeout(() => {
                                    window.location.href = response.redirect_url
                                }, 2000);
                                
                                
                            } else if (response.code == 301) {
                                console.log(response.message);
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

        //check if there are fees to be paid
        let id = $("#profile_id").val();
       

        if (
            user_id == "" 
        ) {
            alert("Please fill all fileds");
        } else {
            //Update this guy details and confirm if he is applying for
            //the right scholarship
            // $.ajax({
            //     type: "post",
            //     url: "/student/initate_school_fees_payment",
            //     data: {
            //         _token: $("input[name=_token]").val(),
            //         first_name: first_name,
            //         user_id: user_id
            //     },
            //     success: function(response) {
            //         if (response.code == 200) {
            //             $(".update-successful").removeClass("d-none");
            //             setTimeout(() => {
            //                 payWithRave(email, amount, phone, scholarship_id, user_id);
            //             }, 3000);
            //         } else if (response.code == 301) {
            //             console.log(response.message);
            //             $(".update-error").removeClass("d-none");
            //             setTimeout(() => {
            //                 locacation.reload();
            //             }, 2000);

            //             $(".withdrawal-message").text(
            //                 "You don't have any active investment"
            //             );
            //         }
            //     },
            //     errors: function(error) {
            //         console.log(error.message);
            //     }
            // });
        }
    });
});

function pay(){
    alert("you clicked me")
}